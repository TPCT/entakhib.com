<?php

namespace App\Models\Party;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Party\PartyLang
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 * @property string|null $second_title
 * @property string|null $description
 * @property int|null $thumbnail_image_id
 * @property int|null $image_id
 * @property int|null $header_image_id
 * @property string|null $header_image_title
 * @property string|null $header_image_description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|PartyLang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PartyLang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PartyLang query()
 * @method static \Illuminate\Database\Eloquent\Builder|PartyLang whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartyLang whereHeaderImageDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartyLang whereHeaderImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartyLang whereHeaderImageTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartyLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartyLang whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartyLang whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartyLang whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartyLang whereSecondTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartyLang whereThumbnailImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartyLang whereTitle($value)
 * @mixin \Eloquent
 */
class PartyLang extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = 'parties_lang';
    public $timestamps = false;
    protected $guarded = ['id'];
}
