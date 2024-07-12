<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Models\Admin\ecom_admin_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // added test msg
        // $user=  ecom_admin_user::where('id', 83124)->first();
        // $user->update(['password' => Hash::make('Super_admin@54321')]);         
        // dd('done');
        // $user=  ecom_admin_user::where('employee_id', '00000000041319')->first();
        // $user->update(['password' => Hash::make('waqar123')]);         
        // dd('done');

            // dd(ecom_admin_user::first());
         $server_type = config('app.APP_SERVER_TYPE');

        if($server_type != "BACKEND")
        {   
            if (auth()->check()) 
            {
             
                return redirect('dashboard');
            }
            else
            {
                return view('Admin.Auth.login');
            }
        }else{
            return view('Admin.Auth.api_page');
        }
    }
  
//    public function forgotPassword()
    //    {
    //        if (isset($_POST["submit-btn"])) {
    //
    //            $email = $_POST["email"];
    //            $queryBuilder = $this->AdminUser;
    //            $queryData = $queryBuilder->select('ecom_admin_user.id')->where('ecom_admin_user.email', $email)->get()->getResultArray();
    //            if (isset($queryData) && count($queryData) > 0) {
    //                return redirect()->to('login');
    //
    //            } else {
    //
    //                return redirect()->to('forgot_password');
    //            }
    //        }
    //        return view('Admin/auth/forgot_password');
//    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/'); // If it's a web application
    }

    public function ForgotPasswordView()
    {
        return view('Admin/Auth/forgot_password');
    }

    public function forgotPasswordSubmit(Request $request)
    {
//        $newPassword =
        $details = [
            'title' => 'Leopards Courier - Forgot Password',
            'head' => 'Dear user',
            'text' => 'Your password has been reset successfully, Your new password mention below',
            'text1' => 'New password: 123456'
        ];

        $adminUser = ecom_admin_user::where('email', $request->email)->first();

        if($adminUser == null){
            $response = [
                'status' => 2,
                'message' => 'Email Not Exists',
            ];
            return response()->json($response, 200);
        }

        ecom_admin_user::where('email', $request->email)->update(['password'=>bcrypt(123456)]);
        Mail::to($request->email)->send(new ForgotPassword($details));

        $response = [
            'status' => 1,
            'message' => 'Your password has been reset successfully. Please check your email',
        ];

        return response()->json($response, 200);
    }
}
