<?php

use chillerlan\QRCode\QRCode;


if (! function_exists('api_url')) 
{
    function api_url($path = null, $url_type = 1)
    {        
        if ($url_type == 1) 
        {
            if (is_null($path)) 
            {
                return config('app.api_url');
            } else {
                return config('app.api_url') . $path;
            }
        }
    }
}

if (! function_exists('url_secure')) 
{
    /**
     * Generate a HTTPS url for the application.
     *
     * @param  string  $path
     * @param  mixed  $parameters
     * @return string
     */
    function url_secure($path, $parameters = [])
    {
        $http_ssl = config('app.http_ssl');

        if($http_ssl == 'on') 
        {
            return url($path, $parameters, true);
        }
        else
        {
            return url($path, $parameters, false);
        }
    }
}

if (! function_exists('login_url')) 
{
    function login_url($path = null, $url_type = 1)
    {
        if ($url_type == 1) {
            if (is_null($path)) {
                return url_secure('api');
            } else {
                return url_secure('api').'/'. $path;
            }
        }
    }
}
if (! function_exists('url_secure_api')) 
{
 
    /**
     * Generate a HTTPS url for the application.
     *
     * @param  string  $path
     * @param  mixed  $parameters
     * @return string
     */
    function url_secure_api($path)
    {
        $url = request()->header('origin');
        // return   $url.'/LMS/public/'.$path;
        return   $url.'/'.$path;
    }
}

