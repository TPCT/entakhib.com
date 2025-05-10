<?php

namespace App\Models\District;

use App\Helpers\HasAuthor;
use App\Helpers\HasStatus;
use App\Helpers\HasUploads;
use App\Helpers\WeightedModel;
use App\Models\Candidate\Candidate;
use App\Models\City\City;
use App\Filament\Helpers\Translatable;
use App\Models\Cluster\Cluster;
use App\Models\Profile;
use Filament\Tables\Columns\Concerns\HasWeight;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\District
 *
 * @property int $id
 * @property int $user_id
 * @property int $city_id
 * @property array $title
 * @property int $status
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\City\City $city
 * @method static \Illuminate\Database\Eloquent\Builder|District active()
 * @method static \Illuminate\Database\Eloquent\Builder|District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District query()
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|District wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereUserId($value)
 * @property-read \App\Models\User $user
 * @property-read mixed $translations
 * @property-read \App\Models\District\DistrictLang|null $translation
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|District listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|District notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|District orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|District orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|District orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|District translated()
 * @method static \Illuminate\Database\Eloquent\Builder|District translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|District translations()
 * @method static \Illuminate\Database\Eloquent\Builder|District whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|District whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|District withTranslation(?string $locale = null)
 * @mixin \Eloquent
 */
class District extends WeightedModel implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Translatable, HasAuthor, HasStatus, Auditable, \App\Helpers\HasTranslations, HasWeight;

    public $translationModel = DistrictLang::class;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public array $translatedAttributes = [
        'title'
    ];

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function clusters(){
        return $this->hasMany(Cluster::class);
    }

    public function candidates(){
        return $this->hasMany(Candidate::class);
    }

    public static function getCitiesList(): \Illuminate\Support\Collection
    {
        return City::get()->pluck('title', 'id');
    }

    public function votes(){
        return $this->belongsToMany(Profile::class, 'profile_votes', 'district_id', 'profile_id');
    }
}
