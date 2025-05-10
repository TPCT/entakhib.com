<?php

namespace App\Filament\Resources\SeoLinkResource\Pages;

use App\Filament\Resources\SeoLinkResource;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\CreateTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSeoLink extends CreateRecord
{
    use CreateTranslatable;

    protected static string $resource = SeoLinkResource::class;
}
