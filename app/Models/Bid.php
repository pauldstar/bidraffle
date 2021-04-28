<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

/**
 * @mixin IdeHelperBid
 */
class Bid extends Model
{
    use AsPivot;

    protected $table = 'bids';

    protected $fillable = [
        'raffle_id',
        'user_id',
        'pre_count',
        'post_count'
    ];

    public function getExpiredAttribute(): bool
    {
        return $this->post_count === $this->pre_count;
    }
}
