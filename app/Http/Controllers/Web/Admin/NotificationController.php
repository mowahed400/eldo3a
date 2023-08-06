<?php

namespace App\Http\Controllers\Web\Admin;

use App\Contracts\NotificationContract;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\NotificationsTokens;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * @var NotificationContract
     */
    protected NotificationContract $notification;

    /**
     * @param NotificationContract $notification
     */
    public function __construct(NotificationContract $notification)
    {
        $this->notification = $notification;

        $this->middleware(['permission:create-admin-notification'])->only(['create', 'store']);
        $this->middleware(['permission:view-admin-notification'])->only(['index','show']);
        $this->middleware(['permission:edit-admin-notification'])->only(['edit','update']);
        $this->middleware(['permission:delete-admin-notification'])->only(['destroy']);
    }

    public function index(Request $request)
    {
        $notifications = $this->notification->setPerPage($request->input('per_page'))->findByFilter();

        if ($request->wantsJson())
        {
            return response()->json(compact('notifications'));
        }

        return view('admin.notifications.index',compact('notifications'));
    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('admin.notifications.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:240',
            'message' => 'required|string',
            'receivers' => 'required|in:0,1,2,'
        ]);


        $this->notification->new($data);
        session()->flash('success',__('messages.flash.create'));
        return redirect()->route('admin.notifications.index');
    }

    /**
     * @param $id
     * @return Renderable
     */
    public function show($id): Renderable
    {
        $notification = $this->notification->findOneById($id);
        return view('admin.notifications.index',compact('notification'));
    }

    /**
     * @param $id
     * @return Renderable
     */
    public function edit($id):Renderable
    {
        $notification = $this->notification->findOneById($id);
        return view('admin.notifications.edit',compact('notification'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function update($id,Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:240',
            'message' => 'required|string',
            'receivers' => 'required|in:1,2'
        ]);
        $this->notification->update($id,$data);
        session()->flash('success',__('messages.flash.update'));
        return redirect()->route('admin.notifications.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $this->notification->destroy($id);
        session()->flash('success',__('messages.flash.delete'));
        return redirect()->route('admin.notifications.index');
    }


    public function send($id)
    {


       return AdminNotification::find($id);


        $tokens =NotificationsTokens::all('token');
        $SERVER_API_KEY = env('FIREBASE_SERVER_API_KEY');


        $fcmTokens = [];
        for ($i=0;$i<count($tokens);$i++){
            $fcmTokens[$i] = $tokens[$i]['token'];
        }

        if(count($tokens)>0){

            $data = [

                "registration_ids" =>$fcmTokens,

                "notification" => [
                    "title" => 'Welcome',
                    "body" => 'Description',
                    "image" => 'https://bit.ly/3nWUKiM',
                    "sound"=> "default" // required for sound on ios
                ],

            ];

            $dataString = json_encode($data);

            $headers = [

                'Authorization: key=' . $SERVER_API_KEY,

                'Content-Type: application/json',

            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $response = curl_exec($ch);
            $response =  json_decode($response);

            if($response->success!=0){
                session()->flash('success',__('messages.flash.success'));
                return redirect()->back();
            }
            else{
                session()->flash('error',__('messages.flash.failed'));
                return redirect()->back();
            }

        }else{
            return [count($tokens)>0,'its empty'];
        }

    }

}
