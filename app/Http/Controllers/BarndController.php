<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class BarndController extends Controller
{
    function add_brand(){
        $brands = Brands::get();
        return view('admin.brand.add_brand' ,[
            'brands'=>$brands,
        ]);
    }

    function brand_insert(Request $request){
        $request->validate([
            'brand_name'=>'required|unique:brands',
        ],[
            'brand_name.required'=>'Please Enter a Brand Name!',
        ]);


        $user_id = Brands::insertGetId([
            'user_id'=>Auth::id(),
            'brand_name'=>$request->brand_name,
            'created_at'=>Carbon::now(),
        ]);
        $uploaded_file = $request->brand_image;
        $extension = $uploaded_file->getClientOriginalExtension();

        $file_name = $request->brand_name.'.'.$extension;

        Image::make($uploaded_file)->resize(400,150)->save(public_path('/uploads/brand/'.$file_name));

        Brands::find($user_id)->update([
            'brand_image'=>$file_name,
        ]);
        return back()->with('success', 'Brand Added Successfully!');
    }

    //Brand delete
    function brand_delete($brand_id){

            $brand_images = Brands::find($brand_id);
            $brand_images->brand_image;
            $delete_from = public_path('/uploads/brand/'.$brand_images->brand_image);
            unlink($delete_from);

            Brands::find($brand_id)->delete();
        return back()->with('delete', 'Brand Deleted Successfully!');
    }
}
