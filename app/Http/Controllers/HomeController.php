<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\CategoryPost;
use App\OrderDetail;
use App\ProductCategories;
use App\Post;
use App\Slider;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   

    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $list_sliders= Slider::groupBy('id')->get();
        $products = Product::where('status', '=', '1')->take(5)->get();
        $category_product = ProductCategories::with('product')->take(3)->get();
        $post_category = CategoryPost::take(3)->get();
        $post = Post::take(3)->where('status', 'approve')->get();
        // $laptop_category = ProductCategories::find(17)->product->take(5);
        // $tablet_category = ProductCategories::find(16)->product->take(5);
        $product_seller = DB::select("SELECT  *, SUM(qty) AS quantity FROM `order_details` inner JOIN products on order_details.product_id = products.id  GROUP by product_id ORDER BY quantity DESC");
        return view ('pages.homepage.home', compact('list_sliders', 'products', 'category_product', 'post',  'product_seller'));
    }

    function search(Request $request){
        $key_word = $request->input('s');
        if(empty($key_word)){
           
            return redirect('/');
        }else{
            $products = Product::where('title', '=', $key_word)->where('status', '=', '1')->paginate(8);
            return view ('pages.search.list', compact('products'));
        }
       
    }

    
}
