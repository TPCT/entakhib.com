<?php

namespace App\Exports;

use App\Helpers\BaseExport;
use Illuminate\Support\HtmlString;
use pxlrbt\FilamentExcel\Columns\Column;

class ProfileExport extends BaseExport
{
    protected array $exclude = [
        'id', 'city_id', 'district_id', 'otp', 'remember_token'
    ];

    public function fromModel(): static
    {
        parent::fromModel()
            ->except(fn ($model) => $this->ignore())
            ->withColumns(function($model) {
                return [
                    Column::make('full_name')
                        ->heading(__('Name')),
                    Column::make('email')
                        ->heading(__('Email')),
                    Column::make('phone_number')
                        ->heading(__('Phone')),
                    Column::make('city.title')
                        ->heading(__('City')),
                    Column::make('district.title')
                        ->heading(__('District')),
                    Column::make('date_of_birth')
                        ->heading(__('Date of Birth')),
                    Column::make('cluster_or_party')
                        ->heading(__('Cluster/Party'))
                        ->getStateUsing(function ($record){
                            $content = "";
                            if ($record->cluster_votes->count())
                                $content .= __("site.Cluster") . ": " . $record->cluster_votes()->first()->title . "\n";
                            if ($record->party_votes->count())
                                $content .= __("site.Party") . ": " . $record->party_votes()->first()->title;
                            return $content ?: __("site.Hasn't Voted Yet ...");
                        }),
                    Column::make('candidates')
                        ->heading(__('Candidates'))
                        ->getStateUsing(function ($record){
                            $content = "-----";
                            if ($record->candidate_votes->count()){
                                $content = "";
                                foreach($record->candidate_votes as $candidate_vote){
                                    $content .= $candidate_vote->title . "\n";
                                }
                            }
                            return $content;
                        })
                ];
            });
        return $this;
    }
}
