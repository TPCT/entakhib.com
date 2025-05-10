<?php

namespace App\Filament\Resources;

use App\Exports\TranslationExport;
use App\Filament\Components\TextInput;
use App\Filament\Resources\TranslationResource\Pages;
use App\Filament\Resources\TranslationResource\RelationManagers;
use App\Models\Translation\Translation;
use CactusGalaxy\FilamentAstrotomic\Forms\Components\TranslatableTabs;
use CactusGalaxy\FilamentAstrotomic\Resources\Concerns\ResourceTranslatable;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\CreateTranslatable;
use CactusGalaxy\FilamentAstrotomic\TranslatableTab;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class TranslationResource extends Resource
{
    use ResourceTranslatable;

    protected static ?string $model = Translation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = "translation-categories/translations";

    public static string $parentResource = TranslationCategoryResource::class;
    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record->key;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()->schema([
                    Forms\Components\Section::make()->schema([
                        TextInput::make("key")
                            ->label(__("Key"))
//                            ->live(true)
//                            ->afterStateUpdated(function ($state, $component, Forms\Set $set, Forms\Get $get){
//                                $path = $component->getId();
//                                $path = explode('.', $path);
//                                unset($path[count($path) - 1]);
//                                $path = implode('.', $path) . '.' . app()->getLocale() . '.content';
//                                if (!$get($path))
//                                    $set($path, $state, true);
//                            })
                            ->required(),
                        TranslatableTabs::make()
                            ->localeTabSchema(fn (TranslatableTab $tab) => [
                                TextInput::make($tab->makeName('content'))
                                    ->label(__("Translation"))
                                    ->multiLingual()
                            ])
                    ])->columnSpan(2)
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable()
                    ->label(__("Key")),
                Tables\Columns\TextColumn::make('category.title')
                    ->label(__("Category"))
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(
                        fn (Pages\ListTranslations $livewire, Model $record): string => static::$parentResource::getUrl('translations.edit', [
                            'record' => $record,
                            'parent' => $livewire->parent,
                        ])
                    )->modal(),
            ])
            ->poll('30s')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make('Export')->label(__('Export'))->exports([
                        TranslationExport::make()->fromModel()
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
}
