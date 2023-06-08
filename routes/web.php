<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => ['is_login']],function(){
    Route::get('/register',[UserController::class,'Register']);
    Route::post('/user-register',[UserController::class,'RegisterUser'])->name('user.register');
    Route::get('/referral-register',[UserController::class,'ReferralRegister']);
    Route::get('/email-verification/{token}',[UserController::class,'EmailVerification']);
    Route::get('/login',[UserController::class,'Login']);
    Route::post('/login',[UserController::class,'LoginUser'])->name('user.login'); 
});
Route::group(['middleware' => ['is_logout']],function(){
    Route::get('/dashboard',[UserController::class,'LoadDashboard']);
    Route::get('/user-logout',[UserController::class,'LogoutUser'])->name('user.logout'); 
    Route::get('/referraltrack-data',[UserController::class,'ReferralTrack'])->name('referraltrack.data');
    Route::get('/user-delete-account',[UserController::class,'DeleteAccount'])->name('delete.account');
    Route::get('/user-profile-load',[UserController::class,'LoadProfile'])->name('profile.load');
    Route::post('/user-profile-update',[UserController::class,'ProfileUser'])->name('profile.user');
    Route::post('/change-password',[UserController::class,'ChangePassword'])->name('change.password');
});


