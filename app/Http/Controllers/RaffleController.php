<?php

namespace App\Http\Controllers;

use App\Models\Raffle;
use App\Services\RaffleService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class RaffleController extends Controller
{
    public function __invoke(RaffleService $service, string $uuid = null): View
    {
        $raffle = $uuid
            ? Raffle::with('winner:id,name')->firstWhere('uuid', $uuid)
            : $service->current();

        $data['raffle'] = $raffle;

        if (Auth::check()) {
            $previousRaffles = $service->previous();

            $data['wonRaffles'] = $previousRaffles->get('won');
            $data['lostRaffles'] = $previousRaffles->get('lost');
            $data['hasBid'] = $raffle->bidders->isNotEmpty();
            $data['isWinning'] = $service->winning($raffle);
        }

        return view('raffle', $data);
    }
}
