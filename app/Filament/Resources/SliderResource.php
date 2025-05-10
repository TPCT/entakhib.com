<?php

namespace App\Filament\Resources;

use App\Filament\Components\FileUpload;
use App\Filament\Components\TextInput;
use App\Filament\Components\TinyEditor;
use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Helpers\Utilities;
use App\Models\News\News;
use App\Models\Slider\Slider;
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

class SliderResource extends Resource
{
    use ResourceTranslatable;

    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __("Sliders");
    }

    public static function getModelLabel(): string
    {
        return __("Slider");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Sliders");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Sliders");
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
                    Forms\Components\Section::make()
                        ->schema([
                            TranslatableTabs::make()
                                ->localeTabSchema(fn (TranslatableTab $tab) => [
                                    TextInput::make($tab->makeName('title'))
                                        ->maxLength(255)
                                        ->multiLingual()
                                        ->unique(ignoreRecord: true)
//                                        ->live(true, 100)
//                                        ->afterStateUpdated(function($set, $get, $state, $record){
//                                            if ($record?->slug || $get('slug'))
//                                                return;
//                                            $set('slug', Utilities::slug($get('data.' . app()->getLocale() . '.title', true)));
//                                        })
                                        ->required(),

                                    TinyEditor::make($tab->makeName('description'))
                                        ->label(__("Description"))
                                        ->maxLength(255)
                            ]),
                            Forms\Components\Repeater::make('slides')
                                ->relationship()
                                ->schema([
                                FileUpload::make('image_id')
                                    ->label(__("Image")),
                                FileUpload::make('mobile_image_id')
                                    ->label(__("Mobile Image")),
                                TextInput::make('link')
                                    ->label(__("Button Link")),
                            ])
                            ->collapsible()
                            ->minItems(0)
                            ->defaultItems(0),
                        ])
                        ->columnSpan(2),
                    Forms\Components\Section::make()->schema(
                        array_merge(
                            Filament::auth()->user()->can('change_author_slider') ? [
                                Forms\Components\Select::make('author.name')
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

                            Forms\Components\Select::make('category')
                                ->options(Slider::getCategories())
                                ->label(__("Category"))
                                ->required()
                                ->preload()
                                ->native(false),
                            Forms\Components\DatePicker::make('published_at')
                                ->label(__("Published At"))
                                ->default(Carbon::today())
                                ->native(false)
                                ->required(),
                            Forms\Components\Select::make('status')
                                ->label(__("Status"))
                                ->options(Slider::getStatuses())
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
                    ->color(function (Slider $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Slider $record){
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
                    ->options(Slider::getStatuses())
                    ->searchable()
                    ->native(false)
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}

