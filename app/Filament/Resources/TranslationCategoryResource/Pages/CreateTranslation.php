<?php

namespace App\Filament\Resources\TranslationCategoryResource\Pages;

use App\Filament\Resources\TranslationCategoryResource;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\CreateTranslatable;
use Filament\Resources\Pages\CreateRecord;

class CreateTranslation extends CreateRecord
{
    use CreateTranslatable;

    protected static string $resource = TranslationCategoryResource::class;
}
