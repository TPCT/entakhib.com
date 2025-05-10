<?php

namespace App\Filament\Resources\DropdownResource\Pages;

use App\Filament\Resources\DropdownResource;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\ListTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDropdowns extends ListRecords
{
    use ListTranslatable;

    protected static string $resource = DropdownResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            DropdownResource\Widgets\DropdownsStat::class
        ];
    }
}
