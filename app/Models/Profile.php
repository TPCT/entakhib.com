<?php

namespace App\Models;

use App\Helpers\HasOtp;
use App\Models\Candidate\Candidate;
use App\Models\City\City;
use App\Models\Cluster\Cluster;
use App\Models\District\District;
use App\Models\Party\Party;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Profile
 *
 * @property int $id
 * @property string $full_name
 * @property string $phone_number
 * @property string $date_of_birth
 * @property string $place_of_residence
 * @property string $district
 * @property string|null $email
 * @property string|null $otp
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile wherePlaceOfResidence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Profile extends \Illuminate\Foundation\Auth\User implements Auditable
{
    use HasFactory, Notifiable, HasOtp, \OwenIt\Auditing\Auditable;

    public const PARTY = "party";
    public const CLUSTER = "cluster";

    protected $guard = "profile";
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
    protected $hidden = [
        'otp', 'remember_token'
    ];

    public function party_votes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Party::class, 'profile_votes', 'profile_id', 'party_id');
    }

    public function candidate_votes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Candidate::class, 'profile_votes', 'profile_id', 'candidate_id');
    }

    public function cluster_votes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Cluster::class, 'profile_votes', 'profile_id', 'cluster_id');
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }
}
