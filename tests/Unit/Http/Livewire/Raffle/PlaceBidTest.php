<?php

namespace Tests\Unit\Http\Livewire\Raffle;

use App\Http\Livewire\Raffle as RaffleComponent;
use App\Models\Bid;
use App\Models\Raffle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class PlaceBidTest extends TestCase
{
    use DatabaseTransactions;

    public function testMultiplayerBids()
    {
        $users = User::factory(3)->create();
        $raffle = Raffle::factory()->create();
        // create bid for each user
        $bids = [];
        $bidPreCounts = [];
        $bidPostCounts = [];

        foreach ($users as $user) {
            $bids[] = Bid::create(['user_id' => $user->id, 'raffle_id' => $raffle->id]);
            $bidPreCounts[] = 0;
            $bidPostCounts[] = 0;
        }

        foreach (range(1, 30) as $rx => $round) {
            $endZone = $round > 15;
            $endZone && $raffle->update(['created_at' => Carbon::yesterday()]);

            $biddingUser = $users[$rx % 3];
            $this->be($biddingUser);

            Livewire::test(
                RaffleComponent::class,
                ['uuid' => $raffle->uuid]
            )->call('bid');

            foreach ($users as $ux => $user) {
                $this->be($user);
                $bid = $bids[$ux];

                $livewire = Livewire::test(
                    RaffleComponent::class,
                    ['uuid' => $raffle->uuid]
                );

                if ($biddingUser->id === $user->id) {
                    $livewire->assertSet('hasBid', true)->assertSet('isWinning', true);
                    $bidCount = $endZone ? 'bidPostCounts' : 'bidPreCounts';
                    $$bidCount[$ux]++;
                } else {
                    $livewire->assertSet('isWinning', false);
                }

                $bid->refresh();
                $this->assertEquals($bidPreCounts[$ux], $bid->pre_count, 'pre-count');
                $this->assertEquals($bidPostCounts[$ux], $bid->post_count, 'post-count');
            }

            sleep(1);
        }
    }

    public function testSinglePlayerBids()
    {
        $user = User::factory()->create();
        $this->be($user);

        $raffle = Raffle::factory()->create();

        $bid = Bid::create(['user_id' => $user->id, 'raffle_id' => $raffle->id]);
        $this->assertEmpty($bid->pre_count);

        $livewire = Livewire::test(RaffleComponent::class, ['uuid' => $raffle->uuid]);

        foreach (range(1, 110) as $round) {
            $endZone = $round > 50 && $round <= 100;
            $expired = $round > 100;
            $message = $round <= 100 ? 'raffle.bid_successful' : 'raffle.bid_expired';
            $status = $round <= 100 ? 'success' : 'error';
            $preCount = ($endZone || $expired) ? 50 : $round;
            $postCount = $expired ? 50 : ($endZone ? $round - 50 : 0);

            $endZone && $raffle->update(['created_at' => Carbon::yesterday()]);

            $livewire->call('bid')
                ->assertEmitted('trigger-toast', $status, __($message))
                ->assertSet('hasBid', true)
                ->assertSet('isWinning', true);

            $bid->refresh();
            $this->assertEquals($preCount, $bid->pre_count, 'pre-count');
            $this->assertEquals($postCount, $bid->post_count, 'post-count');
        }
    }

    public function testCantBidAfterBidExpires()
    {
        $raffle = Raffle::factory()->endZone()->create();
        $user = User::factory()->create();

        $user->raffles()->sync([
            $raffle->id => ['pre_count' => 5, 'post_count' => 5]
        ]);

        $this->be($user);

        Livewire::test(RaffleComponent::class, ['uuid' => $raffle->uuid])
            ->call('bid')
            ->assertEmitted('trigger-toast', 'error', __('raffle.bid_expired'));
    }

    public function testCantStartBiddingEndZoneRaffle()
    {
        $raffle = Raffle::factory()->endZone()->create();
        $this->be(User::factory()->create());

        Livewire::test(RaffleComponent::class, ['uuid' => $raffle->uuid])
            ->call('bid')
            ->assertEmitted('trigger-toast', 'error', __('raffle.too_late'));
    }

    public function testCantBidClosedRaffle()
    {
        $raffle = Raffle::factory()->expired()->create();
        $this->be(User::factory()->create());

        Livewire::test(RaffleComponent::class, ['uuid' => $raffle->uuid])
            ->call('bid')
            ->assertEmitted('trigger-toast', 'error', __('raffle.closed'));
    }

    public function testGuestCantBid()
    {
        Livewire::test(RaffleComponent::class)
            ->call('bid')
            ->assertEmitted('trigger-toast', 'error', __('raffle.login'));
    }
}
