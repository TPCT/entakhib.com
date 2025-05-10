<?php

namespace App\Models\Slider;

use App\Helpers\HasAuthor;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\HasUploads;
use App\Filament\Helpers\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Slider
 *
 * @property int $id
 * @property int $user_id
 * @property int $dropdown_id
 * @property string|null $image
 * @property string|null $icon
 * @property array $title
 * @property array $second_title
 * @property array $description
 * @property int $status
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @method static \Illuminate\Database\Eloquent\Builder|Slider active()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereDropdownId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereSecondTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUserId($value)
 * @property string $slides
 * @property string $slug
 * @property-read \App\Models\Dropdown\Dropdown $dropdown
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereSlides($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereSlug($value)
 * @property array|null $bullets
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereBullets($value)
 * @property string $category
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCategory($value)
 * @property-read \App\Models\User $user
 * @property-read mixed $translations
 * @property-read \App\Models\Slider\SliderLang|null $translation
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Slider listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Slider translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider translations()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider withTranslation(?string $locale = null)
 * @mixin \Eloquent
 */

class Slider extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, HasAuthor, Auditable, HasStatus, Translatable, \App\Helpers\HasTranslations, HasSlug;

    public const HOMEPAGE_SLIDER = "Homepage Slider";
    public $translationModel = SliderLang::class;

    public static function getCategories(){
        return [
            self::HOMEPAGE_SLIDER => __(self::HOMEPAGE_SLIDER),
        ];
    }

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

//    protected $casts = [
//        'slides' => 'array',
//    ];

    public array $translatedAttributes = [
        'title', 'description'
    ];

    public function slides(){
        return $this->hasMany(SliderSlide::class);
    }
}
