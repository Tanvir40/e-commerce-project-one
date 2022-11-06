<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Models\Product;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Size;
use App\Models\Color;
use App\Models\ImageCarosel;
use App\Models\Orderproduct;
use App\Models\Subcategory;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use Cookie;
use Arr;
use function Ramsey\Uuid\v1;


class FrontendController extends Controller
{
   function index(){
       $products = Product::latest()->take(6)->get();
       $new_arival = Product::latest()->take(4)->get();
       $categories = Category::all();
       $brands = Brands::all();
       $carousel_image = ImageCarosel::get();

       $recent_get =  json_decode(Cookie::get('recent_view'), true);
       if($recent_get == null){
            $recent_get = [];
            $after_unique = array_unique($recent_get);
       }

       else{
        $after_unique = array_unique($recent_get);
       }


       $recent_product = Product::find($after_unique);

       if(!$recent_product){
           $recent_product = "[].";
       }


            $best_selling = Orderproduct::groupBy('product_id')
            ->selectRaw('sum(quantity) as sum, product_id')
            ->orderBy('quantity' , 'DESC')
            ->havingRaw('sum >=5')
            ->get();

    return view('frontend.index', [
        'products'=> $products,
        'new_arival'=> $new_arival,
        'categories'=> $categories,
        'recent_product'=>$recent_product,
        'best_selling'=>$best_selling,
        'brands'=>$brands,
        'carousel_image'=>$carousel_image,
    ]);
   }


//about us page
    function about_us(){
        return view('frontend.about_us');
    }

//contact us page
    function contact_us(){
        return view('frontend.contact_us');
    }

//privacy policy page
    function privacy_policy(){
        return view('frontend.privacy_policy');
    }

//product_by_category
    function product_by_category($id){
        $brands = Brands::all();
        $categorys = Category::all();
        $subcategorys = Subcategory::all();
        $colors = Color::all();
        $sizes = Size::all();
        $products = Product::where('category_id', $id)->paginate(6);
        return view('frontend.shop', [
            'brands'=> $brands,
            'categorys'=> $categorys,
            'subcategorys'=> $subcategorys,
            'colors'=> $colors,
            'sizes'=> $sizes,
            'products'=> $products,
        ]);
    }
//shop
    function shop(Request $request){
        $data = $request->all();

        $field = 'created_at';
        $order_by = 'DESC';

        if(!empty($data['sort']) && $data['sort'] != '' && $data['sort'] != 'undefined'){
            if($data['sort'] == 1){
                $field = 'product_name';
                $order_by = 'ASC';
            }
            else if($data['sort'] == 2){
                $field = 'product_name';
                $order_by = 'DESC';
            }
            else if($data['sort'] == 3){
                $field = 'after_discount';
                $order_by = 'DESC';
            }
            else if($data['sort'] == 4){
                $field = 'after_discount';
                $order_by = 'ASC';
            }
            else{
                $field = 'created_at';
                $order_by = 'DESC';
            }
        }

        $brands = Brands::all();
        $categorys = Category::all();
        $subcategorys = Subcategory::all();
        $colors = Color::all();
        $sizes = Size::all();
        $products = Product::where(function ($q) use ($data){
            if(!empty($data['q']) && $data['q'] != '' && $data['q'] != 'undefined'){
                $q->where(function ($q) use ($data){
                    $q->where('product_name', 'like', '%'.$data['q'].'%');
                    $q->orWhere('short_desp', 'like', '%'.$data['q'].'%');
                });
            }
            if(!empty($data['brand_name']) && $data['brand_name'] != '' && $data['brand_name'] != 'undefined'){
                $q->where('brand_name', $data['brand_name']);
            }
            if(!empty($data['category_id']) && $data['category_id'] != '' && $data['category_id'] != 'undefined'){
                $q->where('category_id', $data['category_id']);
            }
            if(!empty($data['subcategory_id']) && $data['subcategory_id'] != '' && $data['subcategory_id'] != 'undefined'){
                $q->where('subcategory_id', $data['subcategory_id']);
            }
            if(!empty($data['price_range']) && $data['price_range'] != '' && $data['price_range'] != 'undefined'){
                $price_range = explode('-', $data['price_range']);
                $q->whereBetween('after_discount', [$price_range[0],$price_range[1]]);
            }
            if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined' || !empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
                $q->whereHas('inventories', function ($q) use ($data){
                    if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined'){
                        $q->whereHas('rel_to_color', function ($q) use ($data){
                            $q->where('colors.id', $data['color_id']);
                        });
                    }
                    if(!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
                        $q->whereHas('rel_to_size', function ($q) use ($data){
                            $q->where('sizes.id', $data['size_id']);
                        });
                    }
                });
            }
        })->orderBy($field , $order_by)->paginate(6);
        return view('frontend.shop', [
            'brands'=> $brands,
            'categorys'=> $categorys,
            'subcategorys'=> $subcategorys,
            'colors'=> $colors,
            'sizes'=> $sizes,
            'products'=> $products,
        ]);
    }

