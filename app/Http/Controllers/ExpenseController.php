<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin/expense');
    }

    public function addexps(Request $request){
    
        $username=$request->post('username');
        $userid=DB::table('customers')->where('username', $username)->first()->id;
        $expenseid='exp'.date('siHdmy');
        $particular=$request->post('particular');
        $amount=$request->post('amount');
        $date=$request->post('date');

        Expense::insert([
            'username'=>$username,
            'userid'=>$userid,
            'expenseid'=>$expenseid,
            'particular'=>$particular,
            'amount'=>$amount,
            'date'=>$date,
        ]);
        return response()->json(['success'=>'successfully added']);
    }
    public function getexps(){
        $expenses = Expense::all();
        return response()->json(['expenses'=>$expenses]);
    }
    public function editexps($id){
        $expense = Expense::find($id);
        if($expense){
            return response()->json([
                'status'=>200,
                'expense'=>$expense
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Expense Not Found'
            ]);
        }
    }
    public function updateexps(Request $request){
        $id = $request->post('id');
       
        $username=$request->post('username');
        $userid=DB::table('customers')->where('username', $username)->first()->id;
        // $paymentid=$request->post('paymentid');
        $particular=$request->post('particular');
        $amount=$request->post('amount');
        $date=$request->post('date');
        

        Expense::where('id', $id)->update([
            'username'=>$username,
            'userid'=>$userid,
            // 'paymentid'=>$paymentid,
            'particular'=>$particular,
            'amount'=>$amount,
            'date'=>$date,
        ]);
        return response()->json(['success'=>'successfully added']);
    }
    public function deleteexps(Request $request){
        $id=$request->post('id');
        $model=Expense::where(['id'=>$id]);
        $model->delete();
    }
}
