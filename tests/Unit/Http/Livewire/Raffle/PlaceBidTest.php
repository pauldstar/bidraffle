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

    // ToDo: correct user is picked as winning_bidder
    // ToDo: bid successful post end zone

    public function testSinglePlayerBids()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $raffle = Raffle::factory()->create();
        $user->raffles()->sync($raffle->id);

        $bid = Bid::firstWhere(['user_id' => $user->id, 'raffle_id' => $raffle->id]);
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

            ->assertSet('isWinning', true);
    }

    public function testCantBidAfterBidExpires()
    {
        $raffle = Raffle::factory()->endZone()->create();
        $user = User::factory()->create();

        $user->raffles()->sync([
            $raffle->id => ['pre_count' => 5, 'post_count' => 5]
        ]);

        $this->actingAs($user);

        Livewire::test(RaffleComponent::class, ['uuid' => $raffle->uuid])
            ->call('bid')
            ->assertEmitted('trigger-toast', 'error', __('raffle.bid_expired'));
    }

    public function testCantStartBiddingEndZoneRaffle()
    {
        $raffle = Raffle::factory()->endZone()->create();
        $this->actingAs(User::factory()->create());

        Livewire::test(RaffleComponent::class, ['uuid' => $raffle->uuid])
            ->call('bid')
            ->assertEmitted('trigger-toast', 'error', __('raffle.too_late'));
    }

    public function testCantBidClosedRaffle()
    {
        $raffle = Raffle::factory()->expired()->create();
        Livewire::actingAs(User::factory()->create());

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
