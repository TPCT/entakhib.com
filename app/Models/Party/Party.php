<?php

namespace App\Models\Party;

use App\Filament\Helpers\Translatable;
use App\Helpers\HasAuthor;
use App\Helpers\HasMedia;
use App\Helpers\HasSearch;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\HasTimestamps;
use App\Helpers\WeightedModel;
use App\Models\Candidate\Candidate;
use App\Models\Cluster\Cluster;
use Awcodes\Curator\Models\Media;
use Filament\Tables\Columns\Concerns\HasWeight;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Party\Party
 *
 * @property int $id
 * @property int $user_id
 * @property string $slug
 * @property int $weight
 * @property int $status
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read Media|null $media
 * @property-read \App\Models\Seo\Seo $seo
 * @property-read \App\Models\Party\PartyLang|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Party\PartyLang> $translations
 * @property-read int|null $translations_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Party active()
 * @method static \Illuminate\Database\Eloquent\Builder|Party listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Party newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Party newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Party notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Party orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Party orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Party orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Party query()
 * @method static \Illuminate\Database\Eloquent\Builder|Party translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Party translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Party translations()
 * @method static \Illuminate\Database\Eloquent\Builder|Party whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Party whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Party wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Party whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Party whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Party whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Party whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Party whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Party whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Party whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Party withTranslation(?string $locale = null)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Candidate> $candidates
 * @property-read int|null $candidates_count
 * @mixin \Eloquent
 */
class Party extends WeightedModel implements Auditable
{
    use HasFactory, \App\Helpers\HasTranslations, HasMedia, HasAuthor, HasStatus, \OwenIt\Auditing\Auditable, \App\Helpers\HasSeo, HasSlug, HasTimestamps, HasSearch, Translatable, HasWeight;

    public $translationModel = PartyLang::class;

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

    public array $upload_attributes = [
        'image_id', 'header_image_id', 'thumbnail_image_id'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function candidates(){
        return $this->hasMany(Candidate::class, 'party_id', 'id')->where('candidate_type', Candidate::PARTY_CANDIDATE);
    }

    public static function boot()
    {
        parent::boot();
        parent::deleted(function () {
            $model->candidates()->delete();
        });
    }
}
