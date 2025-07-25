<?php

namespace App\Filament\Resources\DistrictResource\Pages;

use App\Filament\Resources\DistrictResource;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\EditTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDistrict extends EditRecord
{
    use EditTranslatable;

    protected static string $resource = DistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
