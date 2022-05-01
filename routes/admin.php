<?php

use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Routing\Router;

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

Route::group(['middleware' => ['guest:admin']], function (Router $router) {
    Auth::routes(['register' => false, 'reset' => false]);
});

Route::group([], function (Router $router) {
    $router->post('admin-password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    $router->get('admin-password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    $router->post('admin-password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
    $router->get('admin-password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    $router->post('/logout', [LoginController::class, 'logout'])->name('logout');

});

Route::group(['middleware' => ['auth:admin']], function (Router $router) {
    $router->get('/', [HomeController::class, 'index'])->name('dashboard');
});
