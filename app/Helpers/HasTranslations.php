<?php

namespace App\Helpers;

trait HasTranslations
{
    public $translationForeignKey = "parent_id";
    public $localeKey = "language";


    public function scopeTranslations($query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->with('translations');
    }

    public static function bootHasTranslations(){
        static::addGlobalScope('translations', function ($builder) {
            $builder->with('translations');
        });
    }

}