<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Admin\ecom_admin_user;
use Illuminate\Support\Facades\Redirect;


class NotificationController extends Controller
{
    public function index()
    {
         return view('Admin/notification/index');
    }

    // public function updateDeviceToken(Request $request)
    // {
    //     Auth::user()->device_token =  $request->token;

    //     Auth::user()->save();

    //     return response()->json(['Token successfully stored.']);
    // }
    
    // public function sendNotification(Request $request)
    // {
    //     $url = 'https://fcm.googleapis.com/fcm/send';

    //     $FcmToken = ecom_admin_user::whereNotNull('device_token')->pluck('device_token')->all();
            
        
    //     // $serverKey = 'app-server-key'; // ADD SERVER KEY HERE PROVIDED BY FCM
    //     $serverKey = 'AAAAPMgZejw:APA91bFjS_TPXqLyyXxGj_qJHRwB_-xiV1DFfxDfOjpqeKvmxxKI81F4XWbD8uyYdhQSV6R-ilX9vg5rfS7Fe2NNLBIIUl7cXiTlGsKOiCzicvP7rhyBnUigWGSKundOG4zcUulrAucQ';
    //     $data = [
    //         "registration_ids" => $FcmToken,
    //         "notification" => [
    //             "title" => $request->title,
    //             "body" => $request->body,  
    //         ]
    //     ];

    //     $encodedData = json_encode($data);
    
    //     $headers = [
    //         'Authorization:key=' . $serverKey,
    //         'Content-Type: application/json',
    //     ];
    
    //     $ch = curl_init();
        
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //     curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    //     // Disabling SSL Certificate support temporarly
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
    //     // Execute post
    //     $result = curl_exec($ch);
    //     if ($result === FALSE) {
    //         die('Curl failed: ' . curl_error($ch));
    //     }        
    //     // Close connection
    //     curl_close($ch);
    //     // FCM response
    //     // dd($result);
    //     // Redirect back to the notification.index route with a flashed session message
    //     return Redirect::route('notification.index')->with('status', 'Notification Generated!!');

    //     // return json_encode(['status' => 1]);
    // }


    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}
