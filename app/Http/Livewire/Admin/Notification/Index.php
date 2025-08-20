<?php

namespace App\Http\Livewire\Admin\Notification;

use Livewire\Component;
use App\Models\Admin\ecom_notification;
use App\Models\Admin\ecom_notifications_status;
use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\ecom_department;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Auth;
use Illuminate\Support\Facades\Redirect;
use App\Traits\livewireComponentTraits\NotificationComponent;
use App\Traits\livewireComponentTraits\CourseAssignCSVComponent;
use GuzzleHttp\Client;

class Index extends Component
{
    use WithPagination, WithFileUploads, NotificationComponent;

    public $content;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
                                'CheckForDeviceToken' => 'handleCheckForDeviceToken',
                                'updateDeviceToken' => 'handleUpdateDeviceToken',
                                'deleteNotificationManage' => 'HandleDeleteSendNotification',
                                'LoadDataNow' => 'loadDropDownData',
                                'LoadEmployeeNowCount' => 'loadedEmployeeDataCount',   //utilize course align listener,
                                'UpdateValue' => 'HandleUpdateValue',
                                'sendNotificationEvent' => 'sendNotification',
                                'SetNotificationBodyEvent' => 'SetNotificationBody',
                            ];

    public function mount(ecom_notification $ecom_notification)
    {
        $this->setMountData($ecom_notification);
    }
    public function render()
    {
        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.notification.index', $this->RenderData());
    }
    public function handleUpdateDeviceToken($token)
    {
         $user = auth()->user();
         if ($user)
         {
             $user->device_token = $token;
             $user->save();
         }
         $this->Collapse = "uncollapse";
         $this->dispatchBrowserEvent('token_created', ['name' => 'dummy']);
    }
    public function sendNotification()
    {
        // GetDeviceTokensJob::dispatch();

        $this->ecom_notification = ReplaceStringAttributeValuesWithNull($this->ecom_notification);
        // $this->ecom_notification->user_id = auth()->user()->id;
        // $this->ecom_notification->sub_department_id = null;
        $this->validate();

        if($this->ecom_notification->department_id != null)
        {
            // $ecom_department = ecom_department::where('department_id', $this->ecom_notification->department_id)->first();
            // $this->ecom_notification->department_id = $ecom_department->department_id;
        }



        $url = 'https://fcm.googleapis.com/fcm/send';

        // $FcmToken = ecom_admin_user::whereNotNull('device_token')->pluck('device_token')->all();
        $FcmTokens = $this->GetFilterTokens();
        $FcmTokens[auth()->user()->id] = auth()->user()->device_token;  //also send to me as i am logged in super admin

        //============== method 1 using curl ====================

        $serverKey = 'AAAAPMgZejw:APA91bFjS_TPXqLyyXxGj_qJHRwB_-xiV1DFfxDfOjpqeKvmxxKI81F4XWbD8uyYdhQSV6R-ilX9vg5rfS7Fe2NNLBIIUl7cXiTlGsKOiCzicvP7rhyBnUigWGSKundOG4zcUulrAucQ';
        $data = [
            // "registration_ids" => $FcmTokens,
            "registration_ids" => array_keys($FcmTokens),
            "notification" => [
                "title" => $this->ecom_notification->title,
                "body" => $this->ecom_notification->messagebody,
            ]
        ];

        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();                              //Initializes a cURL session to prepare for making the HTTP request.

        curl_setopt($ch, CURLOPT_URL, $url);            // functions are used to configure options for the cURL session, including setting the URL, HTTP method, headers, data to be sent, and SSL options
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);                       //Executes the cURL request and stores the result. If the execution fails ($result === FALSE), it outputs the error message and terminates the script


        if ($result === FALSE)
        {
            die('Curl failed: ' . curl_error($ch));
        }

        curl_close($ch);                                // Closes the cURL session after the request is completed

        // dd($result);
        //============== method 2 using guzzle ====================

            // $client = new Client([
            //     'base_uri' => 'https://fcm.googleapis.com/',
            //     'timeout'  => 2.0,
            // ]);

            // $FcmTokens = ecom_admin_user::whereNotNull('device_token')->pluck('device_token')->all();
            // $serverKey = 'AAAAPMgZejw:APA91bFjS_TPXqLyyXxGj_qJHRwB_-xiV1DFfxDfOjpqeKvmxxKI81F4XWbD8uyYdhQSV6R-ilX9vg5rfS7Fe2NNLBIIUl7cXiTlGsKOiCzicvP7rhyBnUigWGSKundOG4zcUulrAucQ';

            // $response = $client->post('fcm/send', [
            //     'headers' => [
            //         'Authorization' => 'key=' . $serverKey,
            //         'Content-Type' => 'application/json',
            //     ],
            //     'json' => [
            //         "registration_ids" => $FcmTokens,
            //         "notification" => [
            //             "title" => $this->ecom_notification->title,
            //             "body" => $this->ecom_notification->messagebody,
            //         ],
            //     ],
            // ]);
            // $result = $response->getBody()->getContents();

        //===================Store record in db ===============

            $resultArray = json_decode($result, true); // true to get an associative array
            $this->ecom_notification->user_id = Auth()->user()->id;
            $this->ecom_notification->multicast_id = isset($resultArray['multicast_id']) ? $resultArray['multicast_id'] : null;
            $this->ecom_notification->firebase_message_id = isset($resultArray['results'][0]['message_id']) ? $resultArray['results'][0]['message_id'] : null;
            $this->ecom_notification->save();

        // ======================ecom_notifications_status============================

            foreach($FcmTokens as $user_id => $user_device_token)
            {
                ecom_notifications_status::create([
                    'notification_id' => $this->ecom_notification->id,
                    'user_id' => $user_id,
                    'device_token' => $user_device_token,
                ]);
            }

        // ======================ecom_notifications_status============================

        $this->ecom_notification = new ecom_notification();

        $this->emit('refreshNotificationCount');
        $this->dispatchBrowserEvent('notificationSent', ['name' => 'dummy']);
        $this->Collapse = "collapse";
    }
    public function handleCheckForDeviceToken()
    {
        $this->dispatchBrowserEvent('ReturnTokenCheckResponse', ['name' => 'dummy']);
    }
    public function GetFilterTokens()
    {

        // dd($this->ecom_notification);
        $deviceTokens = [];

        if (
            $this->ecom_notification->user_id !== null ||
            $this->ecom_notification->instructor_id !== null ||
            $this->ecom_notification->employee_id !== null ||
            $this->ecom_notification->department_id !== null ||
            $this->ecom_notification->sub_department_id !== null ||
            $this->ecom_notification->role_id !== null ||
            $this->ecom_notification->zone_name !== null ||
            $this->ecom_notification->city_id !== null ||
            $this->ecom_notification->branch_id !== null ||
            $this->ecom_notification->shift_time_id !== null
        )   // it is notification, get specified token and make bridge for tracking
        {
            if($this->ecom_notification->instructor_id != null)
            {
                if(!empty(SpecificInstructorToken($this->ecom_notification->instructor_id)->toArray()))
                {
                    $deviceTokens['instructor_token'] = SpecificInstructorToken($this->ecom_notification->instructor_id)->toArray();
                }
            }


            if($this->ecom_notification->employee_id != null)
            {

                if(!empty(SpecificInstructorToken($this->ecom_notification->employee_id)->toArray()))
                {
                    $deviceTokens['employee_token'] = SpecificInstructorToken($this->ecom_notification->employee_id)->toArray();
                }
            }


            if($this->ecom_notification->department_id != null)
            {
                if(!empty(SpecificDepartmentEmployeeTokens($this->ecom_notification->department_id)->toArray()))
                {
                    $deviceTokens['department_tokens'] = SpecificDepartmentEmployeeTokens($this->ecom_notification->department_id)->toArray();
                }
            }

            if($this->ecom_notification->sub_department_id != null)
            {

                if(!empty(SpecificSubDepartmentEmployeeTokens($this->ecom_notification->sub_department_id)->toArray()))
                {
                    $deviceTokens['sub_department_tokens'] = SpecificSubDepartmentEmployeeTokens($this->ecom_notification->sub_department_id)->toArray();
                }
            }
            if($this->ecom_notification->zone_code != null)
            {
                if(!empty(SpecificZoneEmployeeTokens($this->ecom_notification->zone_code)->toArray()))
                {
                    $deviceTokens['zone_employees'] = SpecificZoneEmployeeTokens($this->ecom_notification->zone_code)->toArray();
                }

                // $zone_employees = SpecificZoneEmployees($this->ecom_notification->zone_name)->toArray();
                // $deviceTokens['zone_employees'] = $this->GetTokens($zone_employees);
            }

            if($this->ecom_notification->city_id != null)
            {

                if(!empty(SpecificCityEmployeeTokens($this->ecom_notification->city_id)->toArray()))
                {
                    $deviceTokens['city_employees'] = SpecificCityEmployeeTokens($this->ecom_notification->city_id)->toArray();
                }

                // $city_employees = SpecificCityEmployees($this->ecom_notification->city_id)->toArray();
                // $deviceTokens['city_employees'] = $this->GetTokens($city_employees);
            }


            if($this->ecom_notification->branch_id != null)
            {
                if(!empty(SpecificBranchEmployeeTokens($this->ecom_notification->branch_id)->toArray()))
                {
                    $deviceTokens['branch_employees'] = SpecificBranchEmployeeTokens($this->ecom_notification->branch_id)->toArray();
                }

                // $branch_employees = SpecificBranchEmployees($this->ecom_notification->branch_id)->toArray();
                // $deviceTokens['branch_employees'] = $this->GetTokens($branch_employees);
            }

            if($this->ecom_notification->role_id != null)
            {
                if(!empty(SpecificDesignationEmployeeTokens($this->ecom_notification->role_id)->toArray()))
                {
                    $deviceTokens['designation_employees'] = SpecificDesignationEmployeeTokens($this->ecom_notification->role_id)->toArray();
                }

                // $designation_employees = SpecificDesignationEmployees($this->ecom_notification->role_id)->toArray();
                // $deviceTokens['designation_employees'] = $this->GetTokens($designation_employees);
            }

            if($this->ecom_notification->shift_time_id != null)
            {
                if(!empty(SpecificScheduleEmployeeTokens($this->ecom_notification->shift_time_id)->toArray()))
                {
                    $deviceTokens['schedule_employees'] = SpecificScheduleEmployeeTokens($this->ecom_notification->shift_time_id)->toArray();
                }

                // $schedule_employees = SpecificScheduleEmployees($this->ecom_notification->shift_time_id)->toArray();
                // $deviceTokens['schedule_employees'] = $this->GetTokens($schedule_employees);
            }

            if(!empty($deviceTokens))   // Remove duplicate tokens
            {
                $flattenedArray = [];
                foreach ($deviceTokens as $subArray)
                {
                    $flattenedArray += $subArray;
                }
                return array_unique($flattenedArray, SORT_REGULAR);
            }

                // $keys = array_keys($deviceTokens);
                // $values = array_values($deviceTokens);

                // if(in_array('instructor_token', $keys))
                // {
                //     $finalTokens[] = $deviceTokens['instructor_token'];
                // }
                // if(in_array('employee_token', $keys))
                // {
                //     $finalTokens[] = $deviceTokens['employee_token'];
                // }

                // if(in_array('department_tokens', $keys))
                // {
                //     // dd($deviceTokens['employee_token']);
                //     if(!empty($finalTokens))
                //     {
                //         dd($deviceTokens['department_tokens']);
                //        $finalTokens = array_push($finalTokens, $deviceTokens['department_tokens']);

                //        dd($deviceTokens['department_tokens']);
                //        $finalTokens = array_merge($deviceTokens['department_tokens'], $finalTokens);
                //     }
                //     else
                //     {
                //         $finalTokens = $deviceTokens['department_tokens'];
                //     }
                //     dd($finalTokens);

                //     $finalTokens = !empty($finalTokens) ? array_merge($deviceTokens['department_tokens'], $finalTokens) : $deviceTokens['department_tokens'];
                // }
                // dd($finalTokens);
                // if(in_array('sub_department_tokens', $keys))
                // {
                //     $finalTokens = !empty($finalTokens) ? array_merge($deviceTokens['sub_department_tokens'], $finalTokens) : $deviceTokens['sub_department_tokens'];
                // }
                // if(in_array('zone_employees', $keys))
                // {
                //     $finalTokens = !empty($finalTokens) ? array_merge($deviceTokens['zone_employees'], $finalTokens) : $deviceTokens['zone_employees'];
                // }
                // if(in_array('city_employees', $keys))
                // {
                //     $finalTokens = !empty($finalTokens) ? array_merge($deviceTokens['city_employees'], $finalTokens) : $deviceTokens['city_employees'];
                // }
                // if(in_array('branch_employees', $keys))
                // {
                //     $finalTokens = !empty($finalTokens) ? array_merge($deviceTokens['branch_employees'], $finalTokens) : $deviceTokens['branch_employees'];
                // }
                // if(in_array('designation_employees', $keys))
                // {
                //     $finalTokens = !empty($finalTokens) ? array_merge($deviceTokens['designation_employees'], $finalTokens) : $deviceTokens['designation_employees'];
                // }
                // if(in_array('schedule_employees', $keys))
                // {
                //     $finalTokens = !empty($finalTokens) ? array_merge($deviceTokens['schedule_employees'], $finalTokens) : $deviceTokens['schedule_employees'];
                // }

                // dd($finalTokens);

                // if(isset($finalTokens))
                // {
                //     return array_unique($finalTokens);
                // }
        }
        else  // it is a circular, get specified token and make bridge for tracking

        {
            // it is a circular, get specified token and make bridge for tracking
            return ecom_admin_user::whereNotNull('device_token')->pluck('device_token', 'id')->all();
            // $FcmCircularTokens = ecom_admin_user::whereNotNull('device_token')->pluck('device_token', 'id')->all();
        }


    }
    public function GetTokens($emloyees)
    {
        // dd($emloyees);
        $emloyees = array_filter($emloyees, function($emloyee)
        {
            return $emloyee['device_token'] != null;
        });

        return array_map(function($employee) {
            return $employee['device_token'];
        }, $emloyees);
    }
    public function SetNotificationBody($editorText)
    {

        $this->ecom_notification->messagebody = $editorText;
        $this->content = $editorText;
        $this->Collapse = "uncollapse";
    }

}
