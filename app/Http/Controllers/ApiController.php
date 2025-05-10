<?php

namespace App\Http\Controllers;

use App\Models\City\City;
use App\Models\District\District;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function districts($locale, City $city){
        return $city->districts->pluck('title', 'id');
    }

    public function clusters($locale, District $district){
        return $district->clusters->pluck('title', 'id');
    }
}
