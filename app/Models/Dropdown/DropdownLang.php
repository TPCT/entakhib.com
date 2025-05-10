<?php

namespace App\Models\Dropdown;

use App\Helpers\HasUploads;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @property int|null $parent_id
 * @property string|null $language
 * @property int|null $image_id
 * @method static \Illuminate\Database\Eloquent\Builder|DropdownLang whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DropdownLang whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DropdownLang whereParentId($value)
 * @mixin \Eloquent
 */
class DropdownLang extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = "dropdowns_lang";
    public $timestamps = false;
    protected $guarded = [
        'id'
    ];
}
