<?php

namespace App\Models\Cluster;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Cluster\ClusterLang
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
 * @method static \Illuminate\Database\Eloquent\Builder|ClusterLang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClusterLang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClusterLang query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClusterLang whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClusterLang whereHeaderImageDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClusterLang whereHeaderImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClusterLang whereHeaderImageTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClusterLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClusterLang whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClusterLang whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClusterLang whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClusterLang whereSecondTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClusterLang whereThumbnailImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClusterLang whereTitle($value)
 * @mixin \Eloquent
 */
class ClusterLang extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = 'clusters_lang';
    public $timestamps = false;
    protected $guarded = ['id'];
}
