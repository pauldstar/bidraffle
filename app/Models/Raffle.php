<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Raffle extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'created_at', 'closes_at'];

    protected $dates = ['closes_at'];

    public static function currentOrNew()
    {
        return self::query()->firstOrCreate(
            ['created_at' => Carbon::today()],
            ['uuid' => Str::uuid(), 'closes_at' => Carbon::tomorrow()]
        );
    }

    public function bidders(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bids')
            ->using(Bid::class)
            ->withPivot('pre_count', 'post_count')
            ->withTimestamps();
    }

    public function winner(): BelongsToMany
    {
        return $this->bidders()
            ->select('pre_count + post_count AS total_count')
            ->orderByDesc('total_count')
            ->latest('updated_at');
    }

    public function getOriginalClosesAtAttribute()
    {
        return $this->created_at->addDay();
    }
}
