<?php

namespace App\Models\Faq;

use App\Helpers\HasAuthor;
use App\Helpers\HasStatus;
use App\Helpers\WeightedModel;
use App\Filament\Helpers\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Faq
 *
 * @property int $id
 * @property array $title
 * @property array|null $description
 * @property int $promote_to_homepage
 * @property int $user_id
 * @property string $published_at
 * @property int $status
 * @property int $weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Faq active()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq query()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq wherePromoteToHomepage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereWeight($value)
 * @property string|null $image
 * @property int $is_video
 * @property array|null $video_url
 * @property mixed $0
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereIsVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereVideoUrl($value)
 * @property-read mixed $translations
 * @property-read \App\Models\Faq\FaqLang|null $translation
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Faq listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Faq translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq translations()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq withTranslation(?string $locale = null)
 * @mixin \Eloquent
 */
class Faq extends WeightedModel implements Auditable
{
    use HasFactory, HasStatus, HasAuthor, \OwenIt\Auditing\Auditable, \App\Helpers\HasTranslations, Translatable;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public $translationModel = FaqLang::class;

    public array $translatedAttributes = [
        'title',
        'description'
    ];
}
