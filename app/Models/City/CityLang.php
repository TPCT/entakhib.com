<?php

namespace App\Models\City;

use App\Helpers\HasAuthor;
use App\Helpers\HasStatus;
use App\Helpers\HasUploads;
use App\Models\Branch;
use App\Filament\Helpers\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\City
 *
 * @property int $id
 * @property int $user_id
 * @property array $title
 * @property int $status
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @method static \Illuminate\Database\Eloquent\Builder|City active()
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|City wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUserId($value)
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Branch> $branches
 * @property-read int|null $branches_count
 * @property-read mixed $translations
 * @property int|null $parent_id
 * @property string|null $language
 * @property int|null $image_id
 * @method static \Illuminate\Database\Eloquent\Builder|CityLang whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityLang whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CityLang whereParentId($value)
 * @mixin \Eloquent
 */
class CityLang extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = "cities_lang";
    public $timestamps = false;
    protected $guarded = ['id'];
}
