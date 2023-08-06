<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function __invoke()
    {
        return response()->json([
            'hash_version' => settings('hash_version'),
            'languages' => array_keys(getLangs())
        ]);
    }
}
