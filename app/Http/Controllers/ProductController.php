<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    function detail(Request $request, $slug){
        $slug = str_replace_last('.html', '', $slug);
        $db_select = DB::select("SELECT products.* FROM products where products.slug = '$slug' ");
        $slug_new = '';
        foreach ($db_select as $item){
           $slug_new = $item->slug;
        }

        if(count($db_select) > 0){
            $products_info = Product::where('slug', '=' , $slug_new)->get();
            $id = 0;
            foreach($products_info as $product){
                $id = $product->id;
            }
            $products = Product::find($id);
            // $product_color = DB::select("SELECT cl.id,cl.color_code, prd_attr.product_id, prd_attr.color_id, prd_attr.size_id, prd_attr.amount FROM  colors as cl INNER JOIN product_attribute as prd_attr on cl.id = prd_attr.color_id where prd_attr.product_id = $id  group by prd_attr.color_id");
            $product_color = DB::select("SELECT cl.id,cl.color_code, prd_attr.product_id, prd_attr.color_id, prd_attr.size_id, prd_attr.amount, prd.slug as product_slug FROM product_attribute as prd_attr INNER JOIN colors as cl on prd_attr.color_id = cl.id 
            INNER JOIN products as prd on prd_attr.product_id = prd.id where prd_attr.product_id = $id  group by prd_attr.color_id");
            $product_color_id = [];
            if(!empty($product_color)){
                foreach($product_color as $item){
                  $product_color_id[] = $item->id;
                }
            }
            $product_color_id = implode(',', $product_color_id);
            // dd($product_color_id);
            // $product_size = DB::select("SELECT product_attribute.* , sizes.name as size_name , colors.title as color_name , group_concat(sizes.name) as size_attr from product_attribute INNER JOIN colors on product_attribute.color_id = colors.id INNER JOIN sizes on product_attribute.size_id = sizes.id WHERE product_attribute.color_id in ($product_color_id)  and product_attribute.product_id = $id GROUP BY product_attribute.color_id");
            // $product_size = DB::select("SELECT sz.name, sz.id, prd_attr.product_id, prd_attr.size_id,prd_attr.color_id FROM  sizes as sz INNER JOIN product_attribute as prd_attr on sz.id = prd_attr.size_id where prd_attr.product_id = $id and prd_attr.color_id in ($product_color_id) group by prd_attr.size_id");
            $product_size = DB::select("SELECT sizes.id,sizes.name, colors.id as color_id FROM `product_attribute` RIGHT JOIN colors on product_attribute.color_id = colors.id INNER JOIN sizes ON product_attribute.size_id = sizes.id INNER JOIN products ON product_attribute.product_id = products.id WHERE product_attribute.product_id = $id GROUP BY sizes.id order by sizes.name asc");
            $product_release = Product::where('id', '!=' , $id)->where('status', '=', '1')->take(5)->get();
            $feature_image = [];
            $list_image = $products->feature_image;
            foreach( $list_image as $item){
                $data = explode(',', $item->feature_image);
                $feature_image[] = $data;
            }
            return view('pages.product.product_detail', compact('products','product_release','product_size', 'product_color', 'feature_image'));
           
        }else{
            return view('errors.404');
        }

    }

    function getColorId(Request $request, $slug){
        $color_id = (int) $request->input('colorItem');
        $slug = $request->input('slug');
        $db_select = DB::select("SELECT products.* FROM products where products.slug = '$slug' ");
        $slug_new = '';
        foreach ($db_select as $item){
           $slug_new = $item->slug;
        }
        if(count($db_select) > 0){
            $products_info = Product::where('slug', '=' , $slug_new)->get();
            $id = 0;
            foreach($products_info as $product){
                $id = $product->id;
            }
            $product_color = DB::select("SELECT cl.id,cl.color_code, prd_attr.product_id, prd_attr.color_id, prd_attr.size_id, prd_attr.amount, prd.slug as product_slug FROM product_attribute as prd_attr INNER JOIN colors as cl on prd_attr.color_id = cl.id 
            INNER JOIN products as prd on prd_attr.product_id = prd.id where prd_attr.product_id = $id  group by prd_attr.color_id");
            $product_size = DB::select("SELECT sizes.id,sizes.name, colors.id as color_id FROM `product_attribute` RIGHT JOIN colors on product_attribute.color_id = colors.id INNER JOIN sizes ON product_attribute.size_id = sizes.id INNER JOIN products ON product_attribute.product_id = products.id WHERE product_attribute.product_id = $id and product_attribute.color_id = $color_id group by sizes.id order by sizes.name asc");
            return view('pages.product.data-size', compact('product_color', 'product_size'));
        }
    }

   
}
