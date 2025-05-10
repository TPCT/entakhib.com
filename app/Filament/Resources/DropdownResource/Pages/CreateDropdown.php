<?php

namespace App\Filament\Resources\DropdownResource\Pages;

use App\Filament\Resources\DropdownResource;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\CreateTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDropdown extends CreateRecord
{
    use CreateTranslatable;

    protected static string $resource = DropdownResource::class;
}
