<?php

namespace App\Models\Menu;

use App\Filament\Helpers\Translatable;
use App\Helpers\HasAuthor;
use App\Helpers\HasStatus;
use App\Helpers\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property int $user_id
 * @property array $title
 * @property string $category
 * @property array $links
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUserId($value)
 * @property int $dropdown_id
 * @property string $published_at
 * @property int $status
 * @property-read \App\Models\Dropdown\Dropdown $dropdown
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereDropdownId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereStatus($value)
 * @property string|null $view_all_link
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereViewAllLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu active()
 * @property-read \App\Models\User $user
 * @property array|null $buttons
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereButtons($value)
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Menu\Menu[] $children
 * @property-read int|null $children_count
 * @property-read int|null $links_count
 * @property-read \App\Models\Menu\Menu|null $parent
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Menu\Menu[] $ancestors The model's recursive parents.
 * @property-read int|null $ancestors_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Menu\Menu[] $ancestorsAndSelf The model's recursive parents and itself.
 * @property-read int|null $ancestors_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Menu\Menu[] $bloodline The model's ancestors, descendants and itself.
 * @property-read int|null $bloodline_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Menu\Menu[] $childrenAndSelf The model's direct children and itself.
 * @property-read int|null $children_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Menu\Menu[] $descendants The model's recursive children.
 * @property-read int|null $descendants_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Menu\Menu[] $descendantsAndSelf The model's recursive children and itself.
 * @property-read int|null $descendants_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Menu\Menu[] $parentAndSelf The model's direct parent and itself.
 * @property-read int|null $parent_and_self_count
 * @property-read \App\Models\Menu\Menu|null $rootAncestor The model's topmost parent.
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Menu\Menu[] $siblings The parent's other children.
 * @property-read int|null $siblings_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|\App\Models\Menu\Menu[] $siblingsAndSelf All the parent's children.
 * @property-read int|null $siblings_and_self_count
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu depthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu doesntHaveChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu getExpressionGrammar()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu hasChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu hasParent()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu isLeaf()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu isRoot()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu tree($maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu treeOf(\Illuminate\Database\Eloquent\Model|callable $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu withGlobalScopes(array $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @mixin \Eloquent
 */

class Menu extends Model implements Auditable
{
    use HasFactory, HasAuthor, \OwenIt\Auditing\Auditable, HasStatus, HasRecursiveRelationships;


    public const HEADER_MENU = "Header Menu";
    public const FOOTER_MENU = "Footer Menu";

    public static function getCategories(): array
    {
        return [
            self::HEADER_MENU => __(self::HEADER_MENU),
            self::FOOTER_MENU => __(self::FOOTER_MENU),
        ];
    }

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'buttons' => 'array'
    ];

    public function links(){
        return $this->hasMany(MenuLink::class, 'menu_id', 'id')
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('sort');
    }
}
