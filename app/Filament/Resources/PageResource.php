<?php

namespace App\Filament\Resources;

use App\Exports\NewsExport;
use App\Exports\PageExport;
use App\Filament\Components\FileUpload;
use App\Models\Language;
use Filament\Resources\Components\Tab;
use FilamentTiptapEditor\TiptapEditor;
use FilamentTiptapEditor\Enums\TiptapOutput;
use App\Filament\Components\TextInput;
use App\Filament\Resources\PageResource\Pages;
use App\Helpers\Utilities;
use App\Models\Page\Page;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use CactusGalaxy\FilamentAstrotomic\Forms\Components\TranslatableTabs;
use CactusGalaxy\FilamentAstrotomic\Resources\Concerns\ResourceTranslatable;
use CactusGalaxy\FilamentAstrotomic\TranslatableTab;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Hamcrest\Core\Set;
use Illuminate\Database\Eloquent\Model;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use RalphJSmit\Filament\SEO\SEO;
use function Livewire\after;

class PageResource extends Resource
{
    use ResourceTranslatable;

    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-s-document';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __("Pages");
    }

    public static function getModelLabel(): string
    {
        return __("Page");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Pages");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Pages");
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
                    Forms\Components\Grid::make()->schema([
                        TranslatableTabs::make()
                            ->localeTabSchema(fn (TranslatableTab $tab) =>[
                                TextInput::make($tab->makeName('title'))
                                        ->label(__("Title"))
                                        ->maxLength(255)
//                                        ->afterStateUpdated(function($state, $set, Forms\Get $get, $record) use ($tab){
//                                            if ($record?->slug || $get('slug'))
//                                                return;
//                                            $set('slug', Utilities::slug($get('data.' . app()->getLocale() . '.title', true)));
//                                        })
//                                        ->live(onBlur: true, debounce: 100)
                                        ->multiLingual()
                                        ->unique(ignoreRecord: true)
                                        ->required(),
//
//                                        TiptapEditor::make($tab->makeName('description'))
//                                            ->label(__("Description")),

                                        \App\Filament\Components\TinyEditor::make($tab->makeName('content'))
                                            ->label(__("Content"))
                                            ->showMenuBar()
                                            ->toolbarSticky(true),
                        ])->columnSpanFull(),
                        Forms\Components\Section::make()->schema([
                            Forms\Components\Repeater::make('bullets')
                                ->defaultItems(0)
                                ->relationship()
                                ->schema(function (){
                                    $tabs = [];
                                    foreach (Language::all() as $language){
                                        $tabs[] = Forms\Components\Tabs\Tab::make($language->language)
                                            ->schema([
                                                Forms\Components\TextInput::make("{$language->locale}.title")
                                                    ->label(__("Title"))
                                                    ->required(),
                                                TiptapEditor::make("{$language->locale}.description")
                                                    ->label(__("Content"))
                                                    ->required()
                                            ]);
                                    }
                                    return [ Forms\Components\Tabs::make()->tabs($tabs)];
                                })
                                ->orderColumn('order')
                                ->columnSpan(2)
                        ])
                        ->visible(fn ($get) => $get('view') == Page::DEFAULT_VIEW),
                        Forms\Components\Section::make()->schema([
                            FileUpload::make('page_image_ids')
                                ->relationship('images', 'id')
                                ->orderColumn('order')
                                ->multiple()
                                ->listDisplay()
                                ->columnSpanFull()
                                ->label(__("Images"))
                        ])
                        ->visible(fn ($get) => $get('view') == Page::VOTING_VIEW)
                    ])->columnSpan(2),
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\Section::make()->schema(
                            array_merge(
                                Filament::auth()->user()->can('change_author_page') ? [
                                    Forms\Components\Select::make('author.name')
                                        ->label(__("Author"))
                                        ->relationship('author', 'name')
                                        ->default(Filament::auth()->user()->id)
                                        ->required()
                                        ->native(false)
                                ] : [] , [

                                Forms\Components\Select::make('section_ids')
                                    ->label(__("Section"))
                                    ->multiple()
                                    ->preload()
                                    ->relationship('sections', 'title'),

                                TextInput::make('slug')
                                    ->label(__("Slug"))
                                    ->unique(ignoreRecord: true)
                                    ->disabledOn('edit')
                                    ->helperText(__("Will Be Auto Generated From Title"))
                                    ->markAsRequired('true'),

                                TextInput::make('prefix')
                                    ->label(__("Prefix"))
                                    ->afterStateUpdated(function($state, Forms\Set $set){
                                        $set('prefix', trim(trim($state, "/")));
                                    })
                                    ->live(true)
                                    ->default(""),

                                Forms\Components\Select::make('view')
                                        ->label(__("View"))
                                        ->options(Page::getViews())
                                        ->preload()
                                        ->live()
                                        ->default(Page::DEFAULT_VIEW)
                                        ->native(false),

                                TextInput::make('video_url')
                                        ->label(__("Video Url"))
                                        ->visible(fn ($get) => $get('view') == Page::VOTING_VIEW),

                                Forms\Components\DatePicker::make('published_at')
                                    ->label(__("Published At"))
                                    ->default(Carbon::today())
                                    ->native(false)
                                    ->required(),
                                Forms\Components\Select::make('status')
                                    ->label(__("Status"))
                                    ->options(Page::getStatuses())
                                    ->native(false)
                                    ->default(1),
                                Forms\Components\Checkbox::make('direct_access')
                                    ->label(__("Direct Access"))
                                    ->default(true),
                            ])
                        ),
                        \App\Filament\Components\Seo::make(config('app.locales'))
                            ->columnSpan(1)
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
                    ->color(function (Page $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Page $record){
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
                    ->options(Page::getStatuses())
                    ->searchable()
                    ->native(false)
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->icon('heroicon-s-eye')
                    ->label(__("View"))
                    ->url(function(Model $record){
                        $prefix = "/";
                        if ($record->sections()->count())
                            $prefix .= $record->sections()->first()->slug . "/";
                        $prefix .= $record->prefix ? ($record->prefix . "/"): "";
                        $prefix .= $record->slug;
                        return url($prefix);
                        return route('site.show', ['page' => $record]);
                }, shouldOpenInNewTab: true),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->poll("30s")
            ->recordAction(Tables\Actions\EditAction::class)
            ->recordUrl(function($record){
                return Pages\EditPage::getUrl([$record->slug]);
            })
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make('Export')->label(__('Export'))->exports([
                        PageExport::make()->fromModel()
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
