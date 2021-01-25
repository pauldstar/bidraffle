<?php

namespace Tests\Feature;

use App\Http\Controllers\RaffleController;
use App\Models\Raffle;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use ReflectionException;
use Tests\ReflectionHelper;
use Tests\TestCase;

class RaffleTest extends TestCase
{
    use DatabaseTransactions;
    use ReflectionHelper;

    /**
     * @throws ReflectionException
     */
    public function testRaffleGroups()
    {
        $userId = 3;

        $raffles = Raffle::factory()->count(10)->wonBy($userId, true)->make();

        $fnRaffleGroup = $this->getPrivateMethodInvoker(
            new RaffleController(), 'raffleGroups'
        );

        $this->actingAs(User::factory()->withId($userId)->make());

        $raffleGroups = $fnRaffleGroup($raffles);

        $raffleGroups->get('won')->each(function (Raffle $raffle) use ($userId) {
            $this->assertEquals($userId, $raffle->winner);
        });

        $raffleGroups->get('lost')->each(function (Raffle $raffle) use ($userId) {
            $this->assertNotEquals($userId, $raffle->winner);
        });
    }

    public function testRetrievingCurrentOrNewRaffle()
    {
        $raffle = Raffle::factory()->expired()->create();
        $newRaffle = Raffle::currentOrNew();
        $this->assertNotEquals($raffle->id, $newRaffle->id);
        $this->assertEquals($newRaffle->id, Raffle::currentOrNew()->id);
    }
}
