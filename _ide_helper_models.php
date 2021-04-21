<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Bid
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Bid newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bid newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bid query()
 * @mixin \Eloquent
 */
	class IdeHelperBid extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Raffle
 *
 * @property int $id
 * @property string $uuid
 * @property int $bids
 * @property int|null $winner_id
 * @property int $claimed
 * @property \Illuminate\Support\Carbon $closes_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $bidders
 * @property-read int|null $bidders_count
 * @property-read mixed $original_closes_at
 * @property-read \App\Models\User $winningBidder
 * @property-read int|null $winning_bidder_count
 * @method static \Database\Factories\RaffleFactory factory(...$parameters)
 * @method static Builder|Raffle newModelQuery()
 * @method static Builder|Raffle newQuery()
 * @method static Builder|Raffle query()
 * @method static Builder|Raffle whereBids($value)
 * @method static Builder|Raffle whereClaimed($value)
 * @method static Builder|Raffle whereClosesAt($value)
 * @method static Builder|Raffle whereCreatedAt($value)
 * @method static Builder|Raffle whereId($value)
 * @method static Builder|Raffle whereUpdatedAt($value)
 * @method static Builder|Raffle whereUuid($value)
 * @method static Builder|Raffle whereWinnerId($value)
 * @method static Builder|Raffle withBidder(\App\Models\User|string|int|null $user = null)
 * @mixin \Eloquent
 */
	class IdeHelperRaffle extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Raffle[] $raffles
 * @property-read int|null $raffles_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Video
 *
 * @property int $id
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video query()
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereUrl($value)
 * @mixin \Eloquent
 */
	class IdeHelperVideo extends \Eloquent {}
}

