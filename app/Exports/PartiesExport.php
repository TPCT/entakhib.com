<?php

namespace App\Exports;

use App\Helpers\BaseExport;
use App\Settings\General;
use pxlrbt\FilamentExcel\Columns\Column;

class PartiesExport extends BaseExport
{
    public function fromModel(): static
    {
        parent::fromModel()
            ->withColumns([
                Column::make("title")
                    ->heading(__("Name"))
                    ->formatStateUsing(function ($state, $record){
                        return $record->title;
                    })
                    ->getStateUsing(function ($record) {
                        return $record->title;
                    }),
                Column::make("votes_count")
                    ->heading(__("Votes"))
                    ->formatStateUsing(function ($state, $record){
                        return $record->votes;
                    })
                    ->getStateUsing(function ($record) {
                        return $record->votes;
                    })
            ])
            ->only([
                'title',
                'votes_count',
            ]);
        return $this;
    }
}
