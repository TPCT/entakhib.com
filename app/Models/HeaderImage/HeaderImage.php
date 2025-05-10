<?php

namespace App\Models\HeaderImage;

use App\Helpers\HasAuthor;
use App\Helpers\HasMedia;
use App\Helpers\HasStatus;
use App\Helpers\HasUploads;
use App\Filament\Helpers\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\HeaderImage
 *
 * @property int $id
 * @property int $user_id
 * @property string $path
 * @property array $image
 * @property array $title
 * @property array $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage active()
 * @property-read \App\Models\User $user
 * @property-read mixed $translations
 * @property-read \App\Models\HeaderImage\HeaderImageLang|null $translation
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage translated()
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage translations()
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage withTranslation(?string $locale = null)
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|HeaderImage whereStatus($value)
 * @mixin \Eloquent
 */
class HeaderImage extends Model implements Auditable
{
    use HasFactory, HasStatus, HasAuthor, \OwenIt\Auditing\Auditable, \App\Helpers\HasTranslations, Translatable, HasMedia;

    public $translationModel = HeaderImageLang::class;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public array $translatedAttributes = [
        'title', 'description', 'image_id'
    ];

      public array $upload_attributes = [
          'image_id'
      ];
}
