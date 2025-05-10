<?php

namespace App\Filament\Resources;

use App\Filament\Components\FileUpload;
use App\Settings\General;
use Filament\Forms\Components\Select;
use App\Filament\Components\TextInput;
use App\Filament\Resources\MenuResource\Pages;
use App\Filament\Resources\MenuResource\RelationManagers;
use App\Helpers\Utilities;
use App\Models\Menu\Menu;
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
use Saade\FilamentAdjacencyList\Forms\Components\AdjacencyList;

class MenuResource extends Resource
{
    use ResourceTranslatable;

    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'zondicon-menu';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __("Menus");
    }

    public static function getModelLabel(): string
    {
        return __("Menu");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Menus");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Menus");
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
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Section::make()->schema([
                            TextInput::make('title')
                                ->label(__("Title"))
                                ->maxLength(255)
                                ->unique(ignoreRecord: true),

                            \App\Filament\Components\AdjacencyList::make('links')
                                ->relationship('links')
                                ->labelKey('title')
                                ->childrenKey('children')
                                ->orderColumn()
                                ->label(__("Links"))
                                ->maxDepth(2)
                                ->form([
                                    TranslatableTabs::make()
                                        ->localeTabSchema(fn (TranslatableTab $tab) => [
                                            TextInput::make($tab->makeName('title'))
                                                ->label(__("Title"))
                                                ->maxLength(255)
                                                ->required(),
                                            TextInput::make($tab->makeName('link'))
                                                ->label(__("Link"))
                                                ->maxLength(255)
                                                ->default("#")
                                                ->required(),
                                            Forms\Components\Checkbox::make('status')
                                                ->label(__('Published'))
                                                ->default(true)
                                        ])
                                ])
                               ,

                            Forms\Components\Repeater::make('buttons')
                                ->visible(function (Forms\Get $get){
                                    return $get('data.category', true) == Menu::HEADER_MENU;
                                })
                                ->schema([
                                    Forms\Components\Tabs::make('')->tabs(function (){
                                        $tabs = [];
                                        foreach (config('app.locales') as $locale => $language){
                                            $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                                                TextInput::make("title.{$locale}")
                                                    ->label(__("Title") . "[{$language}]")
                                                    ->required()
                                                    ->default("")
                                                    ->maxLength(255),
                                                TextInput::make("link.{$locale}")
                                                    ->label(__("Link") . "[{$language}]")
                                                    ->required()
                                                    ->default("#")
                                                    ->maxLength(255),
                                                Forms\Components\Checkbox::make('login')
                                                    ->label(__("Login"))
                                                    ->default(false),
                                                Forms\Components\Checkbox::make('status')
                                                    ->label(__("Published"))
                                                    ->default(false)
                                            ]);
                                        }
                                        return $tabs;
                                    })->default([])
                                ])
                                ->itemLabel(function ($state){
                                    return $state['title'][app(General::class)->default_locale];
                                })
                                ->collapsible()
                                ->collapsed()
                                ->label(__("Buttons"))

                        ])->columnSpan(2),
                        Forms\Components\Section::make()->schema(
                            array_merge(
                                Filament::auth()->user()->can('change_author_menu') ? [
                                    Forms\Components\Select::make('author.name')
                                        ->label(__("Author"))
                                        ->relationship('author', 'name')
                                        ->default(Filament::auth()->user()->id)
                                        ->required()
                                        ->native(false)
                                ] : [] , [
                                Select::make('category')
                                    ->options(Menu::getCategories())
                                    ->label(__("Category"))
                                    ->live()
                                    ->required()
                                    ->preload()
                                    ->native(false),
                                Forms\Components\DatePicker::make('published_at')
                                    ->label(__("Published At"))
                                    ->default(Carbon::today())
                                    ->native(false)
                                    ->required(),
                                Select::make('status')
                                    ->label(__("Status"))
                                    ->options(Menu::getStatuses())
                                    ->native(false)
                                    ->default(1)
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
                Tables\Columns\TextColumn::make('title')
                    ->toggleable()
                    ->label(__("Title"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->label(__("Status"))
                    ->badge()
                    ->color(function (Menu $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Menu $record){
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->poll("30s")
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
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
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }

}
