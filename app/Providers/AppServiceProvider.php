<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Menu;
use App\ProductCategories;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('header/header', function ($view) {
            $menus = Menu::where('parent_id', '=', '0')->orderBy('menu_sort', 'asc')->get();
            $view->with('menus', $menus);
        });

        
        view()->composer('pages/product/product', function ($view) {
            $product_max_price = DB::select("SELECT  MAX(price) as max_price FROM `products`");
            $product_min_price = DB::select("SELECT  MIN(price) as min_price FROM `products`");
    
            $price_max = 0; 
            foreach ($product_max_price as $item){
                $price_max = $item->max_price;
            }
    
            $price_min = 0; 
            foreach ($product_min_price as $item){
                $price_min =   $item->min_price;
            }
    
            $product_price = [$price_min, $price_max];
            $categories = ProductCategories::all();
            $view->with('categories', $categories);
            $view->with('product_price',$product_price );
        });
    }
}
