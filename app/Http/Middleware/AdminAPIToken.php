<?php

namespace App\Http\Middleware;
use App\Models\Admin\ecom_admin_user;
use Closure;

class AdminAPIToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $api_token = $request->header('Authorization');
        if ($api_token) {
            $ecom_admin_user = ecom_admin_user::where(function ($query) use($api_token){
                $query->where('customer_service_call_token',$api_token);
            });
            if ($ecom_admin_user->exists()) {
                $ecom_user_type = "";
                switch ($ecom_admin_user->first()->user_type_id) {
                    case 1:
                        $ecom_user_type =  "super_admin";
                        break;
                    case 2:
                        $ecom_user_type =  "merchant";
                        break;
                    case 3:
                        $ecom_user_type =  "admin";
                        break;
                    default:
                        $ecom_user_type =  "admin";
                }

                if ($request->isMethod('post')) {
                    $request->request->add(['admin_user_id' => $ecom_admin_user->first()->id]);
                    $request->request->add(['user_type_id' => $ecom_admin_user->first()->user_type_id]);
                    $request->request->add(['user_type' => $ecom_user_type]);
                }else{
                    $request->merge(['admin_user_id' => $ecom_admin_user->first()->id]);
                    $request->merge(['user_type_id' => $ecom_admin_user->first()->user_type_id]);
                    $request->merge(['user_type' => $ecom_user_type]);
                }

                return $next($request);
            }
            else {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
        }
        else {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }
}
