<?php

namespace Database\Factories;

use App\Models\Raffle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class RaffleFactory extends Factory
{
    protected $model = Raffle::class;

    public function definition(): array
    {
        return [
            'bids' => $this->faker->numberBetween(0, 10000),
            'uuid' => $this->faker->uuid,
            'claimed' => $this->faker->boolean
        ];
    }

    public function expired(): self
    {
        return $this->state([
            'created_at' => Carbon::yesterday(),
            'closes_at' => Carbon::today()
        ]);
    }

    public function endZone(): self
    {
        return $this->state([
            'created_at' => Carbon::yesterday(),
            'closes_at' => Carbon::now()->addHour()
        ]);
    }

    public function wonBy(User|int $user, bool $randomise): self
    {
        if ($user instanceof User) {
            $user = $user->id;
        }

        $arr = ['winner_id' => $user];

        return $this->state($randomise
            ? new Sequence($arr, ['winner_id' => null])
            : $arr
        );
    }
}
