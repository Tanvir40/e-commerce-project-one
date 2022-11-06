<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategoryRequest;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    //add Category
    function add_Category(){
        $categories = Category::where('id','!=',Auth::id())->paginate(2);
        return view('admin.category.add_category', [
            'categories'=>$categories,
        ]);
    }

    //Category insert
    function insert(CategoryRequest $request){
        // $request->validate([
        //     'Category_name'=>'required|unique:categories',
        // ],[
        //     'Category_name.unique'=>'Category name akbar neya hoise',
        //     'Category_name.required'=>'Category name dite hbe',
        // ]);

       $user_id = Category::insertGetId([
            'user_id'=>Auth::id(),
            'category_name'=>$request->category_name,
            'created_at'=>carbon::now(),
        ]);
        $uploaded_file = $request->category_image;
       $extension = $uploaded_file->getClientOriginalExtension();
       $file_name = $request->category_name.'.'.$extension;

       Image::make($uploaded_file)->resize(680,680)->save(public_path('/uploads/category/'.$file_name));

       Category::find($user_id)->update([
        'category_image'=>$file_name,
       ]);
        return back()->with('success', 'Category Added Successfully!');
    }

    //Category edit
    function edit($Category_id){
        $category_info = Category::find($Category_id);
        return view('admin.category.edit', compact('category_info'));
    }

    //Category update
    function update(Request $request){
        $request->validate([
            'category_name'=>'required',
        ]);
        if(Category::where('category_name' , $request->category_name)->exists()){
            return back()->with('exist' , 'Category Already Exist in this Category');
        }else{
            Category::find($request->id)->update([
                'user_id'=>Auth::id(),
                'category_name'=>$request->category_name,
                'updated_at'=>carbon::now(),
            ]);
        }
        return redirect('/category')->with('edit', 'Category edited Successfully!');
    }

    //Category soft delete
    function delete($Category_id){
        Category::find($Category_id)->delete();
        return back()->with('delete', 'Category Deleted Successfully!');
    }

    //Category trash
    function trash(){
        $trash = Category::onlyTrashed()->get();
         return view('admin.category.trash', compact('trash'));
    }

    //Category restore
    function restore($Category_id){
        Category::onlyTrashed()->find($Category_id)->restore();
        return back()->with('success', 'Category Restored Successfully!');
    }

    //Category hard delete
    function hard_delete($Category_id){
        Category::onlyTrashed()->find($Category_id)->forceDelete();
        return back()->with('delete', 'Category Permanently Deleted');
    }

    //Category mark delete
    function mark_delete(Request $request){
        foreach($request->mark as $mark){
            Category::find($mark)->delete();
        }
        return back();
    }

    ////Category mark trash delete
    function mark_trash_delete(Request $request){
        foreach($request->mark as $mark){
            Category::onlyTrashed()->find($mark)->forceDelete();
            // echo $mark;
         }
        return back();
    }

}
