<?php

namespace App\Filament\Resources;

use App\Exports\BlockExport;
use App\Filament\Components\AdjacencyList;
use App\Filament\Components\FileUpload;
use App\Models\Language;
use FilamentTiptapEditor\TiptapEditor;
use FilamentTiptapEditor\Enums\TiptapOutput;
use Filament\Forms\Components\Select;
use App\Filament\Components\TextInput;
use App\Filament\Resources\BlockResource\Pages;
use App\Filament\Resources\BlockResource\RelationManagers;
use App\Helpers\Utilities;
use App\Models\Block\Block;
use App\Models\Block\BlockFeature;
use CactusGalaxy\FilamentAstrotomic\Forms\Components\TranslatableTabs;
use CactusGalaxy\FilamentAstrotomic\Resources\Concerns\ResourceTranslatable;
use CactusGalaxy\FilamentAstrotomic\TranslatableTab;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class BlockResource extends Resource
{
    use ResourceTranslatable;

    protected static ?string $model = Block::class;

    protected static ?string $navigationIcon = 'clarity-block-solid';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __("Blocks");
    }

    public static function getModelLabel(): string
    {
        return __("Block");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Blocks");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Blocks");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("CMS");
    }

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Grid::make()
                        ->schema([
                            TranslatableTabs::make()
                                ->localeTabSchema(fn (TranslatableTab $tab) => [
                                    FileUpload::make($tab->makeName('image_id'))
                                        ->multiple(false)
                                        ->label(__('Image')),

                                    TextInput::make($tab->makeName('title'))
                                        ->label(__("Title"))
                                        ->maxLength(255)
                                        ->required(),

                                    TextInput::make($tab->makeName('second_title'))
                                        ->label(__("Second Title"))
                                        ->maxLength(255),

                                        TiptapEditor::make($tab->makeName("description"))
                                                ->label(__("Description")),

                                        \App\Filament\Components\TinyEditor::make($tab->makeName("content"))
                                            ->label(__("Content"))
                                            ->showMenuBar()
                                            ->toolbarSticky(true),
                            ])->columnSpanFull(),
                            Forms\Components\Section::make()->schema([
                                Forms\Components\Repeater::make('features')
                                    ->label(__("Features"))
                                    ->relationship()
                                    ->defaultItems(0)
                                    ->schema(function (){
                                        $tabs = [];
                                        foreach (Language::all() as $language){
                                            $tabs[] = Forms\Components\Tabs\Tab::make($language->language)
                                                    ->schema([
                                                        FileUpload::make("{$language->locale}.image_id")
                                                            ->label(__('Image'))
                                                            ->multiple(false),
                                                        TextInput::make("{$language->locale}.title")
                                                            ->label(__("Title"))
                                                            ->maxLength(255),
                                                        TiptapEditor::make("{$language->locale}.description")
                                                            ->label(__("Description"))
                                                    ]);
                                        }
                                        return [Forms\Components\Tabs::make()->tabs($tabs)];
                                    })

                            ]),
                            Forms\Components\Section::make()->schema([
                                Forms\Components\Repeater::make('buttons')
                                    ->schema([
                                        Forms\Components\Tabs::make()->tabs(function(){
                                            $tabs = [];
                                            foreach(config('app.locales') as $locale => $language){
                                                $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                                                    Forms\Components\Grid::make()
                                                    ->schema([
                                                        TextInput::make("text.{$locale}")
                                                            ->label(__("Text") . "[{$language}]"),
                                                        TextInput::make("url.{$locale}")
                                                            ->label(__("Url") . "[{$language}]")
                                                    ])
                                                ]);
                                            }
                                            return $tabs;
                                        })
                                    ])
                                    ->itemLabel(function($component, $state){
                                        return $state['text'][config('app.locale')];
                                    })
                                    ->collapsed()
                                    ->collapsible()
                                    ->cloneable()
                                    ->minItems(0)
                                    ->defaultItems(0)
                            ])
                        ])
                        ->columnSpan(2),
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\Section::make()->schema(
                            array_merge(
                                Filament::auth()->user()->can('change_author_block') ? [
                                    Select::make('author.name')
                                        ->label(__("Author"))
                                        ->relationship('author', 'name')
                                        ->default(Filament::auth()->user()->id)
                                        ->required()
                                        ->native(false)
                                ] : [] , [

                                Select::make('section_ids')
                                    ->label(__("Section"))
                                    ->multiple()
                                    ->preload()
                                    ->relationship('sections', 'title'),
                                Select::make('dropdown_id')
                                    ->label(__("Category"))
                                    ->required()
                                    ->native(false)
                                    ->searchable()
                                    ->preload()
                                    ->default(null)
                                    ->options(self::$model::getCategoryList()),

                                Forms\Components\DatePicker::make('published_at')
                                    ->label(__("Published At"))
                                    ->default(Carbon::today())
                                    ->native(false)
                                    ->required(),

                                Select::make('status')
                                    ->label(__("Status"))
                                    ->options(Block::getStatuses())
                                    ->native(false)
                                    ->default(1)
                            ])
                        )
                    ])->columnSpan(1),

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
                    ->color(function (Block $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Block $record){
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
                    ->options(Block::getStatuses())
                    ->searchable()
                    ->native(false),
                Tables\Filters\SelectFilter::make('dropdown_id')
                    ->label(__("Category"))
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->options(self::$model::getCategoryList()),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->poll("30s")
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make('Export')->label(__('Export'))->exports([
                        BlockExport::make()->fromModel()
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
            'index' => Pages\ListBlocks::route('/'),
            'create' => Pages\CreateBlock::route('/create'),
            'edit' => Pages\EditBlock::route('/{record}/edit'),
        ];
    }
}
