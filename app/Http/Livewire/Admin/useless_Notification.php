<?php

namespace App\Http\Livewire\Admin;

use Auth;
use App\Models\Admin\ecom_admin_user;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\NotificationComponent;
    
class Notification extends Component
{
    use WithPagination, WithFileUploads, NotificationComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['deletetest' => 'deletetestRecord', 'updateStatusOftest' => '', 'updateDeviceToken' => 'handleUpdateDeviceToken'];

    public function mount()
    {
        $this->setMountData();
    }
    public function render()
    {
        return view('livewire.admin.notification');
    }
    public function handleUpdateDeviceToken($token)
    {
         $user = auth()->user();
         if ($user) 
         {
             $user->device_token = $token;
             $user->save();
         }

         $this->dispatchBrowserEvent('token_created', ['name' => 'dummy']);
    }
    public function sendNotification()
    {
        $this->validate();

        $ecom_notification = new ecom_notification();
        $ecom_notification->user_id = $user = auth()->user()->id;
        $ecom_notification->circular_id = null;
        $ecom_notification->message = $this->bodyMessage;
        $ecom_notification->read = null;
        $ecom_notification->save();

        $url = 'https://fcm.googleapis.com/fcm/send';

        $FcmToken = ecom_admin_user::whereNotNull('device_token')->pluck('device_token')->all();
        // $serverKey = 'app-server-key'; // ADD SERVER KEY HERE PROVIDED BY FCM
        $serverKey = 'AAAAPMgZejw:APA91bFjS_TPXqLyyXxGj_qJHRwB_-xiV1DFfxDfOjpqeKvmxxKI81F4XWbD8uyYdhQSV6R-ilX9vg5rfS7Fe2NNLBIIUl7cXiTlGsKOiCzicvP7rhyBnUigWGSKundOG4zcUulrAucQ';
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $this->title,
                "body" => $this->bodyMessage,  
            ]
        ];

        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);

        $this->title = "";
        $this->bodyMessage = "";

        // FCM response
        $this->emit('notificationSent');

        // return Redirect::route('notification.index')->with('status', 'Notification Generated!!');

        // return json_encode(['status' => 1]);
    }
}

