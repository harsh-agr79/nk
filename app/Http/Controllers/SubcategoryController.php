<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result['category'] = DB::table('categories')->get();
        return view('admin/subcategory', $result);
    }

    public function addsubc(Request $request){
    
       
        $sub=$request->post('sub');
        $parent=$request->post('parent');

        $check = Subcategory::where('sub', $sub)->where('parent', $parent)->get();

        if($check->isEmpty()){
            Subcategory::insert([
                'sub'=>$sub,
                'parent'=>$parent,
            ]);
            return response()->json(['success'=>'successfully added']);
        }
        else{
            return response()->json([
                // 'check'=>$check,
                'message'=>'SubCategory Already Exists in Parent Category'
            ]);
            
        }
        
    }
    public function getsubc(){
        $subcategories = Subcategory::all();
        return response()->json(['subcategories'=>$subcategories]);
    }
    public function editsubc($id){
        $subcategory = Subcategory::find($id);
        if($subcategory){
            return response()->json([
                'status'=>200,
                'subcategory'=>$subcategory
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'SubCategory Not Found'
            ]);
        }
    }
    public function updatesubc(Request $request){
        $id = $request->post('id');

        $sub=$request->post('sub');
        $parent=$request->post('parent');

        $check = Subcategory::where('sub', $sub)->where('parent', $parent)->get();

        if($check->isEmpty()){
            Subcategory::where('id', $id)->update([
                'sub'=>$sub,
                'parent'=>$parent,
            ]);
            return response()->json(['success'=>'successfully updated']);
        }
        else{
            if($check[0]->id == $id){
                return response()->json(['success'=>'successfully updated']);
            }
            else{
                return response()->json([
                    'message'=>'SubCategory Already Exists in Parent Category'
                ]);
            }
        }
        
    }
    public function deletesubc(Request $request){
        $id=$request->post('id');
        $model=Subcategory::where(['id'=>$id]);
        $model->delete();
    }
}
