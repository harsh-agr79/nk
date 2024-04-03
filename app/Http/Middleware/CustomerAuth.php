<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Customer;

class CustomerAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->session()->has('CUSTOMER_LOGIN')){
            \View::share('user', Customer::where('id', session()->get('CUSTOMER_ID'))->first());
            \View::share('type', 'customer');
        }
        else{
            $request->session()->flash('error', 'Access denied');
            return redirect('login');
        }
        return $next($request);
    }
}
