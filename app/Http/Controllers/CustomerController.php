<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result['category'] = DB::table('categories')->get();
        return view('admin/customer', $result);
    }

    public function addcust(Request $request){
    
        $request->validate([
            'username'=>'required|unique:customers,username|unique:admins,username,',
            'unique_code'=>'required|unique:customers,unique_code,',
            'phone'=>'required|unique:customers,phone,',
        ]);
        $name=$request->post('name');
        $username=$request->post('username');
        $unique_code=$request->post('unique_code');
        $password=$request->post('password');
        $type=$request->post('type');
        $code=$request->post('code');
        $phone=$request->post('phone');
        $address=$request->post('address');
        $category=$request->post('category', []);
        $commission = $request->post('commission', []);
        if($type == 'interior')
        {
            $cat = implode(',', $category);
            $com = implode(',', $commission);
        }
        else
        {
            $cat = NULL;
            $com = NULL;
        }

        Customer::insert([
            'name'=>$name,
            'username'=>$username,
            'unique_code'=>$unique_code,
            'password'=>$password,
            'type'=>$type,
            'code'=>$code,
            'phone'=>$phone,
            'address'=>$address,
            'category'=>$cat,
            'commission'=>$com,
        ]);
        return response()->json(['success'=>'successfully added']);
    }
    public function getcust(){
        $customers = Customer::all();
        return response()->json(['customers'=>$customers]);
    }
    public function getcust2(){
        $customers = Customer::all();
        return response()->json($customers);
    }
    public function editcust($id){
        $customer = Customer::find($id);
        $category = DB::table('categories')->pluck('category')->toArray();
        if($customer){
            return response()->json([
                'status'=>200,
                'customer'=>$customer,
                'category2'=>$category
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Customer Not Found'
            ]);
        }
    }
    public function updatecust(Request $request){
        $id = $request->post('id');
        $request->validate([
            'username'=>'required|unique:admins,username|unique:customers,username,'.$id,
            'unique_code'=>'required|unique:customers,unique_code,'.$id,
            'phone'=>'required|unique:customers,phone,'.$id,
        ]);
        $name=$request->post('name');
        $username=$request->post('username');
        $unique_code=$request->post('unique_code');
        $password=$request->post('password');
        $type=$request->post('type');
        $code=$request->post('code');
        $phone=$request->post('phone');
        $address=$request->post('address');
        $category=$request->post('category', []);
        $commission = $request->post('commission', []);
        if($type == 'interior')
        {
            $cat = implode(',', $category);
            $com = implode(',', $commission);
        }
        else
        {
            $cat = NULL;
            $com = NULL;
        }
        

        Customer::where('id', $id)->update([
            'name'=>$name,
            'username'=>$username,
            'unique_code'=>$unique_code,
            'password'=>$password,
            'type'=>$type,
            'code'=>$code,
            'phone'=>$phone,
            'address'=>$address,
            'category'=>$cat,
            'commission'=>$com,
        ]);
        return response()->json(['success'=>'successfully added']);
    }
    public function deletecust(Request $request){
        $id=$request->post('id');
        $model=Customer::where(['id'=>$id]);
        $model->delete();
    }

    public function getsite(Request $request, $username){
        $type = Customer::where('username', $username)->first()->type;
        $sites = DB::table('orders')->where('username',$username)->groupBy('site')->get();
       
        if($sites){
            return response()->json([
                'type'=>$type,
                'sites'=>$sites
            ]);
        }
        else{
            return response()->json([
                'type'=>$type,
                'sites'=>''
            ]);
        }
    }
    public function getoid(Request $request, $username){
        $payoid = DB::table('payments')->where('username', $username)->get();
        $oid = DB::table('orders')->where('username',$username)->selectRaw('*, SUM(quantity * price) as sum, SUM(quantity * price * discount * 0.01) as dis')->groupBy('orderid')->get();
       
        if($oid){
            return response()->json([
                'payoid'=>$payoid,
                'oid'=>$oid,
            ]);
        }
        else{
            return response()->json([
                // 'type'=>$type,
                'sites'=>''
            ]);
        }
    }
}
