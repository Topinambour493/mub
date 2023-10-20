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
                $item_count = DB::table('paniers')
                ->where('user_id', auth()->user()->id)
                ->where('commande',auth()->user()->commande_en_cours)
                ->sum('quantite');
                
            } else {
                $item_count = 0;
            }
            $view->with('item_count',$item_count);
        });

        ViewFacade::composer('panier', function(View $view) {
            $items = DB::table('paniers')->where('user_id', auth()->user()->id)->get('produit_id');
            // dd($items);
            $totalE = 0;
            foreach ($items as $item){
                $totalE += DB::table('produits')->where('id', $item->produit_id)->first('prix')->prix;
            }
            //  dd($total);
            $view->with('totalE',$totalE);

        });
    }
}


