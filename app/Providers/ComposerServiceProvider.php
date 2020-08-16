<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
         //$categories  = \App\Category::all(['name','slug']);
        //view()->share('categories', $categories);

              // 2 ideia 

       // view()->composer('*',function($view) use($categories) {
        
       //     $view->with('categories',$categories);
       // });

          // 3 ideia 
        view()->composer('layouts.front', 'App\Http\Views\CategoryViewComposer@compose'); 
    }
}
