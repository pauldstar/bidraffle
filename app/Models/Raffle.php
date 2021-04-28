<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * @mixin IdeHelperRaffle
 */
class Raffle extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'created_at', 'closes_at'];

    protected $dates = ['closes_at'];

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function bidders(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bids')
            ->using(Bid::class)
            ->withPivot('pre_count', 'post_count')
            ->withTimestamps();
    }

    /**
     * User currently winning the raffle
     *
     * @return User
     */
    public function getWinningBidderAttribute(): User
    {
        return $this->bidders()
            ->select(DB::raw('pre_count + post_count AS total_count'))
            ->orderByDesc('total_count')
            ->latest('bids.updated_at')
            ->first();
    }

    /**
     * User that won the raffle
     *
     * @return BelongsTo
     */
    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function scopeWithBidder(Builder $query, User|int|string $user = null)
    {
        $user = is_object($user) ? $user->id : $user;

        $user && $query->with([
            'bidders' => fn ($query) => $query->where('user_id', $user)
        ]);
    }

    public function getOriginalClosesAtAttribute(): Carbon
    {
        return $this->created_at->addDay();
    }

    public function getClosedAttribute(): bool
    {
        return $this->closes_at->isPast();
    }

    public function getOngoingAttribute(): bool
    {
        return $this->closes_at->isFuture();
    }

    public function getInEndZoneAttribute(): bool
    {
        return $this->ongoing && $this->original_closes_at->isPast();
    }
}
