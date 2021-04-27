<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @mixin IdeHelperBid
 */
class Bid extends Pivot
{
    use HasFactory;

    protected $table = 'bids';

    public function getExpiredAttribute(): bool
    {
        return $this->post_count === $this->pre_count;
    }
}
