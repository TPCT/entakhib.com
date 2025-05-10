<?php

namespace App\Models\Dropdown;

use App\Helpers\HasAuthor;
use App\Helpers\HasMedia;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\HasUploads;
use App\Models\Block\Block;
use App\Filament\Helpers\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

/**
 * App\Models\Dropdown
 *
 * @property int $id
 * @property int $user_id
 * @property array $title
 * @property string $brief
 * @property string $url
 * @property string $image
 * @property string $slug
 * @property string $published_at
 * @property string $category
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User|null $author
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereBrief($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereUserId($value)
 * @property array|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown active()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Block\Block> $blocks
 * @property-read int|null $blocks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slider\Slider> $sliders
 * @property-read int|null $sliders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TeamMember> $team_members
 * @property-read int|null $team_members_count
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Entity> $entities
 * @property-read int|null $entities_count
 * @property array $second_title
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereSecondTitle($value)
 * @property-read mixed $translations
 * @property array|null $validations
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereValidations($value)
 * @property-read \Awcodes\Curator\Models\Media|null $media
 * @property-read \App\Models\Dropdown\DropdownLang|null $translation
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown media()
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown translations()
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown withTranslation(?string $locale = null)
 * @mixin \Eloquent
 */
class Dropdown extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, HasAuthor, Translatable, Auditable, HasStatus, \App\Helpers\HasTranslations, HasMedia, HasSlug;

    public const MENU_CATEGORY = "Menu Category";
    public const FAQ_CATEGORY = "Faq Category";
    public const BLOCK_CATEGORY = "Block Category";

    public static function getCategories(): array
    {
        return [
            self::MENU_CATEGORY => __(self::MENU_CATEGORY),
            self::FAQ_CATEGORY => __(self::FAQ_CATEGORY),
            self::BLOCK_CATEGORY => __(self::BLOCK_CATEGORY),
        ];
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public $translationModel = DropdownLang::class;
    public array $translatedAttributes = [
        'title', 'description', 'image_id', 'second_title'
    ];

    protected $casts = [
        'validations' => 'array'
    ];

    public array $upload_attributes = [
        'image_id'
    ];

    public function blocks(){
        return $this
            ->hasMany(Block::class, 'dropdown_id', 'id')
            ->where('dropdown_id', $this->id);
    }
}
