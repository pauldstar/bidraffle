<?php

namespace Tests\Feature\Services;

use App\Http\Controllers\RaffleController;
use App\Models\Bid;
use App\Models\Raffle;
use App\Models\User;
use App\Services\RaffleService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use ReflectionException;
use Tests\ReflectionHelper;
use Tests\TestCase;

class RaffleServiceTest extends TestCase
{
    use DatabaseTransactions;

    private RaffleService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new RaffleService();
    }

    public function testPreviousUserRaffles()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Raffle::factory()->count(10)
            ->hasAttached($user, [], 'bidders')
            ->wonBy($user, true)
            ->create();

        $raffles = $this->service->usersPrevious();

        $raffles->get('won')->each(
            fn (Raffle $raffle) => $this->assertEquals($user->id, $raffle->winner_id)
        );

        $raffles->get('lost')->each(
            fn (Raffle $raffle) => $this->assertNotEquals($user->id, $raffle->winner_id)
        );
    }

    public function testRetrievingCurrentOrNewRaffle()
    {
        $raffle = Raffle::factory()->expired()->create();
        $newRaffle = $this->service->current();
        $this->assertNotEquals($raffle->id, $newRaffle->id);
        $this->assertEquals($newRaffle->id, $this->service->current()->id);
    }
}
