<?php

namespace App\Http\Controllers\AdminApis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Admin\ecom_admin_user;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function GetOPT($employee_code)
    {
        $employee = ecom_admin_user::where('employee_id', $employee_code)->first();

        if ($employee) 
        {
            // $OTP_code = GenerateOTP();
            // $employee->update(['password' => Hash::make($OTP_code)]);

            return response()->json([
                'status' => true,
                'data' => $employee->OPT_code
            ]);

        } else {
            return response()->json([
                'status' => false,
                'message' => 'OPT code not found.'
            ], 404);
        }
    }

    // public function generateOTP($length = 6)
    // {
    //     $digits = '0123456789';
    //     $otp = '';
    //     for ($i = 0; $i < $length; $i++) {
    //         $otp .= $digits[random_int(0, strlen($digits) - 1)];
    //     }
    //     return $otp;
    // }
    
}
