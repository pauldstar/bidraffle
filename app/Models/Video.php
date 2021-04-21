<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperVideo
 */
class Video extends Model
{
    use HasFactory;

    protected $fillable = ['url'];

    /**
     * Number of seconds for a play to become payable
     *
     * @var int
     */
    public const MIN_PLAY_TIME = 60;

    /**
     * Payment (qp) per valid video play
     *
     * @var int
     */
    public const PAYMENT_AMOUNT = 25;
}
