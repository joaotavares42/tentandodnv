<?php
namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Bank Route
Route::post('bank', [BankController::class, 'store']);
Route::get('bank', [BankController::class, 'index']);

// Agency route
Route::get('agency', [AgencyController::class, 'index']);
Route::post('agency', [AgencyController::class, 'store']);

//User route
Route::post('user', [UserController::class, 'store']);


Route::post('deposit', [AccountController::class, 'deposit']);

Route::get('balance', function (Request $request){
    return Account::select('balance')->where('user_id', auth()->user()->id)->first();
})->middleware('auth:api');

Route::post('withdraw', [WithdrawController::class, 'store'])->middleware('auth:api');
Route::post('transfer', [TransferController::class, 'store'])->middleware('auth:api');
Route::post('payments', [PaymentController::class, 'store'])->middleware('auth:api');
Route::get('payments', [PaymentController::class, 'index'])->middleware('auth:api');
Route::put('payments', [PaymentController::class, 'update'])->middleware('auth:api');

//Route::resource('teste', TesteController::class);
