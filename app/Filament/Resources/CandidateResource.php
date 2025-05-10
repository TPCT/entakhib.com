<?php

namespace App\Filament\Resources;

use App\Exports\CandidatesExport;
use App\Exports\CityExport;
use App\Filament\Components\FileUpload;
use Filament\Forms\Components\Checkbox;
use FilamentTiptapEditor\TiptapEditor;
use App\Filament\Components\TextInput;
use App\Filament\Resources\CandidateResource\Pages;
use App\Filament\Resources\CandidateResource\RelationManagers;
use App\Helpers\Utilities;
use App\Models\City\City;
use App\Models\Candidate;
use CactusGalaxy\FilamentAstrotomic\Forms\Components\TranslatableTabs;
use CactusGalaxy\FilamentAstrotomic\Resources\Concerns\ResourceTranslatable;
use CactusGalaxy\FilamentAstrotomic\TranslatableTab;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CandidateResource extends Resource
{
    use ResourceTranslatable;

    protected static ?string $model = Candidate\Candidate::class;

    protected static ?string $navigationIcon = 'bi-person-fill';

    public static function getNavigationLabel(): string
    {
        return __("Candidates");
    }

    public static function getModelLabel(): string
    {
        return __("Candidate");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Candidates");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Candidates");
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
                Grid::make(3)->schema([
                    Grid::make()->schema([
                        TranslatableTabs::make()
                            ->localeTabSchema(fn (TranslatableTab $tab) => [
                                FileUpload::make('image_id')
                                    ->label(__("Image"))
                                    ->multiple(false)
                                    ->required(),

                                TextInput::make($tab->makeName('title'))
                                    ->label(__("Title"))
                                    ->maxLength(255)
//                                    ->afterStateUpdated(function ($record, Get $get, Set $set){
//                                        if ($get('slug') || $record?->slug)
//                                            return;
//                                        $set('slug', Utilities::slug($get('data.' . app()->getLocale() . '.title', true)));
//                                    })
//                                    ->live(true, 500)
                                    ->required(),

                                TextInput::make($tab->makeName('slogan'))
                                    ->label(__("Slogan"))
                                    ->maxLength(255)
                                    ->required(),

                                \App\Filament\Components\TiptapEditor::make($tab->makeName('description'))
                                    ->required()
                                    ->label(500)
                                    ->label(__("Description")),

                                \App\Filament\Components\TiptapEditor::make($tab->makeName('external_brief'))
                                    ->required()
                                    ->maxLength(500)
                                    ->label(__("External brief")),

                                \App\Filament\Components\TiptapEditor::make($tab->makeName('election_program_description'))
                                    ->maxLength(500)
                                    ->required()
                                    ->label(__("Election Program Description")),

                                FileUpload::make($tab->makeName('election_program_link_id'))
                                    ->label(__("Election Program"))
                                    ->multiple(false),

                                \App\Filament\Components\TiptapEditor::make($tab->makeName('election_location_description'))
                                    ->maxLength(500)
                                    ->required()
                                    ->label(__("Election Location Description")),
                            ])
                            ->columnSpan(2),

                        FileUpload::make('candidate_images_ids')
                            ->relationship('images', 'id')
                            ->orderColumn('order')
                            ->multiple()
                            ->listDisplay()
                            ->columnSpanFull()
                            ->label(__("Images"))
                    ])->columnSpan(2),

                    \Filament\Forms\Components\Section::make()->schema(
                        array_merge(
                            Filament::auth()->user()->can('change_author_candidate') ? [
                                Select::make('author.name')
                                    ->label(__("Author"))
                                    ->relationship('author', 'name')
                                    ->default(Filament::auth()->user()->id)
                                    ->required()
                                    ->native(false)
                            ] : [] , [
                            TextInput::make('video_url')
                                ->label(__("Video Url"))
                                ->url(),

                            TextInput::make("phone_1")
                                ->label(__("Phone"))
                                ->tel()
                                ->maxLength(15),

                            TextInput::make("phone_2")
                                ->label(__("Whatsapp"))
                                ->tel()
                                ->maxLength(15),

                            TextInput::make("facebook_link")
                                ->label(__("Facebook Link"))
                                ->url()
                                ->maxLength(255),

                            TextInput::make('instagram_link')
                                ->label(__("Instagram Link"))
                                ->url()
                                ->maxLength(255),

                            TextInput::make('twitter_link')
                                ->label(__("Twitter Link"))
                                ->url()
                                ->maxLength(255),

                            TextInput::make('youtube_link')
                                ->label(__("Youtube Link"))
                                ->url()
                                ->maxLength(255),

                            TextInput::make('election_location')
                                ->label('Election Location')
                                ->url(),

                            Select::make('candidate_type')
                                ->label(__("Candidate Type"))
                                ->native(false)
                                ->live()
                                ->afterStateUpdated(function (Set $set){
                                    $set('party_id', null);
                                    $set('cluster_id', null);
                                })
                                ->required()
                                ->options(self::$model::getCandidateTypes()),

                            Select::make('party_id')
                                ->label(__("Party"))
                                ->hidden(function (Get $get){
                                    return $get('candidate_type') != self::$model::PARTY_CANDIDATE;
                                })
                                ->options(function (Get $get){
                                    return self::$model::getPartiesList();
                                })
                                ->searchable()
                                ->native(false)
                                ->required(),

                            Select::make('cluster_id')
                                ->label(__("Cluster"))
                                ->hidden(function (Get $get){
                                    return $get('candidate_type') != self::$model::CLUSTER_CANDIDATE;
                                })
                                ->options(function (Get $get){
                                    return self::$model::getClustersList();
                                })
                                ->searchable()
                                ->native(false)
                                ->required(),

                            TextInput::make('extra_votes')
                                ->label(__("Extra Votes"))
                                ->visible(fn ($get) => $get('candidate_type') == self::$model::CLUSTER_CANDIDATE)
                                ->default(0),

                            TextInput::make('slug')
                                ->label(__("Slug"))
                                ->unique(ignoreRecord: true)
                                ->disabledOn('edit')
                                ->helperText(__("Will Be Auto Generated From Title"))
                                ->markAsRequired('true'),

                            DatePicker::make('published_at')
                                ->label(__("Published At"))
                                ->default(Carbon::today())
                                ->native(false)
                                ->required(),

                            Select::make('status')
                                ->label(__("Status"))
                                ->options(City::getStatuses())
                                ->native(false)
                                ->default(1),

                            Select::make('weight')
                                ->default(self::$model::count())
                                ->label(__("Weight"))
                                ->options(range(0, self::$model::count()))
                                ->native(false),

                            Checkbox::make('winner')
                                ->label(__("Winner"))
                                ->visible(fn($get) => $get('candidate_type') == Candidate\Candidate::PARTY_CANDIDATE),

                            Checkbox::make('promote')
                                ->label(__("Promote To Homepage"))
                                ->default(false)
                        ])
                    )->columnSpan(1)

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_id')
                    ->label(__("Image"))
                    ->toggleable()
                    ->getStateUsing(function ($record){
                        if ($record->image) {
                            return asset($record->image->url);
                        }
                        return asset('/storage/' . "panel-assets/no-image.png") ;
                    })
                    ->default(asset('/storage/' . "panel-assets/no-image.png"))
                    ->circular(),

                Tables\Columns\TextColumn::make('Party-Cluster')
                    ->label(__("Party/Cluster"))
                    ->getStateUsing(function($record){
                        $cluster = $record->cluster?->title;
                        $party = $record->party?->title;
                        if ($cluster)
                            return "{$cluster} " . __("Cluster");
                        return "{$party} " . __("Party");
                    })
                ->toggleable(),

                Tables\Columns\TextColumn::make('translation.title')
                    ->toggleable()
                    ->searchable(query: function ($query, $search){
                        return $query->whereTranslationLike('title', '%'.$search.'%');
                    })
                    ->label(__("Title")),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->label(__("Status"))
                    ->badge()
                    ->color(function (Candidate\Candidate $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Candidate\Candidate $record){
                        return $record->status == Utilities::PUBLISHED ? __("Published") : __("Pending");
                    }),
                Tables\Columns\TextColumn::make('published_at')
                    ->toggleable()
                    ->label(__("Publish Time"))
                    ->date(),
                Tables\Columns\TextColumn::make('author.name')
                    ->toggleable()
                    ->label(__("Author"))
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('author')
                    ->label(__("Author"))
                    ->searchable()
                    ->relationship('author', 'name')
                    ->native(false),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__("Status"))
                    ->options(self::$model::getStatuses())
                    ->searchable()
                    ->native(false),
                Tables\Filters\SelectFilter::make('candidate_type')
                    ->label(__("Candidate Type"))
                    ->options(self::$model::getCandidateTypes())
                    ->native(false)
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make('Export')->label(__('Export'))->exports([
                        CandidatesExport::make()->fromModel()
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
            'index' => Pages\ListCandidates::route('/'),
            'create' => Pages\CreateCandidate::route('/create'),
            'edit' => Pages\EditCandidate::route('/{record}/edit'),
        ];
    }
}