//product details
   function product_details($product_id){
       $product_info = Product::find($product_id);
       $related_product = Product::where('id', '!=', $product_id)->where('category_id', $product_info->category_id)->where('subcategory_id', $product_info->subcategory_id)->where('childcategory_id', $product_info->childcategory_id)->latest()->take(4)->get();
       $available_color = Inventory::where('product_id', $product_id)->groupBy('color_id')->selectRaw('count(*) as total, color_id')->get();
       $reviews = Orderproduct::where('product_id', $product_id)->whereNotNull('review')->get();
       $review_count = Orderproduct::where('product_id', $product_id)->whereNotNull('review')->count();
       $sum_star = Orderproduct::where('product_id', $product_id)->whereNotNull('review')->sum('star');
       $out_stock_quantity = Inventory::where('product_id', $product_id)->sum('quantity');

       $cookie = Cookie::get('recent_view');

       if(!$cookie){
            $cookie = "[]";
       }

       $all_info = json_decode($cookie, true);
       $all_info = Arr::prepend($all_info, $product_id);
       $recent_id = json_encode($all_info);

       Cookie::queue('recent_view', $recent_id, 1000);


       return view('frontend.product_details',[
           'product_info'=>$product_info,
           'available_color'=>$available_color,
           'related_product'=>$related_product,
           'reviews'=>$reviews,
           'review_count'=>$review_count,
           'sum_star'=>$sum_star,
           'out_stock_quantity'=>$out_stock_quantity,
       ]);
   }

   //review insert
   function review(Request $request){
    $request->validate([
        'review'=>'required',
        'star'=>'required',
    ],[
        'review.required'=>'Please Write a Comment!',
        'star.required'=>'Please select a Star!',
    ]);
    Orderproduct::where('user_id' , Auth::guard('customerlogin')->id())->where('product_id' , $request->id)->update([
        'review'=>$request->review,
        'star'=>$request->star,
        'updated_at'=>Carbon::now(),
    ]);
    return back();
   }


   //ajax get size product details
   function getSize(Request $request){
       $str = '<option class="colr_id" value="" data-col="'.$request->color_id.'">Choose a Size</option>';
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        foreach($sizes as $size){
            $str .= '<option id="'.$request->color_id.'" class="'.$request->product_id.'" value="'.$size->size_id.'">'.$size->rel_to_size->size.'</option>';
        }
        echo $str;
   }

   //ajax get size new arrival
   function getSizes(Request $request){
       $str = '<option value="">Choose a Size</option>';
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        foreach($sizes as $size){
            $str .= '<option id="'.$request->color_id.'" class="'.$request->product_id.'" value="'.$size->size_id.'">'.$size->rel_to_size->size.'</option>';
        }
        echo $str;
   }

    //ajax get size color for add cart in product details
    function stock(Request $request){
        if(Inventory::where('product_id' , $request->product_id)->where('color_id' , $request->color_id)->where('size_id' , $request->size_id)->first()->quantity == 0){
            echo '<button class="btn btn-warning" type="button"> Out Of Stock </button>';
        }else{
            echo '<button class="btn btn-primary addtocart_btn" type="submit">Add To Cart</button>';
        }
   }

   //     //ajax get size color for add cart in index page letest product
    function stocks(Request $request){
        if(Inventory::where('product_id' , $request->product_id)->where('color_id' , $request->color_id)->where('size_id' , $request->size_id)->first()->quantity == 0){
            echo '<button class="btn btn-warning" type="button"> Out Of Stock </button>';
        }else{
            echo '<button class="btn btn-primary addtocart_btn" type="submit">Add To Cart</button>';
        }
   }

   //add banner images
   function add_banner_photos(){
    $carousel_image = ImageCarosel::get();
    return view('admin.add_banner',[
        'carousel_image'=>$carousel_image,
    ]);
   }

   //add banner images insert
   function image_Carosuel_insert(Request $request){
    $request->validate([
        'small_text'=>'required',
        'thin_large_text'=>'required',
        'thik_large_text'=>'required',
        'small_title'=>'required',
        'price'=>'required',
        'discount_price'=>'required',
        'product_url'=>'required',
        'carousel_image'=>'required',
    ]);

        $carousel_image = ImageCarosel::insertGetId([
        'small_text'=>$request->small_text,
        'thin_large_text'=>$request->thin_large_text,
        'thik_large_text'=>$request->thik_large_text,
        'small_title'=>$request->small_text,
        'price'=>$request->price,
        'discount_price'=>$request->discount_price,
        'product_url'=>$request->product_url,
        'created_at'=>Carbon::now(),
    ]);
        $uploaded_file = $request->carousel_image;
        $extension = $uploaded_file->getClientOriginalExtension();

        $file_name = $request->small_text.'.'.$extension;

        Image::make($uploaded_file)->resize(850,550)->save(public_path('/front/images/slider/'.$file_name));

        ImageCarosel::find($carousel_image)->update([
            'carousel_image'=>$file_name,
        ]);
        return back()->with('carousel_image' , 'Carousel Image Added Successfully');
   }

   function banner_delete($carousel_id){

        $carousel_images = ImageCarosel::find($carousel_id);
        $carousel_images->carousel_image;
        $delete_from = public_path('/front/images/slider/'.$carousel_images->carousel_image);
        unlink($delete_from);


        ImageCarosel::find($carousel_id)->delete();
        return back()->with('delete', 'Carousel Image Deleted Successfully!');
   }

    //active carousel_image
    function carousel_active($carousel_id){
        ImageCarosel::find($carousel_id)->update([
        'status'=>1,
        ]);
    return back()->with('active', 'Carousel Image Activated Successfully!');
}

//De-active carousel_image
function carousel_deactive($carousel_id){
    ImageCarosel::find($carousel_id)->update([
        'status'=>2,
        ]);
    return back()->with('deactive', '
    Carousel Image De-activated Successfully!');
}

}
