<?php

namespace App\Models\Candidate;

use App\Filament\Helpers\Translatable;
use App\Helpers\HasAuthor;
use App\Helpers\HasMedia;
use App\Helpers\HasSearch;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\HasTimestamps;
use App\Helpers\WeightedModel;
use App\Models\City\City;
use App\Models\Cluster\Cluster;
use App\Models\District\District;
use App\Models\Candidate\CandidateLang;
use App\Models\Party\Party;
use App\Models\Profile;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Candidate\Candidate
 *
 * @property int $id
 * @property int $user_id
 * @property string $candidate_type
 * @property int|null $party_id
 * @property int|null $cluster_id
 * @property int $image_id
 * @property int $votes
 * @property string|null $phone_1
 * @property string|null $phone_2
 * @property string|null $facebook_link
 * @property string|null $instagram_link
 * @property string|null $twitter_link
 * @property string|null $youtube_link
 * @property float|null $election_location_longitude
 * @property float|null $election_location_latitude
 * @property string|null $video_url
 * @property string $slug
 * @property int $weight
 * @property int $status
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $city_id
 * @property int $district_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read City $city
 * @property-read Cluster|null $cluster
 * @property-read District $district
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Media> $images
 * @property-read int|null $images_count
 * @property-read Media|null $media
 * @property-read Party|null $party
 * @property-read \App\Models\Seo\Seo $seo
 * @property-read CandidateLang|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, CandidateLang> $translations
 * @property-read int|null $translations_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate active()
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate translations()
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereCandidateType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereClusterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereElectionLocationLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereElectionLocationLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereFacebookLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereInstagramLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate wherePartyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate wherePhone1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate wherePhone2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereTwitterLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereVideoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereVotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereYoutubeLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate withTranslation(?string $locale = null)
 * @property string $election_location
 * @property-read mixed $pdf
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate whereElectionLocation($value)
 * @mixin \Eloquent
 */
class Candidate extends WeightedModel implements Auditable
{

    public const PARTY_CANDIDATE = "Party Candidate";
    public const CLUSTER_CANDIDATE = "Cluster Candidate";

    public static function getCandidateTypes(){
        return [
            self::PARTY_CANDIDATE => __(self::PARTY_CANDIDATE),
            self::CLUSTER_CANDIDATE => __(self::CLUSTER_CANDIDATE),
        ];
    }

    use HasFactory, \App\Helpers\HasTranslations, HasAuthor, HasStatus, \OwenIt\Auditing\Auditable, \App\Helpers\HasSeo, HasSlug, HasTimestamps, HasSearch, Translatable, HasMedia;

    public $translationModel = CandidateLang::class;

    public array $translatedAttributes = [
        'title',
        'slogan',
        'election_program_description',
        'description',
        'external_brief',
        'election_location_description',
        'election_program_link_id',
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public array $upload_attributes = [
        'image_id', 'election_program_link_id'
    ];

    protected $appends = ['pdf'];

    public function getPdfAttribute()
    {
        return $this->hasOne(Media::class, 'id', 'election_program_link_id')->first()?->path;
    }
    public function images(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->
            belongsToMany(Media::class, 'candidate_images', 'parent_id', 'media_id')
            ->withPivot('order')->orderBy('order');
    }

    public function cluster(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cluster::class);
    }

    public function party(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    public static function getPartiesList(){
        return Party::all()->pluck('title', 'id');
    }

    public static function getClustersList(){
        return Cluster::all()->pluck('title', 'id');
    }

//    public static function getCities(){
//        return City::all()->pluck('title', 'id');
//    }

//    public static function getDistricts($city_id){
//        return District::all()->where('city_id', $city_id)->pluck('title', 'id');
//    }

//    public function city(){
//        return $this->belongsTo(City::class);
//    }

//    public function district(){
//        return $this->belongsTo(District::class);
//    }

    public function profile_votes(){
        return $this->belongsToMany(Profile::class, 'profile_votes', 'candidate_id', 'profile_id');
    }
}
