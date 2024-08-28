<?php

namespace App\Http\Livewire\Admin\Notification;

use Livewire\Component;
use App\Models\Admin\ecom_notification;

class TokenCheck extends Component
{
    public $token;
    public $tokenFound;

    protected $listeners = ['CheckForDeviceToken' => 'HandleCheckForDeviceToken', 'add_token' => 'UpdateToken'];

    public function mount()
    {

        // dd(GetAllEmployees());
        // dd(GetAllEmployeesCount());
        // scopeAdmins
        // scopeEmployees

        // $NotificationMessages = ecom_notification::orderBy('created_at', 'desc')->take(4)->get();                   
        // $checkCount=0;

        // $token = 'dSfjMxHr_dqzRIk3_wx7V4:APA91bEHOt6_wNy9-biz-NQ23f6aYqdUbGdYIQkZaO_W6xEyCLMMuGHKYyfFcm-LodijYN545aGpCfZ1iI9rAWmR86YjAdtLccnyCD735-n9ej23UBU6AYLrsmFMb4fei_OqGtGS3r1h';
        // if (auth()->user()->device_token !== null && $token === auth()->user()->device_token) 
        // {
        //     $this->tokenFound = true;
        // } 
        // else
        // {
        //     $this->tokenFound = false;
        // }
        // $this->dispatchBrowserEvent('ReturnTokenCheckResponse', ['tokenFound' => $this->tokenFound, 'token_number' => $token]);

        // if($NotificationMessages)
        // {
        //     foreach($NotificationMessages as $notification)
        //     {
        //         dd($notification);
        //         dd(CheckAlignment($notification, 'notification'));
    
        //         if(CheckAlignment($notification, 'notification'))
        //         {
        //             $found = $notification->NotificationStatuses->where('user_id', auth()->user()->id)->where('read', 0)->first();
        //             if($found)
        //             {
        //                 $checkCount++;
        //             }
        //         }
        //     }
    
        //     $this->count = $checkCount;
        //     $this->notificationMessages = ecom_notification::orderBy('created_at', 'desc')->take(4)->get();    
    
        //     foreach($notificationMessages as $key => $Notification)
        //     {
        //         if(CheckAlignment($Notification, 'notification'))
        //         {
        //             if($Notification->NotificationStatuses->where('user_id', auth()->user()->id)->first()->read == 0)
        //             {
                        
        //             }
        //         }
        //     }

        // }


        // dd('coming');
        // if (auth()->user()->device_token !== null) 
        // {
        //     $this->tokenFound = true;
        // } 
        // else
        // {
        //     $this->tokenFound = false;
        // }
    }
    public function render()
    {
        return view('livewire.admin.notification.token-check');
    }
    public function HandleCheckForDeviceToken($token)
    {       
        if (auth()->user()->device_token !== null && $token === auth()->user()->device_token) 
        {
            $this->tokenFound = true;
        } 
        else
        {
            $this->tokenFound = false;
        }

        $this->dispatchBrowserEvent('ReturnTokenCheckResponse', ['tokenFound' => $this->tokenFound, 'token_number' => $token]);
    }
    public function UpdateToken($token)
    {
        auth()->user()->device_token = $token;
        auth()->user()->save();

        $this->dispatchBrowserEvent('token_added', ['tokenFound' => $token]);
    }
}
