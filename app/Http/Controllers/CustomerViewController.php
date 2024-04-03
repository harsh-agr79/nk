<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerViewController extends Controller
{
    public function home(Request $request){
        $result['orders'] = DB::table('orders')->orderBy('created_at', 'DESC')
        ->where('userid', $request->session()->get('CUSTOMER_ID'))
        ->groupBy('orderid')
        ->selectRaw('*, SUM(quantity * price * (1-discount * 0.01)) as sum')
        ->get();
        return view("customer/home", $result);
    }
}
