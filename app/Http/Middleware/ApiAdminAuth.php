<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ResponseController;
use App\Models\Admin\ecom_admin_user;
use Closure;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Auth;

class ApiAdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */


    protected $response;
    public function __construct()
    {
        $this->response = new ResponseController();
    }
    public function handle(Request $request, Closure $next)
    {
//        $error[] = 'Server Under Maintenance';
//        $output = array(
//            'status' => 0,
//            'error' => implode(',', $error)
//        );
//        return $this->response->response($output, 200);

        $headers = $this->parseRequestHeaders();
        $header_key = null;

        if(isset($headers['api_key'])){
            $api_key_header = $headers['api_key'];
        }
        if(isset($headers['api_secret_key'])){
            $api_secret_key_header = $headers['api_secret_key'];
        }

        $flag = true;
        $error = array();
        if(isset($request->api_key) || isset($request->api_key_secure) || !empty($api_key_header)) {
            if(isset($request->api_password) || isset($request->api_key_password_secure) || !empty($api_secret_key_header)) {

                $api_key = isset($request->api_key) ? $request->api_key : (isset($request->api_key_secure) ? base64_decode($request->api_key_secure) : $api_key_header);
                $api_password = isset($request->api_password) ? $request->api_password : (isset($request->api_key_password_secure) ? base64_decode($request->api_key_password_secure) : $api_secret_key_header);
                $ecom_admin_user = ecom_admin_user::where('api_key', $api_key);
                if ($ecom_admin_user->exists()) {
                    $ecom_admin = $ecom_admin_user->first();
                    if (Hash::check($api_password, $ecom_admin->api_password) || ($api_password == $ecom_admin->api_password)) {
                        Auth::login($ecom_admin, true);
                    } else {
                        $flag = false;
                        $error[] = 'Invalid API Password';
                    }
                } else {
                    $flag = false;
                    $error[] = 'Invalid API Key';
                }

            }else{
                $flag = false;
                $error[] = 'API Password is required';
            }
        }else{
            $flag = false;
            $error[] = 'API Key is required';
        }

        if($flag){
            return $next($request);
        }else {
            $output = array(
                'status' => 0,
                'error' => implode(',', $error)
            );
            return $this->response->response($output, 200);
        }

    }

    private function parseRequestHeaders() {

        $headers = array();

        foreach (getallheaders() as $key => $value) {

            $header = str_replace('-', '_', strtolower($key));

            $headers[$header] = $value;
        }

        return $headers;
    }



}
