<?php

namespace App\Filament\Resources\ClusterResource\Pages;

use App\Filament\Resources\ClusterResource;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\ListTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClusters extends ListRecords
{
    use ListTranslatable;
    protected static string $resource = ClusterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
