<?php

namespace App\Models\District;

use App\Helpers\HasAuthor;
use App\Helpers\HasStatus;
use App\Helpers\HasUploads;
use App\Models\City\City;
use App\Filament\Helpers\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\District
 *
 * @property int $id
 * @property int $user_id
 * @property int $city_id
 * @property array $title
 * @property int $status
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read \App\Models\City\City $city
 * @method static \Illuminate\Database\Eloquent\Builder|District active()
 * @method static \Illuminate\Database\Eloquent\Builder|District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District query()
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|District wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereUserId($value)
 * @property-read \App\Models\User $user
 * @property-read mixed $translations
 * @property int|null $parent_id
 * @property string|null $language
 * @property int|null $image_id
 * @method static \Illuminate\Database\Eloquent\Builder|DistrictLang whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DistrictLang whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DistrictLang whereParentId($value)
 * @mixin \Eloquent
 */




class DistrictLang extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = "districts_lang";
    public $timestamps = false;
    protected $guarded = [
        'id'
    ];
}
