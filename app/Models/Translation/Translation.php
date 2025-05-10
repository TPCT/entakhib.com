<?php

namespace App\Models\Translation;

use App\Filament\Helpers\Translatable;
use App\Helpers\HasAuthor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Translation
 *
 * @property int $id
 * @property int $user_id
 * @property int $translation_category_id
 * @property string $lang
 * @property string $key
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\Translation\TranslationCategory|null $category
 * @method static \Illuminate\Database\Eloquent\Builder|Translation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereTranslationCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereLocales(string $column, array $locales)
 * @property-read \App\Models\User $user
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @property-read \App\Models\Translation\TranslationLang|null $translation
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Translation listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Translation translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation translations()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation withTranslation(?string $locale = null)
 * @mixin \Eloquent
 */
class Translation extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, HasAuthor, Auditable, \App\Helpers\HasTranslations, Translatable;

    public $translationModel = TranslationLang::class;
    public array $translatedAttributes = [
        'content'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TranslationCategory::class, 'translation_category_id', 'id');
    }
}
