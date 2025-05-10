<?php

namespace App\Filament\Resources\ClusterResource\Pages;

use App\Filament\Resources\ClusterResource;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\CreateTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCluster extends CreateRecord
{
    use CreateTranslatable;
    protected static string $resource = ClusterResource::class;
}
