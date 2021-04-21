<?php

namespace App\Services;

use App\Models\Raffle;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RaffleService
{
    public function current(): Raffle
    {
        return Raffle::withBidder(Auth::user())->firstOrCreate(
            ['created_at' => Carbon::today()],
            ['uuid' => Str::uuid(), 'closes_at' => Carbon::tomorrow()]
        );
    }

    /**
     * Current user's previous raffles. Grouped into "won" and " lost".
     *
     * @return Collection
     */
    public function previous(): Collection
    {
        return Auth::user()->raffles->mapToGroups(function ($raffle) {
            $key = $raffle->winner_id === Auth::id() ? 'won' : 'lost';
            return [$key => $raffle];
        });
    }

    /**
     * If current user is winning the raffle
     *
     * @param Raffle $raffle
     * @return bool
     */
    public function winning(Raffle $raffle): bool
    {
        return $raffle->winner_id
            ? $raffle->winner_id === Auth::id()
            : $raffle->winningBidder?->id === Auth::id();
    }
}
