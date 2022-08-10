<?php

use App\Http\Controllers\CatagoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ProductReceiptCompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\OutgoingController;

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


Route::get('/', function () {
    return view('auth.register');
});

// Route::get('/dashboard', function () {
//     return view('mydashboard');
// })->middleware(['auth'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::resource('catagory', CatagoryController::class);
    Route::resource('company', CompanyController::class);
    Route::resource('invoice', InvoiceController::class);
    Route::resource('product', ProductController::class);
    Route::resource('product_receipt_company', ProductReceiptCompanyController::class);
    Route::resource('invoice_product', InvoiceController::class);
    Route::resource('incoming', IncomingController::class);
    Route::resource('outgoing', OutgoingController::class);
    Route::post('ajaxRequest', [AjaxController::class, 'getProduct']);
    Route::resource('cashier', CashierController::class);
    Route::resource('dashboard', DashboardController::class);
    Route::resource('receipt', ReceiptController::class);
});

Route::middleware(['auth', 'access'])->group(function () {
    Route::resource('employee', EmployeeController::class);
    Route::resource('user', UserController::class);
    // Route::put('ajaxRequest', [AjaxController::class, 'saveInvoiceItemToSession']);
});

require __DIR__ . '/auth.php';
