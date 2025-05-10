<?php

namespace App\Models\Candidate;

use App\Filament\Helpers\Translatable;
use App\Helpers\HasAuthor;
use App\Helpers\HasSearch;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\HasTimestamps;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Candidate\CandidateLang
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 * @property string|null $slogan
 * @property string|null $election_program_description
 * @property int|null $election_program_link_id
 * @property string|null $description
 * @property string|null $election_location_description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|CandidateLang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CandidateLang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CandidateLang query()
 * @method static \Illuminate\Database\Eloquent\Builder|CandidateLang whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CandidateLang whereElectionLocationDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CandidateLang whereElectionProgramDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CandidateLang whereElectionProgramLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CandidateLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CandidateLang whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CandidateLang whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CandidateLang whereSlogan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CandidateLang whereTitle($value)
 * @mixin \Eloquent
 */
class CandidateLang extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = 'candidates_lang';
    public $timestamps = false;
    protected $guarded = ['id'];
}
