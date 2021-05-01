<?php

namespace Tests\Unit\Http\Livewire\Raffle;

use App\Http\Livewire\Raffle as RaffleComponent;
use App\Models\Bid;
use App\Models\Raffle;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class PlaceBidTest extends TestCase
{
    use DatabaseTransactions;

    public function testBidSuccessfulPreEndZone()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $raffle = Raffle::factory()->create();
        $user->raffles()->sync($raffle->id);

        $bid = Bid::firstWhere(['user_id' => $user->id, 'raffle_id' => $raffle->id]);
        $this->assertEmpty($bid->pre_count);

        $this->bid($raffle);
        $bid->refresh();
        $this->assertEquals(1, $bid->pre_count);

        $this->bid($raffle);
        $bid->refresh();
        $this->assertEquals(2, $bid->pre_count);

        $this->bid($raffle);
        $bid->refresh();
        $this->assertEquals(3, $bid->pre_count);
    }

    private function bid(Raffle $raffle)
    {
        Livewire::test(RaffleComponent::class, ['uuid' => $raffle->uuid])
            ->call('bid')
            ->assertEmitted('trigger-toast', 'success', __('raffle.bid_successful'))
            ->assertSet('hasBid', true)
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
