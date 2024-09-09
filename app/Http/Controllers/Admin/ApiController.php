<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use App\Models\Admin\ecom_module_permissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ApiController extends Controller
{
    // ---------------------  exception for super admin login work ----------------------
    public function login(Request $request)
    {
        // $response = [
        //     'status' => 0,
        //     'message' => 'api is working fine',
        // ];
        // return response()->json($response, 404);

        if (isset($request->user_id) && isset($request->password)) 
        {
            $user_id = $request->user_id;
            $password = $request->password;
            
            $result = User::where('username', $request->user_id);

            if($result->exists()) 
            {
                $result = $result->first();

                if ($result->is_active == 1) 
                {
                    $credentials = ['username' => $request->user_id, 'password' => $request->password];

                    // -------------------- authenticate user using OPT --------------------------

                    if (Auth::attempt($credentials)) 
                    {
                        // $user = Auth::user();
                        $result->last_login = date('Y-m-d H:i:s');
                        $result->save();

                        $response = [
                            'status' => 1,
                            'data' => $result,
                            'message' => 'Login successfully',
                        ];
                        return response()->json($response, 200);
                    }
                }
                else
                {
                    $response = [
                        'status' => 0,
                        'message' => 'User Not Activated',
                    ];
                    return response()->json($response, 404);
                }
            }
            else
            {
                $response = [
                    'status' => 0,
                    'message' => 'User Not Found',
                ];
                return response()->json($response, 404);
            }
        }
    }

    public function SetOTP(Request $request)
    {
        if (isset($request->code) && isset($request->numberDigit)) 
        {
            $employee_code = $request->code;
            $LastDigits = $request->numberDigit;            
            $employee = ecom_admin_user::where('employee_id', $employee_code)->whereRaw('RIGHT(phone, 4) = ?', [$LastDigits]);

            if($employee->exists()) 
            {
                $employee = $employee->first();

                if ($employee->is_active == 1) 
                {
                    $employee->update(['otp_code' => GenerateOTP(), 'otp_expires_at' => Carbon::now()->addMinutes(1)]);   // OTP valid for 10 minutes
                    
                    $response = [
                        'status' => 1,
                        'data' => $employee->full_name,
                        'message' => 'OTP sent to Hum Leopards App Successfully!!!',
                    ];

                    return response()->json($response, 200);
                }
                else
                {
                    $response = [
                        'status' => 0,
                        'message' => 'User Not Activated',
                    ];

                    return response()->json($response, 404);
                }
            }  
            else
            {
                $response = [
                    'status' => 0,
                    'message' => 'User Not Found With Given Id Or Phone Number',
                ];
            }  

            return response()->json($response, 404);
        }  

                
        $response = [
            'status' => true,
            'message' => $request->all(),
        ];

        return response()->json($response, 404);
    }

    public function GetOTP(Request $request)
    {
        $RequestData = $request->all();

        // return response()->json([
        //     'status' => true,
        //     'data' => $RequestData,
        //     'expire_at' => $RequestData
        // ]);

        $employee = ecom_admin_user::where('employee_id', $RequestData['employee_code'])->first();

        if ($employee) 
        {
            // $OTP_code = GenerateOTP();
            // $employee->update(['password' => Hash::make($OTP_code)]);

            if ($employee->otp_code != null && Carbon::now()->lessThanOrEqualTo($employee->otp_expires_at))
            {
                if($employee->otp_code != null)
                {
                    return response()->json([
                        'status' => true,
                        'data' => $employee->otp_code,
                        'expire_at' => $employee->otp_expires_at
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'status' => false,
                    'message' => 'OTP Not Set or Expired.'
                ], 404);    
            }
        }
        else 
        {
            return response()->json([
                'status' => false,
                'message' => 'Employee Not Fund.'
            ], 404);
        }
    }
    public function SuccessfulLogin($result)
    {
        // Invalidate the OTP
        $result->update([
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        $user = Auth::user();
        $result->last_login = date('Y-m-d H:i:s');
        $result->save();

        return [
            'status' => 1,
            'data' => $user,
            'message' => 'Login successfully',
        ];
        
    }
    // public function login(Request $request)
    // {

        
    //     // $response = [
    //     //     'status' => 0,
    //     //     'message' => 'api is working fine',
    //     // ];
    //     // return response()->json($response, 404);


    //     if (isset($request->user_id) && isset($request->password)) 
    //     {
            
    //         $user_id = $request->user_id;
    //         $password = $request->password;
            
    //         $result = ecom_admin_user::where('username',$request->user_id);

    //         if($result->exists()) 
    //         {
    //             $result = $result->first();

    //             if($result->user_type_id == 1 || $result->user_type_id == 3 ) 
    //             {
    //                 if ($result->is_active == 1) 
    //                 {
    //                     if (Auth::attempt(['username' => $request->user_id, 'password' => $request->password])) 
    //                     {
    //                         $user = Auth::user();

    //                         $ModuleIds = ecom_module_permissions::where('role_id', $user->role_id)
    //                                         ->where('is_deleted', 0)
    //                                         ->distinct()
    //                                         ->pluck('module_id')
    //                                         ->toArray();
    //                         $sub_modules = ecom_module_permissions::where('role_id', $user->role_id)
    //                                         ->where('is_deleted', 0)
    //                                         ->distinct()
    //                                         ->pluck('sub_module_id')
    //                                         ->toArray();
    //                         $screens = ecom_module_permissions::where('role_id', $user->role_id)
    //                                         ->where('is_deleted', 0)
    //                                         ->pluck('screen_permission_id')
    //                                         ->toArray();

    //                         $token = $user->createToken('MyApp')->plainTextToken;
    //                         $result->customer_service_call_token = $token;
    //                         $result->last_login = date('Y-m-d H:i:s');
    //                         $result->save();

    //                         $response = [
    //                             'status' => 1,
    //                             'data' => $user,
    //                             'permissions' => array('module_id'=>$ModuleIds,'sub_module_id'=>$sub_modules,'screens'=>$screens),
    //                             'token' => $token,
    //                             'message' => 'Login successfully',
    //                         ];

    //                         return response()->json($response, 200);
    //                     }
    //                     else
    //                     {
    //                         $response = [
    //                             'status' => 0,
    //                             'message' => 'Credentials Not Match',
    //                         ];
    //                         return response()->json($response, 404);
    //                     }
    //                 }
    //                 else
    //                 {
    //                     $response = [
    //                         'status' => 0,
    //                         'message' => 'User Not Activated',
    //                     ];
    //                     return response()->json($response, 404);
    //                 }
    //             }else{
    //                 $response = [
    //                     'status' => 0,
    //                     'message' => 'Only Leopards Authorize Users are Allowed',
    //                 ];
    //                 return response()->json($response, 404);
    //             }
    //         }else{
    //             $response = [
    //                 'status' => 0,
    //                 'message' => 'User Not Found',
    //             ];
    //             return response()->json($response, 404);
    //         }
    //     }
    // }



}
