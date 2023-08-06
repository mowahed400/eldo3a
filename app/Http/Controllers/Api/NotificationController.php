<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\AdminNotification;
use Illuminate\Http\Request;
use App\Models\NotificationsTokens;

class NotificationController extends Controller
{

    public function getNotifications(){
        $notifications = AdminNotification::all();
        return  NotificationResource::collection($notifications);
    }


    public function storeToken(Request $request){

        $data= $request->validate([
            'token' => 'required',
        ]);

        $token = NotificationsTokens::create($data);
        return json_encode([
            'success'=>'true',
            'data'=>$token,
            'message'=>'Device token has been stored'
        ]);



    }
}
