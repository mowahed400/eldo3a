<?php

namespace App\Traits;

use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

trait GlobalObserversTraits
{
    public static function booted()
    {
        static::created(function ($model){
            Setting::set('hash_version',Hash::make(now()->timestamp));
        });

        static::updated(function ($model){
            Setting::set('hash_version',Hash::make(now()->timestamp));
        });

        static::deleted(function ($model){
            Setting::set('hash_version',Hash::make(now()->timestamp));
        });
    }
}
