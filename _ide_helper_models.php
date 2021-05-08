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
 * @mixin IdeHelperBid
 * @property int $id
 * @property int $raffle_id
 * @property int $user_id
 * @property int $pre_count
 * @property int $post_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read bool $expired
 * @method static \Illuminate\Database\Eloquent\Builder|Bid newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bid newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bid query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid wherePostCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid wherePreCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereRaffleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereUserId($value)
 */
	class IdeHelperBid extends \Eloquent {}
}

namespace App\Models{

    use Illuminate\Database\Eloquent\Builder;

    /**
 * App\Models\Raffle
 *
 * @mixin IdeHelperRaffle
 * @property int $id
 * @property string $uuid
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Bid[] $bids
 * @property int|null $winner_id
 * @property int $claimed
 * @property Carbon $closes_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $bidders
 * @property-read int|null $bidders_count
 * @property-read int|null $bids_count
 * @property-read bool $closed
 * @property-read bool $in_end_zone
 * @property-read bool $ongoing
 * @property-read Carbon $original_closes_at
 * @property-read \App\Models\User $winning_bidder
 * @property-read \App\Models\User|null $winner
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
 */
	class IdeHelperRaffle extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @mixin IdeHelperUser
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
 */
	class IdeHelperUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Video
 *
 * @mixin IdeHelperVideo
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
 */
	class IdeHelperVideo extends \Eloquent {}
}

