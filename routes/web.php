<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerViewController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AdminController::class, 'login']);
Route::get('/login', [AdminController::class, 'login']);
Route::post('/auth',[AdminController::class, 'auth'])->name('auth');

Route::get('/logout', function(){
    session()->flush();
    session()->flash('error','Logged Out');
    return redirect('/');
});

Route::group(['middleware'=>'admin_auth'], function(){
   
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    Route::get('/customer', [CustomerController::Class, 'index']);
    Route::post('/customeradd',[CustomerController::class, 'addcust']);
    Route::post('/customerupdate',[CustomerController::class, 'updatecust']);
    Route::post('/deletecustomer',[CustomerController::class, 'deletecust']);
    Route::get('/customerget',[CustomerController::class, 'getcust']);
    Route::get('/customerget2',[CustomerController::class, 'getcust2']);
    Route::get('/editcustomer/{id}',[CustomerController::class, 'editcust']);

    Route::get('/category', [CategoryController::class, 'index']);
    Route::post('/categoryadd',[CategoryController::class, 'addcatg']);
    Route::post('/categoryupdate',[CategoryController::class, 'updatecatg']);
    Route::post('/deletecategory',[CategoryController::class, 'deletecatg']);
    Route::get('/categoryget',[CategoryController::class, 'getcatg']);
    Route::get('/editcategory/{id}',[CategoryController::class, 'editcatg']);

    Route::get('/payment', [PaymentController::class, 'index']);
    Route::post('/paymentadd',[PaymentController::class, 'addpay']);
    Route::post('/paymentupdate',[PaymentController::class, 'updatepay']);
    Route::post('/deletepayment',[PaymentController::class, 'deletepay']);
    Route::get('/paymentget',[PaymentController::class, 'getpay']);
    Route::get('/editpayment/{id}',[PaymentController::class, 'editpay']);

    Route::get('/subcategory', [SubcategoryController::class, 'index']);
    Route::post('/subcategoryadd',[SubcategoryController::class, 'addsubc']);
    Route::post('/subcategoryupdate',[SubcategoryController::class, 'updatesubc']);
    Route::post('/deletesubcategory',[SubcategoryController::class, 'deletesubc']);
    Route::get('/subcategoryget',[SubcategoryController::class, 'getsubc']);
    Route::get('/editsubcategory/{id}',[SubcategoryController::class, 'editsubc']);
    

    Route::get('/expense', [ExpenseController::class, 'index']);
    Route::post('/expenseadd',[ExpenseController::class, 'addexps']);
    Route::post('/expenseupdate',[ExpenseController::class, 'updateexps']);
    Route::post('/deleteexpense',[ExpenseController::class, 'deleteexps']);
    Route::get('/expenseget',[ExpenseController::class, 'getexps']);
    Route::get('/editexpense/{id}',[ExpenseController::class, 'editexps']);

    Route::get('/product', [ProductController::class, 'index']);
    Route::post('/productget2',[ProductController::class, 'getprod']);
    Route::post('/productadd',[ProductController::class, 'addprod']);
    Route::post('/productupdate',[ProductController::class, 'updateprod']);
    Route::post('/deleteproduct',[ProductController::class, 'deleteprod']);
    Route::get('/editproduct/{id}',[ProductController::class, 'editprod']);

    Route::get('/itemget',[ProductController::class, 'getitem']);

    // Route::get('/categoryfill', [CategoryController::class, 'catfill']);

    Route::get('/addorder', [OrderController::class, 'addorder']);
    Route::post('/createorder', [OrderController::class, 'createorder'])->name('createorder');
    Route::get('/order', [OrderController::class, 'index']);
    Route::get('/detail/{id}', [OrderController::class, 'detail']);
    Route::get('/editorder/{id}', [OrderController::class, 'editorder']);
    Route::post('/updateorder', [OrderController::class, 'updateorder'])->name('updateorder');
    Route::get('/deleteorder/{id}', [OrderController::class, 'deleteorder']);
    Route::get('/cusgetsite/{id}', [CustomerController::Class, 'getsite']);
    Route::get('/cusgetoid/{id}', [CustomerController::Class, 'getoid']);
});

Route::group(['middleware'=>'customer_auth'], function(){
    Route::get('/customer/home', [CustomerViewController::class, 'home']);
});
