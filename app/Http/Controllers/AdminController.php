<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if($request->session()->has('ADMIN_LOGIN')){
            return redirect('dashboard');
        }
        elseif($request->session()->has('CUSTOMER_LOGIN')){
            return redirect('customer/home');
        }
        else{
            return view('login');
        }
        return view('login');
    }
    public function auth(Request $request)
    {
        $username=$request->post('username');
        $password=$request->post('password');

        $result=Admin::where(['username'=>$username, 'password'=>$password])->get();
        $result2=Customer::where(['username'=>$username, 'password'=>$password])->get();
        if(isset($result['0']->id)){
            $request->session()->put('ADMIN_LOGIN', true);
            $request->session()->put('ADMIN_ID', $result['0']->id);
            $request->session()->put('ADMIN_TIME', time() );
            return redirect('dashboard');
        }
        elseif(isset($result2['0']->id)){
            $request->session()->put('CUSTOMER_LOGIN', true);
            $request->session()->put('CUSTOMER_ID', $result2['0']->id);
            $request->session()->put('CUSTOMER_TIME', time() );
            return redirect('customer/home');
        }
        else{
            $request->session()->flash('error','please enter valid login details');
            return redirect('/');
        }
    }

    public function dashboard(Request $request)
    {
        return view('admin/dashboard');
    }

    
}
