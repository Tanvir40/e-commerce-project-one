<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\Inventory;
use App\Models\Thumbnails;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class ProductController extends Controller
{
    //product add
    function add_product(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $childcategories = Childcategory::all();
        $brands = Brands::all();
        return view('admin.products.add_product' ,[
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'childcategories'=>$childcategories,
            'brands'=>$brands,
        ]);
    }

    //ajax get subcategory
    function getSubcategory(Request $request){
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        $str =  '<option value="">-- select Subcategory --</option>';
        foreach($subcategories as $subcategory){
            $str .= '<option value="'.$subcategory->id.'">'.$subcategory->subcategory_name.'</option>';
        }
        echo $str;
    }

    //get child category
    function getChildcategory(Request $request){
        $childcategories = Childcategory::where('subcategory_id', $request->subcategory_id)->get();
        $str =  '<option value="">-- select Childcategory --</option>';
        foreach($childcategories as $childcategory){
            $str .= '<option value="'.$childcategory->id.'">'.$childcategory->childcategory_name.'</option>';
        }
        echo $str;
    }
    //product insert
    function product_insert(Request $request){

        $request->validate([
            'category_id'=>'required',
            'product_name'=>'required',
            'product_price'=>'required',
            'short_desp'=>'required',
            'brand_name'=>'required',
            'long_desp'=>'required',
            'addi_info'=>'required',
            'preview'=>'required | image | max:4096 | mimes:jpeg,png,jpg',
            'thumbnail'=>'required',
        ]);

       $product_id = Product::insertGetId([
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'childcategory_id'=>$request->childcategory_id,
            'product_name'=>$request->product_name,
            'product_price'=>$request->product_price,
            'discount'=>$request->discount,
            'after_discount'=>$request->product_price - ($request->product_price*$request->discount)/100,
            'short_desp'=>$request->short_desp,
            'brand_name'=>$request->brand_name,
            'long_desp'=>$request->long_desp,
            'addi_info'=>$request->addi_info,
            'created_at'=>Carbon::now(),
       ]);
    //    $uploaded_file = $request->preview;
    //    $extension = $uploaded_file->getClientOriginalExtension();
    //    $file_name = $product_id.'.'.$extension;

    //    Image::make($uploaded_file)->resize(600,600)->save(public_path('/uploads/products/preview/'.$file_name));

    //    Product::find($product_id)->update([
    //     'preview'=>$file_name,
    //    ]);

        // $loop = 1;
        // $thumanails_images = $request->thumbnail;
        // foreach($thumanails_images as $thumb){
        //     $thumbnail_extension = $thumb->getClientOriginalExtension();
        //     $thumb_file_name = $product_id.'-'.$loop.'.'.$thumbnail_extension;
        //     Image::make($thumb)->resize(600,600)->save(public_path('/uploads/products/thumbnails/'.$thumb_file_name));

            Thumbnails::insert([
                'product_id'=>$product_id,
                'thumbnail'=>$request->preview,
                'created_at'=>carbon::now(),
            ]);
        //     $loop++;
        // }
        // Inventory::insert([
        //     'product_id'=>$product_id,
        //     'color_id'=>1,
        //     'size_id'=>2,
        //     'quantity'=>1,
        //     'created_at'=>Carbon::now(),
        // ]);

       return back()->with('success', 'Product Added Successfully!');
    }

    //product list
    function product_list(){
        $all_products = Product::all();
        return view('admin.products.product_list' ,[
            'all_products'=> $all_products,
        ]);
    }
//product delete
    function delete($product_id){
        // product image delete
            $product_image = Product::find($product_id);
            $product_image->preview;
            $delete_from = public_path('/uploads/products/preview/'.$product_image->preview);
            unlink($delete_from);

        // product thumbnail image delete

             $prev_img = Thumbnails::where('product_id' , $product_id)->get();
             foreach($prev_img as $thumb){
                 $delete_from = public_path('/uploads/products/thumbnails/'.$thumb->thumbnail);
                 unlink($delete_from);
             }
             Thumbnails::where('product_id' , $product_id)->delete();
        //product delete
        Product::find($product_id)->delete();

        Inventory::where('product_id', $product_id)->delete();
        if(Cart::where('product_id', $product_id)){
            Cart::where('product_id', $product_id)->delete();
        }
        if(Wishlist::where('product_id', $product_id)){
            Wishlist::where('product_id', $product_id)->delete();
        }

        return back();
    }

    //product edit
    function edit_product($product_id){
        $all_thumbnails = Thumbnails::where('product_id' , $product_id)->get();
        $categories = Category::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $childcategories = Childcategory::all();
        $product = Product::find($product_id);
        $brands = Brands::all();
        return view('admin.products.edit_product' , [
            'all_thumbnails'=>$all_thumbnails,
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'childcategories'=>$childcategories,
            'product'=>$product,
            'brands'=>$brands,
        ]);
    }

    //product update
    function product_update(Request $request){
        $request->validate([
            'category_id'=>'required',
            'product_name'=>'required',
            'product_price'=>'required',
            'short_desp'=>'required',
            'long_desp'=>'required',
            'addi_info'=>'required',
            'preview'=>'image | max:4096 | mimes:jpeg,png,jpg',

        ]);
        Product::find($request->id)->update([
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'childcategory_id'=>$request->childcategory_id,
            'product_name'=>$request->product_name,
            'product_price'=>$request->product_price,
            'discount'=>$request->discount,
            'after_discount'=>$request->product_price - ($request->product_price*$request->discount)/100,
            'brand_name'=>$request->brand_name,
            'short_desp'=>$request->short_desp,
            'long_desp'=>$request->long_desp,
            'addi_info'=>$request->addi_info,
            'updated_at'=>Carbon::now(),
           ]);

           $preview_images = $request->preview;
            if($preview_images != ''){
                 $preview_images = Product::find($request->id);
                 $delete_from = public_path('/uploads/products/preview/'.$preview_images->preview);
                unlink($delete_from);


             $uploaded_file = $request->preview;
            $extension = $uploaded_file->getClientOriginalExtension();
             $file_name = $request->id.'.'.$extension;

                Image::make($uploaded_file)->resize(600,600)->save(public_path('/uploads/products/preview/'.$file_name));

                Product::find($request->id)->update([
                    'preview'=>$file_name,
                   ]);
                }
           $thumanails_images = $request->thumbnail;
           if($thumanails_images != ''){

                $prev_img = Thumbnails::where('product_id' , $request->id)->get();

                foreach($prev_img as $thumb){
                    $delete_from = public_path('/uploads/products/thumbnails/'.$thumb->thumbnail);
                    unlink($delete_from);
                }
                Thumbnails::where('product_id' , $request->id)->delete();
                $loop = 1;
                foreach($thumanails_images as $thumb){
                $thumbnail_extension = $thumb->getClientOriginalExtension();
                $thumb_file_name = $request->id.'-'.$loop.'.'.$thumbnail_extension;
            Image::make($thumb)->resize(600,600)->save(public_path('/uploads/products/thumbnails/'.$thumb_file_name));

            Thumbnails::insert([
                'product_id'=>$request->id,
                'thumbnail'=>$thumb_file_name,
                'created_at'=>carbon::now(),
            ]);
            $loop++;
            }
        }
           return back();
    }

}
