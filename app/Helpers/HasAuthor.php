<?php

namespace App\Helpers;

use App\Models\User;
use Filament\Facades\Filament;

trait HasAuthor
{
    public static function bootHasAuthor(): void{
        parent::creating(function($query){
            if ($query->user_id)
                return;
            $query->user_id = Filament::auth()->user()->id;
        });
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
