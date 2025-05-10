<?php

namespace App\Models\Slider;

use App\Helpers\HasAuthor;
use App\Helpers\HasMedia;
use App\Helpers\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderSlide extends Model
{
    use HasFactory, HasAuthor, HasStatus, HasMedia;

    protected $guarded = [
        'id', 'created_at', 'updated_at',
    ];
}
