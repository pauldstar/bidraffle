<?php

namespace Tests\Feature\Http\Livewire;

use App\Models\Raffle;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RaffleTest extends TestCase
{
    use DatabaseTransactions;

    public function testPreviousUserRaffles()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Raffle::factory()->count(10)
            ->hasAttached($user, [], 'bidders')
            ->wonBy($user, true)
            ->create();

        $livewire = new \App\Http\Livewire\Raffle();

        $raffles = $livewire->previousRaffles();

        $raffles->get('won')->each(
            fn (Raffle $raffle) => $this->assertEquals($user->id, $raffle->winner_id)
        );

        $raffles->get('lost')->each(
            fn (Raffle $raffle) => $this->assertNotEquals($user->id, $raffle->winner_id)
        );
    }

    public function testRetrievingCurrentOrNewRaffle()
    {
        $livewire = new \App\Http\Livewire\Raffle();

        $raffle = Raffle::factory()->expired()->create();
        $newRaffle = $livewire->currentRaffle();

        $this->assertNotEquals($raffle->id, $newRaffle->id);
        $this->assertEquals($newRaffle->id, $livewire->currentRaffle()->id);
    }
}
