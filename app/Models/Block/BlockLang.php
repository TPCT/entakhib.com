<?php

namespace App\Models\Block;

use App\Helpers\HasUploads;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

/**
 * App\Models\Block
 *
 * @property int $id
 * @property string $title
 * @property string|null $second_title
 * @property string|null $description
 * @property string|null $image
 * @property string|null $features
 * @property string|null $buttons
 * @property int $user_id
 * @property int $dropdown_id
 * @property string $slug
 * @property string $published_at
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Block newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Block newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Block query()
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereButtons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereDropdownId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereSecondTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\Dropdown\Dropdown $dropdown
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereLocales(string $column, array $locales)
 * @property array|null $content
 * @method static \Illuminate\Database\Eloquent\Builder|Block active()
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereContent($value)
 * @property array|null $bullets
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereBullets($value)
 * @property-read \App\Models\User $user
 * @property-read array $section_ids
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Section> $sections
 * @property-read int|null $sections_count
 * @method static \Illuminate\Database\Eloquent\Builder|Block section($section)
 * @property-read mixed $translations
 * @property int|null $parent_id
 * @property string|null $language
 * @property int|null $image_id
 * @method static \Illuminate\Database\Eloquent\Builder|BlockLang whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockLang whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockLang whereParentId($value)
 * @mixin \Eloquent
 */
class BlockLang extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Auditable;

    protected $guarded = ['id'];
    public $timestamps = false;
    protected $table = "blocks_lang";
}
