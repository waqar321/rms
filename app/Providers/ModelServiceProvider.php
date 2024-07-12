<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ModelServiceProvider
 *
 * @author Ghulam Mustafa <ghulam.mustafa@vservices.com>
 * @date   29/11/18
 */
class ModelServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    /**
     * Bind the interface to an implementation model class
     */
    public function register()
    {
        $this->app->bind('App\Models\Interfaces\CategoryInterface', 'App\Models\Admin\ecom_category');
    }
}
