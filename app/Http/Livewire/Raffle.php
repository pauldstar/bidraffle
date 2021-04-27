<?php

namespace App\Http\Livewire;

use App\Models\Raffle as RaffleModel;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Raffle extends BaseComponent
{
    public RaffleModel $raffle;
    public ?Collection $previousRaffles;

    public function mount(string $uuid = null)
    {
        $this->raffle = $uuid
            ? RaffleModel::with('winner:id,name')->firstWhere('uuid', $uuid)
            : $this->currentRaffle();

        $this->previousRaffles = Auth::check() ? $this->previousRaffles() : null;
    }

    public function currentRaffle(): RaffleModel
    {
        return RaffleModel::withBidder(Auth::user())->firstOrCreate(
            ['created_at' => Carbon::today()],
            ['uuid' => Str::uuid(), 'closes_at' => Carbon::tomorrow()]
        );
    }

    public function previousRaffles(): Collection
    {
        return Auth::user()->raffles->mapToGroups(function ($raffle) {
            $key = $raffle->winner_id === Auth::id() ? 'won' : 'lost';
            return [$key => $raffle];
        });
    }

    public function bid()
    {
        try {
            $this->authorize('bid', $this->raffle);

            DB::transaction(function () {
                $bid = $this->raffle->bids()->firstOrCreate(['user_id' => Auth::id()]);
                $bid->increment($this->raffle->in_end_zone ? 'post_count' : 'pre_count');
            });

            $this->successToast('Bid placed');
        } catch (AuthorizationException $e) {
            $this->errorToast($e->getMessage());
        }
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
        return $this->raffle->winner_id
            ? $this->raffle->winner_id === Auth::id()
            : $this->raffle->winningBidder?->id === Auth::id();
    }

    public function getBidButtonColorProperty(): string
    {
        return $this->hasBid
            ? ($this->isWinning ? 'success' : 'danger')
            : 'info';
    }

    public function getBidButtonStatusProperty(): string
    {
        return $this->hasBid
            ? ($this->isWinning ? 'Winning' : 'Losing')
            : 'Enter';
    }
}
