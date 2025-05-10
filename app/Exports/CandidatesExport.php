<?php

namespace App\Exports;

use App\Helpers\BaseExport;
use App\Settings\General;
use pxlrbt\FilamentExcel\Columns\Column;

class CandidatesExport extends BaseExport
{
    public function fromModel(): static
    {
        parent::fromModel()
            ->withColumns([
                Column::make('title')
                    ->heading(__("Name"))
                    ->formatStateUsing(function ($state, $record){
                        return $record->title;
                    })
                    ->getStateUsing(function ($record) {
                        return $record->title;
                    }),
                Column::make('cluster')
                    ->heading("Cluster/Party")
                    ->formatStateUsing(function ($state, $record){
                        return $record->cluster?->title ?? $record->party?->title ?? __('site.undefined');
                    })
                    ->getStateUsing(function ($record) {
                        return $record->cluster?->title ?? $record->party?->title ?? __("site.undefined");
                    }),
                Column::make('votes_count')
                    ->heading("Votes")
                    ->formatStateUsing(function ($state, $record){
                        return $record->votes;
                    })
                    ->getStateUsing(function ($record) {
                        return $record->votes;
                    }),
                Column::make('extra_votes_count')
                    ->heading("Extra Votes")
                    ->formatStateUsing(function ($state, $record){
                        return $record->extra_votes;
                    })
                    ->getStateUsing(function ($record) {
                        return $record->extra_votes;
                    })
            ])
            ->only([
                'title',
                'cluster',
                'votes_count',
                'extra_votes_count'
            ]);
        return $this;
    }
}
