<?php

namespace App\Http\Livewire\Admin\Notification;

use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use App\Models\Admin\ecom_notification;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class NotificationCount extends Component
{
    protected $listeners = ['refreshNotificationCount' => 'UpdateData'];
    public $notificationMessages;
    public $count;
    
    public function mount()
    {
        // $this->notificationMessages = ecom_notification::orderBy('created_at', 'desc')->take(4)->get();
        $this->UpdateCount();
                
    }
    public function render()
    {
        return view('livewire.admin.notification.notification-count');
    }
    public function UpdateData()
    {
        $this->UpdateCount();
    }
    public function UpdateCount()
    {
        $NotificationMessages = ecom_notification::orderBy('created_at', 'desc')->take(4)->get();                   
        $checkCount=0;

        foreach($NotificationMessages as $notification)
        {
            if(CheckAlignment($notification, 'notification'))
            {
                $found = $notification->NotificationStatuses->where('user_id', auth()->user()->id)->where('read', 0)->first();
                if($found)
                {
                    $checkCount++;
                }
            }
        }

        $this->count = $checkCount;
        $this->notificationMessages = ecom_notification::orderBy('created_at', 'desc')->take(4)->get();                                            
    }
    public function UpdateNotificationToRead(ecom_notification $ecom_notification)
    {
        $user_status = $ecom_notification->NotificationStatuses->where('user_id', auth()->user()->id)->first();
        $user_status->update(['read' => 1]);

        $this->UpdateCount();
        return Redirect::route('notification.index');
    }
    public function UpdateNotificationToSeen()
    {
        //    $this->notificationMessages = ecom_notification::orderBy('created_at', 'desc')
        //                                                 ->take(4)
        //                                                 ->get();
            
        //     foreach($this->notificationMessages as $notification)
        //     {
        //         $user_status = $notification->NotificationStatuses->where('user_id', auth()->user()->id)->first();
        //         // $user_status->update(['seen' => 1]);
        //     }

        // dd('awdawd');
        // $notificationMessages = ecom_notification::
                                        // where('read_notification', 0)
                                        //   where('seen', 0)
                                        // orderBy('created_at', 'desc')
                                        // take(4)
                                        // ->get();
        // dd($notificationMessages);
        // foreach($notificationMessages as $notification) 
        // {
        //     $notification->update(['seen' => 1]);
        // }
        // $this->UpdateCount();
        
    }
}
