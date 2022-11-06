<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SubcategoryController extends Controller
{
    //sub category
    function sub_category(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.subcategory.add_subcategory' , [
            'categories'=>$categories,
            'subcategories'=>$subcategories,
        ]);
    }
    //sub category insert
    function sub_category_insert(Request $request){
        $request->validate([
            'category_id'=>'required',
            'subcategory_name'=>'required',
        ]);

        if(Subcategory::where('category_id' , $request->category_id)->where('subcategory_name', $request->subcategory_name)->exists()){
            return back()->with('exist' , 'Subcategory Already Exist in this Category');
        }
        else{
            Subcategory::insert([
                'category_id'=>$request->category_id,
                'subcategory_name'=>$request->subcategory_name,
                'created_at'=>Carbon::now(),
                ]);
        }
        return back()->with('success', 'Subcategory Added Successfully!');
    }
    //subcategory edit
    function sub_category_edit($subcategory_id){
        $categories = Category::all();
        $subcategories_info = Subcategory::find($subcategory_id);
        return view('admin.subcategory.edit' , [
            'categories'=>$categories,
            'subcategories_info'=>$subcategories_info,
        ]);
    }

    //subcategory update
    function sub_category_update(Request $request){
        $request->validate([
            'category_id'=>'required',
            'subcategory_name'=>'required',
        ]);

        if(Subcategory::where('category_id' , $request->category_id)->where('subcategory_name', $request->subcategory_name)->exists()){
            return back()->with('exist' , 'SubCategory Already Exist in this Category');
        }else{
            Subcategory::find($request->subcategory_id)->update([
                'category_id'=>$request->category_id,
                'subcategory_name'=>$request->subcategory_name,
                'updated_at'=>Carbon::now(),
            ]);

        }
          return redirect()->route('add.sub.category')->with('edit', 'SubCategory edited Successfully!');
    }

    //subcategory soft delete
    function sub_category_delete($subcategory_id){
        Subcategory::find($subcategory_id)->delete();
        return back()->with('delete', 'SubCategory Deleted Successfully!');

    }

    //subcategory trash
    function sub_category_trash(){
        $trash = Subcategory::onlyTrashed()->get();
        return view('admin.subcategory.trash' , [
            'trash'=>$trash,
        ]);
    }

    //subcategory restore
    function restore($subcategory_id){
        Subcategory::onlyTrashed()->find($subcategory_id)->restore();
        return back()->with('success', 'Subategory Restored Successfully!');
    }

       //subcategory hard delete
       function hard_delete($subcategory_id){
        Subcategory::onlyTrashed()->find($subcategory_id)->forceDelete();
        return back()->with('delete', 'Subcategory Permanently Deleted');
    }

}
