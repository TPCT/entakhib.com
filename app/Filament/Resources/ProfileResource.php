<?php

namespace App\Filament\Resources;

use App\Exports\NewsExport;
use App\Exports\ProfileExport;
use App\Filament\Resources\ProfileResource\Pages;
use App\Filament\Resources\ProfileResource\RelationManagers;
use App\Models\Candidate\Candidate;
use App\Models\City\City;
use App\Models\Cluster\Cluster;
use App\Models\District\District;
use App\Models\Party\Party;
use App\Models\Profile;
use CactusGalaxy\FilamentAstrotomic\Resources\Concerns\ResourceTranslatable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ProfileResource extends Resource
{
    use ResourceTranslatable;

    protected static ?string $model = Profile::class;

    protected static ?string $navigationIcon = 'bi-person-fill';

    public static function getNavigationLabel(): string
    {
        return __("Voters");
    }

    public static function getModelLabel(): string
    {
        return __("Voters");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Voters");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Voters");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Election");
    }

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function (){
                return self::$model::orderBy('updated_at', 'desc');
            })
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label(__("Full Name"))
                    ->searchable(query: function ($query, $search){
                        return $query->whereTranslationLike('full_name', '%'.$search.'%');
                    }),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label(__("Phone"))
                    ->searchable(query: function ($query, $search){
                        return $query->whereTranslationLike('phone_number', '%'.$search.'%');
                    }),
                Tables\Columns\TextColumn::make('city.title')
                    ->label(__("City")),
                Tables\Columns\TextColumn::make('district.title')
                    ->label(__("District")),
                Tables\Columns\TextColumn::make('cluster_or_party')
                    ->label(__("Cluster/Party"))
                    ->getStateUsing(function ($record){
                        $content = "";
                        if ($record->cluster_votes->count())
                            $content .= __("site.Cluster") . ": " . $record->cluster_votes()->first()->title . "<br/>";
                        if ($record->party_votes->count())
                            $content .= __("site.Party") . ": " . $record->party_votes()->first()->title;
                        return new HtmlString($content ?: __("site.Hasn't Voted Yet ..."));
                    }),
                Tables\Columns\TextColumn::make('candidates')
                    ->label(__("Candidates"))
                    ->getStateUsing(function ($record){
                        $content = "-----";
                        if ($record->candidate_votes->count()){
                            $content = "";
                            foreach($record->candidate_votes as $candidate_vote){
                                $content .= $candidate_vote->title . "<br/>";
                            }
                        }
                        return new HtmlString($content);
                    }),
            ])
            ->filters([
                Tables\Filters\Filter::make('city')
                    ->form([
                        Forms\Components\Select::make('city_id')
                            ->label(__('City'))
                            ->options(City::all()->pluck('title', 'id'))
                            ->native(false)
                            ->live()
                            ->searchable()
                            ->afterStateUpdated(function($set){
                                $set('district_id', null);
                                $set('cluster_id', null);
                                $set('candidate_id', null);
                                $set('party_id', null);
                            }),
                        Forms\Components\Select::make('district_id')
                            ->label(__('District'))
                            ->options(function ($get){
                                return District::where('city_id', $get('city_id'))->get()->pluck('title', 'id');
                            })
                            ->live()
                            ->searchable()
                            ->afterStateUpdated(function($set){
                                $set('candidate_id', null);
                                $set('cluster_id', null);
                            })
                            ->native(false)
                            ->visible(function (Forms\Get $get){
                                return $get('city_id');
                            }),

                        Forms\Components\Select::make('cluster_id')
                            ->label(__('Cluster'))
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(function($set){
                                $set('candidate_id', null);
                                $set('party_id', null);
                            })
                            ->options(function(Forms\Get $get){
                                return Cluster::when($get('city_id'), function ($query, $city_id) {
                                    return $query->where('city_id', $city_id);
                                })->when($get('district_id'), function ($query, $district_id) {
                                    return $query->where('district_id', $district_id);
                                })->get()->pluck('title', 'id');
                            })
                            ->visible(fn ($get) => ($get('district_id')) && !$get('party_id'))
                            ->searchable(),

                        Forms\Components\Select::make('candidate_id')
                            ->label(__('Candidate'))
                            ->native(false)
                            ->options(function(Forms\Get $get){
                                return Candidate::when($get('city_id'), function ($query, $city_id) {
                                    return $query->whereHas('cluster', function ($query) use ($city_id){
                                        return $query->where('clusters.city_id', $city_id);
                                    });
                                })->when($get('district_id'), function ($query, $district_id) {
                                    return $query->whereHas('cluster', function ($query) use ($district_id){
                                        return $query->where('clusters.district_id', $district_id);
                                    });
                                })->when($get('cluster_id'), function ($query, $cluster_id){
                                    return $query->where('cluster_id', $cluster_id);
                                })->get()->pluck('title', 'id');
                            })
                            ->visible(fn ($get) => $get('cluster_id'))
                            ->searchable(),

                        Forms\Components\Select::make('party_id')
                            ->label(__('Party'))
                            ->native(false)
                            ->options(Party::all()->pluck('title', 'id'))
                            ->visible(fn ($get) => !$get('cluster_id'))
                            ->live()
                            ->afterStateUpdated(function ($set){
                                $set('cluster_id', null);
                                $set('candidate_id', null);
                            })
                            ->searchable()
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['cluster_id'], function ($query, $cluster_id){
                                return $query->whereHas('cluster_votes', function ($query) use ($cluster_id){
                                    return $query->where('cluster_id', $cluster_id);
                                });
                            })
                            ->when($data['party_id'], function ($query, $party_id){
                                return $query->whereHas('party_votes', function ($query) use ($party_id){
                                    return $query->where('party_id', $party_id);
                                });
                            })
                            ->when($data['candidate_id'], function ($query, $candidate_id){
                                return $query->whereHas('candidate_votes', function ($query) use ($candidate_id){
                                    return $query->where('candidate_id', $candidate_id);
                                });
                            })
                           ->when(
                                $data['city_id'],
                                fn (Builder $query, $city_id): Builder => $query->where('city_id',  $city_id),
                            )
                            ->when(
                                $data['district_id'],
                                fn (Builder $query, $district_id): Builder => $query->where('district_id', $district_id),
                            );
                    })
                    ->indicateUsing(function (array $data){
                        $indicators = [];

                        if ($data['city_id'] ?? null) {
                            $indicators[] = Tables\Filters\Indicator::make(__('City') . ' = ' . City::find($data['city_id'])?->title)
                                ->removeField('city_id');
                        }

                        if ($data['district_id'] ?? null) {
                            $indicators[] = Tables\Filters\Indicator::make(__('District') . ' = ' . District::find($data['district_id'])?->title)
                                ->removeField('district_id');
                        }

                        if ($data['candidate_id'] ?? null) {
                            $indicators[] = Tables\Filters\Indicator::make(__('Candidate') . ' = ' . Candidate::find($data['candidate_id'])?->title)
                                ->removeField('candidate_id');
                        }

                        if ($data['cluster_id'] ?? null) {
                            $indicators[] = Tables\Filters\Indicator::make(__('Cluster') . ' = ' . Cluster::find($data['cluster_id'])?->title)
                                ->removeField('cluster_id');
                        }

                        if ($data['party_id'] ?? null) {
                            $indicators[] = Tables\Filters\Indicator::make(__('Party') . ' = ' . Party::find($data['party_id'])?->title)
                                ->removeField('party_id');
                        }

                    return $indicators;
                })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make('Export')->label(__('Export'))->exports([
                        ProfileExport::make()->fromModel()
                    ]),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfiles::route('/')
        ];
    }
}
