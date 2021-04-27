<?php

namespace App\Policies;

use App\Models\Raffle;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RafflePolicy
{
    use HandlesAuthorization;

    public function bid(?User $user, Raffle $raffle): Response
    {
        if (!$user) {
            return $this->deny(__('raffle.login'));
        }

        if ($raffle->closed) {
            return $this->deny(__('raffle.closed'));
        }

        if ($raffle->in_end_zone) {
            $bid = $raffle->bids()->firstWhere('user_id', $user->id);

            if (!$bid) {
                return $this->deny(__('raffle.too_late'));
            }

            if ($bid->expired) {
                return $this->deny(__('raffle.bid_expired'));
            }
        }

        return $this->allow();
    }
}
