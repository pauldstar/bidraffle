<?php

namespace App\Http\Controllers;

use App\Models\Raffle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class RaffleController extends Controller
{
    public function __invoke(string $uuid = null)
    {
        $mainRaffle = $uuid ? Raffle::find($uuid) : Raffle::currentOrNew();
        $data['raffle'] = $mainRaffle;

        if (Auth::check()) {
            $previousRaffles =
                Auth::user()->raffles()->whereKeyNot($mainRaffle->id)->get();

            $grouped = $this->raffleGroups($previousRaffles);
            $wonRaffles = $grouped->get('won');
            $lostRaffles = $grouped->get('lost');

            $data['wonRaffles'] = $wonRaffles;
            $data['lostRaffles'] = $lostRaffles;
        }

        return view('raffle', $data);
    }

    private function raffleGroups(Collection $raffles): \Illuminate\Support\Collection
    {
        $userId = Auth::id();

        return $raffles->mapToGroups(
            function ($raffle) use ($userId) {
                $key = $raffle->winner === $userId ? 'won' : 'lost';
                return [$key => $raffle];
            }
        );
    }
}
