<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Namaz extends Model
{
    protected $fillable = [
        'fajr', 'dhuhr', 'asr','maghrib','isha','user_id'
    ];
    //
}
