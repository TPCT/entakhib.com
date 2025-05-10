<?php

namespace App\Filament\Resources\TranslationCategoryResource\Pages;

use App\Filament\Resources\TranslationCategoryResource;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\ListTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ListTranslations extends ListRecords
{
    use ListTranslatable;

    protected static string $resource = TranslationCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
