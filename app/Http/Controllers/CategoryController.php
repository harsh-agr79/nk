<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        return view('admin/category');
    }

    public function addcatg(Request $request){
    
        $request->validate([
            'category'=>'required|unique:categories,category,',
        ]);
        $category=$request->post('category');

        Category::insert([
            'category'=>$category,
        ]);
        return response()->json(['success'=>'successfully added']);
    }
    public function getcatg(){
        $categories = Category::all();
        return response()->json(['categories'=>$categories]);
    }
    public function editcatg($id){
        $category = Category::find($id);
        if($category){
            return response()->json([
                'status'=>200,
                'category'=>$category
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Category Not Found'
            ]);
        }
    }
    public function updatecatg(Request $request){
        $id = $request->post('id');
        $request->validate([
            'category'=>'required|unique:categories,category,'.$id,
        ]);
        $category=$request->post('category');

        Category::where('id', $id)->update([
            'category'=>$category,
        ]);
        return response()->json(['success'=>'successfully updated']);
    }
    public function deletecatg(Request $request){
        $id=$request->post('id');
        $model=Category::where(['id'=>$id]);
        $model->delete();
    }
    public function catfill(Request $request)
        {
            $categories = DB::table('products')->groupBy('category')->pluck('category')->toArray();

            foreach($categories as $item){
                Category::insert([
                    'category'=>$item,
                ]);
            }
        }
}
