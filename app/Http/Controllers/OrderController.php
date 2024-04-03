<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result['orders'] = Order::orderBy('created_at', 'DESC')->groupBy('orderid')->get();
        return view('admin/order', $result);
    }

    Public function addorder()
    {
        return view('admin/addorder');
    }

    public function createorder(Request $request)
    {
        // $request->validate([
        //     'voucher'=>'image|mimes:jpeg,png,jpg,svg'
        // ]);
        $username = $request->post('username');
        $user = DB::table('customers')->where('username',$username)->first();
        $userid = $user->id;
        $orders = Order::whereDate('created_at', Carbon::today())->get();
        if(count($orders)+1 > 9){
            $orderid='nk'.$userid.date('dmy').count($orders) + 1;
        }
        else{
            $orderid='nk'.$userid.date('dmy').'0'.count($orders) + 1;   
        }
        $item=$request->post('item',[]);
        $price=$request->post('price',[]);
        $quantity=$request->post('quantity',[]);
        $discount=$request->post('discount');
        $cashdiscount=$request->post('cash_discount');
        $site=$request->post('site');
        $date = Carbon::now();
        // $date->addHours(5);
        // $date->addMinutes(30);
        $time = date('H:i:s', strtotime($date));
        
        if($request->hasFile('voucher')){
            // $path='voucher/'.$request->post('oldimg');
            $file = $request->file('voucher');
            $ext = $file->extension();
            $image_name = $orderid.'.'.$ext;
            $file->move('voucher/',$image_name);
            $image = $image_name;

        /// USE When updating the voucher///
            // Employee::where('id', $id)->update([
            //     'candcp'=>$image,
            // ]);
            // if(File::exists($path)) {
            //     File::delete($path);
            // }

        }
        else{
            $image = NULL;
        }
       
        $created_at = $request->post('date')." ".$time;
        foreach ($item as $index => $order) {
            if($quantity[$index] != NULL){
                    $orders=[
                        'username'=>$username,
                        'userid'=>$userid,
                        'orderid'=>$orderid,
                        'item'=>$item[$index],
                        'category'=>DB::table('products')->where('name', $item[$index])->first()->category,
                        'price'=>$price[$index],
                        'quantity'=>$quantity[$index],
                        'voucher'=>$image,
                        'discount'=>$discount,
                        'cash_discount'=>$cashdiscount,
                        'site'=>$site,
                        "created_at"=> $created_at,
                    ];
                    $created = order::insert($orders);
                }
        }
        return redirect('/order');
    }
    public function detail(Request $request, $orderid){
        $result['order'] = Order::where('orderid', $orderid)->get();
        $result['order2'] = Order::where('orderid', $orderid)->selectRaw('*, SUM(quantity * price) as sum')->groupBy('orderid')->get();
        $result['order3'] = Order::where('orderid', $orderid)->selectRaw('*, SUM(quantity * price) as sum, SUM(quantity * price * discount * 0.01) as dis')->groupBy('orderid')->groupBy('category')->get();
        return view('admin/detail', $result);
    }
    public function editorder(Request $request, $orderid)
    {
        $result['order'] = Order::where('orderid', $orderid)->get();
        return view('admin/editorder', $result);
    }
    public function updateorder(Request $request){
        $username = $request->post('username');
        $user = DB::table('customers')->where('username',$username)->first();
        $userid = $user->id;
        $orderid= $request->post('orderid');
        $id=$request->post('id', []);
        $item=$request->post('item',[]);
        $price=$request->post('price',[]);
        $quantity=$request->post('quantity',[]);
        $discount=$request->post('discount');
        $cashdiscount=$request->post('cash_discount');
        $site=$request->post('site');
        $date = Carbon::now();
        // $date->addHours(5);
        // $date->addMinutes(30);
        $time = date('H:i:s', strtotime($date));
        $created_at = $request->post('date')." ".$time;
        if($request->hasFile('voucher')){
            $path='voucher/'.$request->post('oldimg');
            if(File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('voucher');
            $ext = $file->extension();
            $image_name = $orderid.'.'.$ext;
            $file->move('voucher/',$image_name);
            $image = $image_name;  
        }
        else{
            $image = $request->post('oldimg');
        }
        Order::where('orderid', $orderid)->whereNotIn('id', $id)->delete();
        foreach ($item as $index => $order) {
            if($quantity[$index] != NULL){
                if($id[$index] != NULL){
                    Order::where('id', $id[$index])->update([
                        'username'=>$username,
                        'userid'=>$userid,
                        // 'orderid'=>$orderid,
                        'item'=>$item[$index],
                        'category'=>DB::table('products')->where('name', $item[$index])->first()->category,
                        'price'=>$price[$index],
                        'quantity'=>$quantity[$index],
                        'voucher'=>$image,
                        'site'=>$site,
                        'discount'=>$discount,
                        'cash_discount'=>$cashdiscount,
                        // "created_at"=> $created_at,
                    ]);
                }
                else{
                    $orders=[
                        'username'=>$username,
                        'userid'=>$userid,
                        'orderid'=>$orderid,
                        'item'=>$item[$index],
                        'category'=>DB::table('products')->where('name', $item[$index])->first()->category,
                        'price'=>$price[$index],
                        'quantity'=>$quantity[$index],
                        'voucher'=>$image,
                        'discount'=>$discount,
                        'cash_discount'=>$cashdiscount,
                        'site'=>$site,
                        "created_at"=> $created_at,
                    ];
                    $created = order::insert($orders);
                }
            }
        }
        return redirect('detail/'.$orderid);
    }
    public function deleteorder(Request $request, $orderid)
    {
        Order::where('orderid', $orderid)->delete();
        return redirect('/order');
    }
}
