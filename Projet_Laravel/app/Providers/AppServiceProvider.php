<?php

// namespace App\Providers;

// use Illuminate\Support\ServiceProvider;

// class AppServiceProvider extends ServiceProvider
// {
//     /**
//      * Register any application services.
//      *
//      * @return void
//      */
//     public function register()
//     {
//         //
//     }

//     /**
//      * Bootstrap any application services.
//      *
//      * @return void
//      */
//     public function boot()
//     {
//         //

//     }





namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as View;
use Illuminate\Support\Facades\View as ViewFacade;


use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    // /
    //  * Register any application services.
    //  *
    //  * @return void
    //  */
    public function register()
    {
        //
    }

    public function boot()
    {
        ViewFacade::composer('layout.default', function(View $view) {
            if (auth()->check()) {
                $item_count = DB::table('shop_baskets')
                ->where('user_id', auth()->user()->id)
                ->where('order',auth()->user()->curent_order)
                ->sum('quantity');

            } else {
                $item_count = 0;
            }
            $view->with('item_count',$item_count);
        });

        ViewFacade::composer('shop_basket', function(View $view) {
            $items = DB::table('shopBaskets')->where('user_id', auth()->user()->id)->get('product_id');
            // dd($items);
            $totalE = 0;
            foreach ($items as $item){
                $totalE += DB::table('products')->where('id', $item->product_id)->first('price')->price;
            }
            //  dd($total);
            $view->with('totalE',$totalE);

        });
    }
}


