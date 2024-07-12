<?php

namespace App\Providers;

use App\Repositories\Interfaces\PropertyRepositoryInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 *
 * @author Ghulam Mustafa <ghulam.mustafa@vservices.com>
 * @date   29/11/18
 */
class RepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    /**
     * Bind the interface to an implementation repository class
     */
    public function register()
    {

        $this->app->bind('App\Repositories\Interfaces\CategoryRepositoryInterface', 'App\Repositories\CategoryRepository');
        
        // =============to test in controller ===================
        // $category = app(CategoryRepositoryInterface::class);
        // if ($category instanceof \App\Models\Admin\ecom_category) 
        // {
            //          print message
        // }
        // else
        // {
        //          print message
        // }


    }
}
