<?php

namespace App\Helpers;


use Carbon\Carbon;

trait HasTimestamps
{
    public function publishedAt(): string
    {
        $months = [
            1 => 'كانون الثاني',
            2 => 'شباط',
            3 => 'آذار',
            4 => 'نيسان',
            5 => 'أيار',
            6 => 'حزيران',
            7 => 'تموز',
            8=> 'آب',
            9 => 'أيلول',
            10 => 'تشرين الأول',
            11 => 'تشرين الثاني',
            12 => 'كانون الأول'
        ];
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->published_at);
        return preg_replace('/ [a-zA-Z]* /m', ' ' . $months[$date->month] . ' ', $date->format('d M Y'));
    }

    public function publishedAtForHumans(): string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->published_at)->format('M jS Y');
    }

    public function publishedAtForHumans2(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->published_at)->format('M d, Y');
    }
}
