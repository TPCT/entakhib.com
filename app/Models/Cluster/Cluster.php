<?php

namespace App\Models\Cluster;

use App\Filament\Helpers\Translatable;
use App\Helpers\HasAuthor;
use App\Helpers\HasMedia;
use App\Helpers\HasSearch;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\HasTimestamps;
use App\Helpers\HasTranslations;
use App\Helpers\WeightedModel;
use App\Models\Candidate\Candidate;
use App\Models\City\City;
use App\Models\District\District;
use App\Models\Profile;
use Filament\Tables\Columns\Concerns\HasWeight;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Cluster\Cluster
 *
 * @property int $id
 * @property int $user_id
 * @property int $city_id
 * @property int $district_id
 * @property string|null $slug
 * @property int $weight
 * @property int $status
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read City $city
 * @property-read District $district
 * @property-read \Awcodes\Curator\Models\Media|null $media
 * @property-read \App\Models\Seo\Seo $seo
 * @property-read \App\Models\Cluster\ClusterLang|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cluster\ClusterLang> $translations
 * @property-read int|null $translations_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster active()
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster translations()
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster withTranslation(?string $locale = null)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Candidate> $candidates
 * @property-read int|null $candidates_count
 * @mixin \Eloquent
 */
class Cluster extends WeightedModel implements Auditable
{
    use HasFactory, \App\Helpers\HasTranslations, HasAuthor, HasStatus, HasMedia, \OwenIt\Auditing\Auditable, \App\Helpers\HasSeo, HasSlug, HasTimestamps, HasSearch, Translatable;

    public $translationModel = ClusterLang::class;

    public array $translatedAttributes = [
        'title',
        'second_title',
        'description',
        'thumbnail_image_id',
        'image_id',
        'header_image_id',
        'header_image_title',
        'header_image_description'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public array $upload_attributes = [
        'image_id', 'header_image_id', 'thumbnail_image_id', 'image_title', 'image_description'
    ];

    public function candidates(){
        return $this->hasMany(
            Candidate::class, 'cluster_id', 'id'
        )->where('candidate_type', Candidate::CLUSTER_CANDIDATE);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public static function getCities(){
        return City::all()->pluck('title', 'id');
    }

    public static function getDistricts($city_id){
        return City::whereId($city_id)->first()?->districts?->pluck('title', 'id');
    }

    public function profile_votes(){
        return $this->belongsToMany(Cluster::class, 'profile_votes', 'cluster_id', 'cluster_id');
    }

    public static function boot()
    {
        parent::boot();
        parent::deleted(function ($model) {
            $model->profile_votes()->delete();
            $model->candidates()->delete();
        });
    }
}
