<?php

namespace App\Filament\Resources;

use App\Exports\ClustersExport;
use App\Exports\PartiesExport;
use App\Filament\Components\FileUpload;
use FilamentTiptapEditor\TiptapEditor;
use FilamentTiptapEditor\Enums\TiptapOutput;
use App\Filament\Components\TextInput;
use App\Filament\Resources\PartyResource\Pages;
use App\Filament\Resources\PartyResource\RelationManagers;
use App\Helpers\Utilities;
use App\Models\City\City;
use App\Models\Cluster\Cluster;
use App\Models\Page\Page;
use App\Models\Party\Party;
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

class PartyResource extends Resource
{
    use ResourceTranslatable;

    protected static ?string $model = Party::class;

    protected static ?string $navigationIcon = 'eos-cluster';

    public static function getNavigationLabel(): string
    {
        return __("Parties");
    }

    public static function getModelLabel(): string
    {
        return __("Party");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Parties");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Parties");
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
                    TranslatableTabs::make()
                        ->localeTabSchema(fn (TranslatableTab $tab) => [
                            FileUpload::make($tab->makeName('header_image_id'))
                                ->multiple(false)
                                ->label(__("Header Image")),

                            TextInput::make($tab->makeName('header_image_title'))
                                ->label(__("Header Image Title"))
                                ->maxLength(255),

                            TiptapEditor::make($tab->makeName('header_image_description'))
                                ->label(__("Header Image Description")),


                            FileUpload::make($tab->makeName('thumbnail_image_id'))
                                ->label(__("Thumbnail Image"))
                                ->multiple(false)
                                ->required(),

                            FileUpload::make($tab->makeName('image_id'))
                                ->label(__("Image"))
                                ->multiple(false)
                                ->required(),

                            TextInput::make($tab->makeName('title'))
                                ->label(__("Title"))
                                ->maxLength(255)
                                ->required(),

                            \App\Filament\Components\TiptapEditor::make($tab->makeName('second_title'))
                                ->label(__("Second Title"))
                                ->required(),

                            TiptapEditor::make($tab->makeName('description'))
                                ->label(__("Description"))
                                ->required()
                        ])
                        ->columnSpan(2),
                    \Filament\Forms\Components\Section::make()->schema(
                        array_merge(
                            Filament::auth()->user()->can('change_author_party') ? [
                                Select::make('author.name')
                                    ->label(__("Author"))
                                    ->relationship('author', 'name')
                                    ->default(Filament::auth()->user()->id)
                                    ->required()
                                    ->native(false)
                            ] : [] , [

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
                                ->native(false)
                        ])
                    )->columnSpan(1)

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function(){
                return self::$model::orderBy('published_at', 'desc');
            })
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
                    ->color(function (Party $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Party $record){
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
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->poll("30s")
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make('Export')->label(__('Export'))->exports([
                        PartiesExport::make()->fromModel()
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
            'index' => Pages\ListParties::route('/'),
            'create' => Pages\CreateParty::route('/create'),
            'edit' => Pages\EditParty::route('/{record}/edit'),
        ];
    }
}
