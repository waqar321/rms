<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    
    public function register()
    {
        // UrlGenerator::macro('alternateHasCorrectSignature', function (Request $request, $absolute = true, array $ignoreQuery = []) {
        //     $ignoreQuery[] = 'signature';
    
        //     // ensure the base path is applied to absolute url
        //     $absoluteUrl = url($request->path()); // forceRootUrl and forceScheme will apply
        //     $url = $absolute ? $absoluteUrl : '/'.$request->path();
    
        //     $queryString = collect(explode('&', (string) $request->server->get('QUERY_STRING')))
        //         ->reject(fn ($parameter) => in_array(Str::before($parameter, '='), $ignoreQuery))
        //         ->join('&');
        //     $original = rtrim($url.'?'.$queryString, '?');
        //     $signature = hash_hmac('sha256', $original, call_user_func($this->keyResolver));
        //     return hash_equals($signature, (string) $request->query('signature', ''));
        // });
    
        // UrlGenerator::macro('alternateHasValidSignature', function (Request $request, $absolute = true, array $ignoreQuery = []) {
        //     return \URL::alternateHasCorrectSignature($request, $absolute, $ignoreQuery)
        //         && \URL::signatureHasNotExpired($request);
        // });
    
        // Request::macro('hasValidSignature', function ($absolute = true, array $ignoreQuery = []) {
        //     return \URL::alternateHasValidSignature($this, $absolute, $ignoreQuery);
        // });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Config::set('livewire.asset_url', 'http://lms.leopardscourier.com/LMS/public/waqar');
        //if($this->app->environment('production')) 
        //{
            URL::forceScheme('https');
        //}
        
    }
}
