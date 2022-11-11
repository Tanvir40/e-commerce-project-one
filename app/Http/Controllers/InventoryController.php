<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\MetaTag;
use App\Models\Size;
use Carbon\Carbon;

class InventoryController extends Controller
{
    //add color size
    function add_color_size(){
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.inventory.color_size' ,[
            'colors'=>$colors,
            'sizes'=>$sizes,
        ]);
    }

    //insert color size to database
    function insert_color(Request $request){
        $request->validate([
            'color_name'=>'required|unique:colors',
            'color_code'=>'required|unique:colors',
        ]);

          color::insert([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
            'created_at'=>carbon::now(),
        ]);
        return back()->with('success_color', 'Color Added Successfully!');
    }
    //insert size to database
    function insert_size(Request $request){
        $request->validate([
            'size'=>'required|unique:sizes',
        ]);
        Size::insert([
            'size'=>$request->size,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success_size', 'Size Added Successfully!');
    }

    function inventory($product_id){
        $product_info = Product::find($product_id);
        $colors = Color::all();
        $sizes = Size::all();
        $tags = MetaTag::where('product_id', $product_id)->get();
        $inventories = Inventory::where('product_id', $product_id)->get();
        return view('admin.inventory.inventory', [
            'product_info'=> $product_info,
            'colors'=> $colors,
            'sizes'=> $sizes,
            'inventories'=> $inventories,
            'tags'=> $tags,
        ]);
    }

    function inventory_insert(Request $request){
        $request->validate([
            'color_id'=>'required',
            'size_id'=>'required',
            'quantity'=>'required',
        ]);

        if(Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()){
            Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
            return back()->with('inventory', 'Inventory Added Successfully!');
        }else{
            Inventory::insert([
                'product_id'=>$request->product_id,
                'color_id'=>$request->color_id,
                'size_id'=>$request->size_id,
                'quantity'=>$request->quantity,
                'created_at'=>Carbon::now(),
            ]);
            return back()->with('inventory', 'Inventory Added Successfully!');
        }

    }
    //color delete
    function color_delete($color_id){
        Color::find($color_id)->delete();
        return back()->with('delete', 'Color Deleted Successfully!');

    }
    //size delete
    function size_delete($size_id){
        Size::find($size_id)->delete();
        return back()->with('delete', 'Size Deleted Successfully!');

    }

    //inventory delete
    function inventory_delete($inventory_id){
        Inventory::find($inventory_id)->delete();
        return back()->with('delete', 'Inventory Deleted Successfully!');

    }

    //inventory edit
    function inventory_edit($inventory_id){
        $colors = Color::all();
        $sizes = Size::all();
        $inventories = Inventory::find($inventory_id);
        return view('admin.inventory.edit',[
            'colors'=> $colors,
            'sizes'=> $sizes,
            'inventories'=> $inventories,
        ]);
    }

    //inventory update
    function inventory_update(Request $request){
        $request->validate([
            'color_id'=>'required',
            'size_id'=>'required',
            'quantity'=>'required',
        ]);

            Inventory::find($request->inventory_id)->update([
                'color_id'=>$request->color_id,
                'size_id'=>$request->size_id,
                'quantity'=>$request->quantity,
                'updated_at'=>carbon::now(),
            ]);
        return redirect()->route('product.list')->with('success','Inventory Updated Successfully');
    }

    //insert meta tags to database
    function tags(Request $request){
        $request->validate([
            'tag_name'=>'required|unique:meta_tags',
        ]);
        MetaTag::insert([
            'product_id'=>$request->product_id,
            'tag_name'=>$request->tag_name,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('tags_success', 'Tags Added Successfully!');
    }

    //meta tags delete
    function tags_delete($tags){
        MetaTag::find($tags)->delete();
        return back()->with('delete', 'Keyword Deleted Successfully!');

    }

}
