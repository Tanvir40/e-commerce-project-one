<?php

namespace App\Http\Controllers;

use App\Models\Childcategory;
use App\Models\Subcategory;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChildcategoryController extends Controller
{
    //child category
    function child_category(){
        $childcategories = Childcategory::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.childcategory.childcategory' , [
            'childcategories'=>$childcategories,
            'subcategories'=>$subcategories,
            'categories'=>$categories,
        ]);
    }
    //child category insert
    function child_category_insert(Request $request){
        $request->validate([
            'category_id'=>'required',
            'subcategory_id'=>'required',
            'childcategory_name'=>'required',
        ]);

        if(Childcategory::where('category_id' , $request->category_id)->where('childcategory_name', $request->childcategory_name)->exists()){
            return back()->with('exist' , 'childcategory Already Exist in this Category');
        }else{
            Childcategory::insert([
                'category_id'=>$request->category_id,
                'subcategory_id'=>$request->subcategory_id,
                'childcategory_name'=>$request->childcategory_name,
                'created_at'=>Carbon::now(),
                ]);
        }
        return back()->with('success', 'Child Category Added Successfully!');
    }
     //child category edit
     function child_category_edit($childcategory_id){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $childcategories_info = Childcategory::find($childcategory_id);
        return view('admin.childcategory.edit' , [
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'childcategories_info'=>$childcategories_info,
        ]);
    }
    //ajax get subcategory
    function getSubcategory(Request $request){
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        $str =  '<option value="">-- select subcategory --</option>';
        foreach($subcategories as $subcategory){
            $str .= '<option value="'.$subcategory->id.'">'.$subcategory->subcategory_name.'</option>';
        }
        echo $str;
    }

    //child category update
    function child_category_update(Request $request){
        $request->validate([
            'category_id'=>'required',
            'subcategory_id'=>'required',
            'childcategory_name'=>'required',
        ]);

        if(Childcategory::where('category_id' , $request->category_id)->where('subcategory_id' , $request->subcategory_id)->where('childcategory_name', $request->childcategory_name)->exists()){
            return back()->with('exist' , 'ChildCategory Already Exist in this Category');
        }else{
            Childcategory::find($request->childcategory_id)->update([
                'category_id'=>$request->category_id,
                'subcategory_id'=>$request->subcategory_id,
                'childcategory_name'=>$request->childcategory_name,
                'updated_at'=>Carbon::now(),
            ]);

        }
          return redirect()->route('add.child.category')->with('edit', 'ChildCategory edited Successfully!');
    }

    //child category soft delete
    function child_category_delete($childcategory_id){
        Childcategory::find($childcategory_id)->delete();
        return back()->with('delete', 'ChildCategory Deleted Successfully!');

    }

       //child category trash
       function child_category_trash(){
        $trash = Childcategory::onlyTrashed()->get();
        return view('admin.childcategory.childcategory_trash' , [
            'trash'=>$trash,
        ]);
    }

    //child category restore
    function restore($childcategory_id){
        Childcategory::onlyTrashed()->find($childcategory_id)->restore();
        return back()->with('success', 'ChildCategory Restored Successfully!');
    }

       //child category hard delete
       function hard_delete($childcategory_id){
        Childcategory::onlyTrashed()->find($childcategory_id)->forceDelete();
        return back()->with('delete', 'Childcategory Permanently Deleted');
    }
}
