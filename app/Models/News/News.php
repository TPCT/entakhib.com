<?php

namespace App\Models\News;

use App\Helpers\HasAuthor;
use App\Helpers\HasLingual;
use App\Helpers\HasMedia;
use App\Helpers\HasSearch;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\HasTimestamps;
use App\Helpers\HasUploads;
use App\Helpers\WeightedModel;
use App\Models\Dropdown\Dropdown;
use App\Filament\Helpers\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\News
 *
 * @property int $id
 * @property string|null $image
 * @property array $title
 * @property array|null $description
 * @property array|null $content
 * @property array|null $header_image
 * @property array|null $header_title
 * @property array|null $header_description
 * @property int $user_id
 * @property string $slug
 * @property string $published_at
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\Seo\Seo $seo
 * @method static \Illuminate\Database\Eloquent\Builder|News active()
 * @method static \Illuminate\Database\Eloquent\Builder|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News query()
 * @method static \Illuminate\Database\Eloquent\Builder|News whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereHeaderDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereHeaderImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereHeaderTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|News wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUserId($value)
 * @property string $slider
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSlider($value)
 * @property-read \App\Models\User $user
 * @property int $category_id
 * @property int $heading_news
 * @property-read \App\Models\Dropdown\Dropdown $category
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereHeadingNews($value)
 * @property-read mixed $translations
 * @property int $weight
 * @method static \Illuminate\Database\Eloquent\Builder|News whereWeight($value)
 * @property-read mixed $language_ids
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Language> $languages
 * @property-read int|null $languages_count
 * @method static \Illuminate\Database\Eloquent\Builder|News language($locale)
 * @property-read \Awcodes\Curator\Models\Media|null $media
 * @property-read \App\Models\News\NewsLang|null $translation
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|News listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|News notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|News orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|News orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|News orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|News translated()
 * @method static \Illuminate\Database\Eloquent\Builder|News translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|News translations()
 * @method static \Illuminate\Database\Eloquent\Builder|News whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|News whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|News withTranslation(?string $locale = null)
 * @mixin \Eloquent
 */
class News extends WeightedModel implements \OwenIt\Auditing\Contracts\Auditable, Searchable
{
    use HasFactory, \App\Helpers\HasTranslations, HasMedia, HasAuthor, HasStatus, \OwenIt\Auditing\Auditable, \App\Helpers\HasSeo, HasSlug, HasTimestamps, HasSearch, Translatable;

    public $translationModel = NewsLang::class;


    protected $guarded = ['id', 'created_at', 'updated_at'];


    public array $translatedAttributes = [
        'title', 'description', 'content', 'image_id'
    ];

    public array $upload_attributes = [
        'image_id'
    ];

    public function getSearchResult(): SearchResult
    {
        $url = route('news.show', $this->slug);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }
}
