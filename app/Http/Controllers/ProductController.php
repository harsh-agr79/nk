<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['category'] = DB::table('categories')->get();
        return view('admin/product', $result);
    }
    public function getprod(Request $request){
        $category = $request->get('category');

        if($request->get('category')){
            $products = Product::orderBy('id', 'DESC')->where('category', $category)->get();
            return response()->json(['products'=>$products]);
        }
        else{
            return response()->json(['products'=>'']);
        }
       
    }
    public function getitem(){
        $items = Product::all();
        return response()->json($items);
    }

    public function addprod(Request $request){
    
        $request->validate([
            'name'=>'required|unique:products,name,',
        ]);
        $name=$request->post('name');
        $category=$request->post('category');
        $stock=$request->post('stock');

       
            Product::insert([
                'name'=>$name,
                'category'=>$category,
                'stock'=>$stock,
            ]);
            return response()->json(['success'=>'successfully added']);
        
    }
    public function editprod($id){
        $product = Product::find($id);
        if($product){
            return response()->json([
                'status'=>200,
                'product'=>$product
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Product Not Found'
            ]);
        }
    }
    public function updateprod(Request $request){
        $id = $request->post('id');
        $request->validate([
            'name'=>'required|unique:products,name,'.$id,
        ]);
        $name=$request->post('name');
        $category=$request->post('category');
        $stock=$request->post('stock');

            Product::where('id', $id)->update([
                'name'=>$name,
                'category'=>$category,
                'stock'=>$stock,
            ]);
            return response()->json(['success'=>'successfully updated']);
    }
    public function deleteprod(Request $request){
        $id=$request->post('id');
        $model=Product::where(['id'=>$id]);
        $model->delete();
    }
}
