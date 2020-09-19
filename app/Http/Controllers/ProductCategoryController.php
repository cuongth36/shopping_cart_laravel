<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCategories;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductCategoryController extends Controller
{
    function __construct()
    {
        
    }

    function show(Request $request){
       $order_by = '';
        if($request->input('order_by')){
            $name = $request->input('order_by');
            switch ($name) {
                case 'asc':
                    $order_by = 'order by title asc';
                   
                    break;
                case 'desc':
                    $order_by = 'order by title desc';
                    break;
                case 'price_asc': 
                    $order_by = 'order by price asc';
                    break;
                case 'price_desc':
                    $order_by = 'order by price desc';
                    break;
            }
        }
           
        $where = "status = '1' $order_by";
        $products = DB::select("SELECT * FROM products where $where limit 8");
        return view('pages.product.product', compact('products'));
    }

    function productFillter(Request $request){
        $min = $request->input('min');
        $max = $request->input('max');
        $page = $request->input('page') ? (int) $request->input('page') : 1;
        $list_product = Product::all()->count();
        $limit = 8;
        $total_page = ceil($list_product/$limit);
        $offset = ($page - 1) * $limit;
        $products = DB::select("SELECT * FROM products WHERE  products.status= '1' and price BETWEEN $min AND $max group by products.id limit $limit offset $offset");
        ?>
            <div class="container">
            <div class="row ">
                <?php 
                    if(!empty($products)){
                        foreach($products as $item)
                        {
                        ?>
                         <div class="col-xl-3 col-md-6 col-lg-4 col-sm-12 col-12 layout ">
                                <div class="box-item box-item-list-shoppage">
                                    <div class="box-item-image">
                                        <a href="<?php echo route('product.detail', [$item->slug, '.html']) ?>"><img src="<?php echo url($item->thumbnail) ?>" alt="<?php echo $item->title ?>"></a>
                                    </div>
                                    <div class="box-item-info">
                                        <a href="<?php echo route('product.detail', [$item->slug, '.html']) ?>"><h3 class="item-name m-bottom-0"><?php echo $item->title ?></h3></a>
                                        <div class="item-price-rate">
                                        <div class="item-price">
                                            <?php 
                                                if(!empty($item->discount)){
                                                    ?>
                                                           
                                                        <span class="cost"><?php echo number_format($item->price, 0, '', '.')?>đ</span>    
                                                             
                                                        <span class="sale"> <?php echo number_format((1-(5/100))*$item->price, 0, '', '.')?>đ</span>
                                                               
                                                    <?php
                                                    
                                                }else{
                                                   ?>
                                                   <span class="price"><?php echo number_format($item->price, 0, '', '.')?>đ</span>
                                                <?php
                                                }
                                            ?>
                                        </div>
                                        </div>
                                                                                                                        
                                    </div>
                                    <div class="offer">
                                        <?php
                                            if(!empty($item->product_discount)){
                                                ?>
                                                <div class='percent'><?php echo $item->product_discount ?>'%'</div>
                                            <?php
                                                                                        }
                                        ?>
                                    </div>
                                </div>
                          </div> 
                    <?php
                    }
                }
                ?>
               
            </div>
            </div>
           
        <?php
    }

    function loadMore(Request $request){
        $page = $request->input('page') ? (int) $request->input('page') : 1;
        $list_product = Product::all()->count();
        $limit = 8;
        $total_page = ceil($list_product/$limit);
        $offset = ($page - 1) * $limit;
        $products = DB::select("SELECT * FROM products where products.status = '1' limit $limit offset $offset");
        return view('pages.product.data-product-list', compact('products'));

    }

    function loadMoreProductOfCate(Request $request, $slug){
        $slug = str_replace_last('.html', '', $slug);
        $db_select = DB::select("SELECT product_categories.* FROM product_categories where product_categories.slug = '$slug' ");
        $slug_new = '';
        foreach ($db_select as $item){
           $slug_new = $item->slug;
        } 
        if(count($db_select) >0){
            $products_cate = ProductCategories::where('slug', '=' , $slug_new)->get();
            $id = 0;
            foreach($products_cate as $cate){
                $id = $cate->id;
            }
            $page = $request->input('page') ? (int) $request->input('page') : 1;
            $list_product =ProductCategories::find($id)->product;
            $limit = 8;
            $total_page = ceil(count( $list_product)/$limit);
            $offset = ($page - 1) * $limit;
            $list_category = DB::select("SELECT * FROM product_categories inner join products on product_categories.id = products.category_id where product_categories.id = $id and products.status = '1' group by products.id limit $limit offset $offset");
            return view('pages.product.data-product-list', compact('list_category'));
        }
    }

    function productOfCategory(Request $request, $slug){
        $slug = str_replace_last('.html', '', $slug);
        $db_select = DB::select("SELECT product_categories.* FROM product_categories where product_categories.slug = '$slug' ");
        $slug_new = '';
        foreach ($db_select as $item){
           $slug_new = $item->slug;
        }

        if(count($db_select) >0){
            $products_cate = ProductCategories::where('slug', '=' , $slug_new)->get();
            $id = 0;
            foreach($products_cate as $cate){
                $id = $cate->id;
            }
            $order_by = '';
            if($request->input('order_by')){
                $name = $request->input('order_by');
                switch ($name) {
                    case 'asc':
                        $order_by = 'order by products.title asc';
                    
                        break;
                    case 'desc':
                        $order_by = 'order by products.title desc';
                        break;
                    case 'price_asc': 
                        $order_by = 'order by products.price asc';
                        break;
                    case 'price_desc':
                        $order_by = 'order by products.price desc';
                        break;
                }
            }
            $where = "product_categories.id = $id AND products.status = '1' group by products.id  $order_by";
            $list_category = DB::select("SELECT * FROM product_categories inner join products on product_categories.id = products.category_id where $where  limit 10");
            return view('pages.product.product', compact('list_category'));
        }else{
            return view('errors.404');
        }

    }


}
