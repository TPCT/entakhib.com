<?php

namespace App\Filament\Resources\HeaderImageResource\Pages;

use App\Filament\Resources\HeaderImageResource;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\CreateTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHeaderImage extends CreateRecord
{
    use CreateTranslatable;

    protected static string $resource = HeaderImageResource::class;
}
