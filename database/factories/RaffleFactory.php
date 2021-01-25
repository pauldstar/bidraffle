<?php

namespace Database\Factories;

use App\Models\Raffle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class RaffleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Raffle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
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

    /**
     * @param User|int $user
     * @return $this
     */
    public function wonBy($user, bool $randomise): self
    {
        if ($user instanceof User) {
            $user = $user->id;
        }

        $arr = ['winner' => $user];

        return $this->state($randomise
            ? new Sequence($arr, ['winner' => null])
            : $arr
        );
    }
}
