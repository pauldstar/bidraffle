<?php

namespace App\Http\Livewire;

use App\Models\Raffle as RaffleModel;
use App\Services\RaffleService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Raffle extends Component
{
    private RaffleService $service;

    public RaffleModel $raffle;
    public ?Collection $previousRaffles;

    public function mount(string $uuid = null)
    {
        $this->service = new RaffleService();

        $this->raffle = $uuid
            ? RaffleModel::with('winner:id,name')->firstWhere('uuid', $uuid)
            : $this->service->current();

        $this->previousRaffles = Auth::check() ? $this->service->previous() : null;
    }

    public function getWonRafflesProperty()
    {
        return $this->previousRaffles->get('won');
    }

    public function getLostRafflesProperty()
    {
        return $this->previousRaffles->get('lost');
    }

    public function getHasBidProperty(): bool
    {
        return $this->raffle->bidders->isNotEmpty();
    }

    public function getIsWinningProperty(): bool
    {
        return $this->service->winning($this->raffle);
    }

    public function getBidButtonColorProperty(): string
    {
        return $this->hasBid
            ? ($this->isWinning ? 'success' : 'danger')
            : 'primary';
    }

    public function getBidButtonStatusProperty(): string
    {
        return $this->hasBid
            ? ($this->isWinning ? 'Winning' : 'Losing')
            : 'Join';
    }
}
