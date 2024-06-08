<?php

use App\Http\Controllers\LockScreen;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserActivityLogController;

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
    return view('auth.login');
});

// Auth::routes();

// ----------------------------- home dashboard ------------------------------//
Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('admin');
Route::get('/home/{name?}', [App\Http\Controllers\HomeController::class, 'log'])->middleware('validateBackHistory')->name('home');

Route::get('/feedback/{name?}', [App\Http\Controllers\HomeController::class, 'feedback'])->name('feedback');
// Google login
Route::get('auth/google', 'App\Http\Controllers\Auth\GoogleController@redirectToGoogle');
Route::get('auth/google/callback', 'App\Http\Controllers\Auth\GoogleController@handleGoogleCallback');

// -----------------------------login----------------------------------------//
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'authenticate']);
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// ----------------------------- lock screen --------------------------------//
Route::get('lock_screen', [App\Http\Controllers\LockScreen::class, 'lockScreen'])->middleware('auth')->name('lock_screen');
Route::post('unlock', [App\Http\Controllers\LockScreen::class, 'unlock'])->name('unlock');

// ------------------------------ register ---------------------------------//
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'storeUser'])->name('register');

// ----------------------------- forget password ----------------------------//
// Route::get('forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'getEmail'])->name('forget-password');
// Route::post('forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'postEmail'])->name('forget-password');

// // ----------------------------- reset password -----------------------------//
// Route::get('reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'getPassword']);
// Route::post('reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'updatePassword']);

// Asset
Route::resource('asset', AssetController::class);
Route::get('asset', [App\Http\Controllers\AssetController::class, 'index'])->middleware('auth')->name('asset');

// Report
Route::resource('reports', ReportController::class);
Route::get('report', [App\Http\Controllers\ReportController::class, 'index'])->middleware('auth')->name('report');

// User
Route::resource('users', UserController::class);
Route::get('users', [App\Http\Controllers\UserController::class, 'index'])->middleware('auth')->name('users');

// Activity Logs
Route::resource('activity_logs', ActivityLogController::class);
Route::get('activity_logs', [App\Http\Controllers\ActivityLogController::class, 'index'])->middleware('auth')->name('activity_logs');

Route::resource('user_activity_logs', UserActivityLogController::class);
Route::get('user_activity_logs', [App\Http\Controllers\UserActivityLogController::class, 'index'])->middleware('auth')->name('user_activity_logs');

// User roles and permissions
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});

//  Delete
Route::get('permission_delete/{id}', [App\Http\Controllers\PermissionController::class, 'destroy'])->middleware('auth');
Route::get('role_delete/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->middleware('auth');
Route::get('asset_delete/{id}', [App\Http\Controllers\AssetController::class, 'destroy'])->middleware('auth');
Route::get('report_delete/{id}', [App\Http\Controllers\ReportController::class, 'destroy'])->middleware('auth');
Route::get('user_delete/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->middleware('auth');
Route::get('activity_log_delete/{id}', [App\Http\Controllers\ActivityLogController::class, 'destroy'])->middleware('auth');
Route::get('user_activity_log_delete/{id}', [App\Http\Controllers\UserActivityLogController::class, 'destroy'])->middleware('auth');

// Export
Route::get('userexport', [App\Http\Controllers\UserController::class, 'export'])->middleware('auth')->name('userexport');
Route::get('assetexport', [App\Http\Controllers\AssetController::class, 'export'])->middleware('auth')->name('assetexport');
Route::get('reportexport', [App\Http\Controllers\ReportController::class, 'export'])->middleware('auth')->name('reportexport');



