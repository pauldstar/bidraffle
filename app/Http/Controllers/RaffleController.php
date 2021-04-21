<?php

namespace App\Http\Controllers;

use App\Models\Raffle;
use App\Services\RaffleService;
use Illuminate\Support\Facades\Auth;

class RaffleController extends Controller
{
    public function __invoke(string $uuid = null)
    {
        $mainRaffle = $uuid ? Raffle::firstWhere('uuid', $uuid) : Raffle::currentOrNew();
        $data['raffle'] = $mainRaffle;

        if (Auth::check()) {
            $previousRaffles = Auth::user()->raffles()->whereKeyNot($mainRaffle->id)->get();

            $grouped = $this->raffleGroups($previousRaffles);
            $wonRaffles = $grouped->get('won');
            $lostRaffles = $grouped->get('lost');

            $data['wonRaffles'] = $wonRaffles;
            $data['lostRaffles'] = $lostRaffles;
        }

        return view('raffle', $data);
    }
}
