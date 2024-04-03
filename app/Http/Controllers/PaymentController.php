<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin/payment');
    }

    public function addpay(Request $request){
    
        $username=$request->post('username');
        $userid=DB::table('customers')->where('username', $username)->first()->id;
        $paymentid='py'.date('siHdmy');
        $type=$request->post('type');
        $amount=0;
        $date=$request->post('date');
        $oid=$request->post('oid',[]);
        $amt=$request->post('amt',[]);
        $cpay=$request->post('closepay', []);
        $keys = array_keys(array_filter($amt));

            foreach($keys as $key) {
                $oid2[] = $oid[$key];
                $amt2[] = $amt[$key];
                $cpay2[] = $cpay[$key];
            }

        // $oid2 = get_values_for_keys($oid, array($keys));
        // $amt2 = get_values_for_keys($amt, array($keys));

        foreach ($amt as $key => $value) {
            $amount = $amount + $amt[$key];
        }
        Payment::insert([
            'username'=>$username,
            'userid'=>$userid,
            'paymentid'=>$paymentid,
            'type'=>$type,
            'amount'=>$amount,
            'date'=>$date,
            'oid'=>implode(',', $oid2),
            'amt'=>implode(',', $amt2),
        ]);

        // $orders = DB::table('orders')
        // ->orderBy('created_at', 'ASC')
        // ->whereIn('orderid',$oid)
        // ->selectRaw('*, SUM(quantity * price) as sum, SUM(quantity * price * discount * 0.01) as dis')
        // ->groupBy('orderid')
        // ->get();

        foreach ($oid2 as $index => $order){
         $orders = DB::table('orders')
        ->where('orderid',$oid2[$index])
        ->selectRaw('*, SUM(quantity * price) as sum, SUM(quantity * price * discount * 0.01) as dis')
        ->groupBy('orderid')
        ->first();
            $oramt = $orders->sum - $orders->dis;
        if ($cpay2[$index] == 'on') {
            DB::table('orders')->where('orderid', $oid2[$index])->update([
                'paidamt'=>floatval($orders->paidamt) + $amt2[$index],
                'disextra'=>$oramt - (floatval($orders->paidamt) + $amt2[$index]),
            ]);
        } else {
            DB::table('orders')->where('orderid', $oid2[$index])->update([
                'paidamt'=>floatval($orders->paidamt) + $amt2[$index]
            ]);
        }
        
          
        }
        return response()->json(['oids'=>'success']);
    }
    
    public function getpay(){
        $payments = Payment::all();
        return response()->json(['payments'=>$payments]);
    }
    public function editpay($id){
        $payment = Payment::find($id);
        if($payment){
            return response()->json([
                'status'=>200,
                'payment'=>$payment
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Payment Not Found'
            ]);
        }
    }
    public function updatepay(Request $request){
        $id = $request->post('id');
       
        $username=$request->post('username');
        $userid=DB::table('customers')->where('username', $username)->first()->id;
        // $paymentid=$request->post('paymentid');
        $type=$request->post('type');
        $amount=$request->post('amount');
        $date=$request->post('date');
        

        Payment::where('id', $id)->update([
            'username'=>$username,
            'userid'=>$userid,
            // 'paymentid'=>$paymentid,
            'type'=>$type,
            'amount'=>$amount,
            'date'=>$date,
        ]);
        return response()->json(['success'=>'successfully added']);
    }
    public function deletepay(Request $request){
        $id=$request->post('id');
        $payment=Payment::where(['id'=>$id])->first();
        $oid2 = explode(',', $payment->oid);
        $amt2 = explode(',', $payment->amt);
        foreach ($oid2 as $index => $order){
            $orders = DB::table('orders')
           ->where('orderid',$oid2[$index])
           ->selectRaw('*, SUM(quantity * price) as sum, SUM(quantity * price * discount * 0.01) as dis')
           ->groupBy('orderid')
           ->first();
               DB::table('orders')->where('orderid', $oid2[$index])->update([
                   'paidamt'=>floatval($orders->paidamt) - floatval($amt2[$index])
               ]);
           }
        $payment->delete();
    }
}
