<?php

declare(strict_types=1);

use App\Http\Controllers\Api\BuyRequestController;
use App\Http\Controllers\Api\BuyRequestManagerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductManagerController;
use App\Http\Controllers\Api\User\Auth\AuthController;
use App\Http\Controllers\Api\User\Auth\RegisterController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\User\MasterDataController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\User\AccountController;
use Illuminate\Routing\Router;

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



// guest
Route::group(['middleware' => ['guest']], function (Router $router) {
    $router->post('/auth/prepare-login', [AuthController::class, 'checkPhoneExists'])->name('checkPhoneExists'); //ok
    $router->post('/auth/login', [AuthController::class, 'login'])->name('login'); //ok
    $router->post('/auth/register', [RegisterController::class, 'register'])->name('register'); //ok
    $router->post('/auth/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword'); //ok
    $router->post('/auth/register/otp', [RegisterController::class, 'prepareRegister'])->name('prepareRegister'); //ok
    $router->post('/auth/reset-password/otp', [RegisterController::class, 'prepareForgetPassword'])->name('prepareForgetPassword'); //ok


    $router->name('master_data.')
        ->prefix('master-data')
        ->group(function (Router $router) {
            $router->get('/categories', [MasterDataController::class, 'categories'])->name('categories'); //ok
        });
});

// auth
Route::group(['middleware' => ['auth:api']], function (Router $router) {
    $router->name('me.')
        ->prefix('me')
        ->group(function (Router $router) {
            $router->get('/', [AuthController::class, 'me'])->name('me'); //ok
            $router->post('/change-password', [AccountController::class, 'updatePassword'])->name('updatePassword'); //ok
            $router->post('/update', [AccountController::class, 'updateUserProfile'])->name('updateUserProfile'); //ok
        });

    $router->name('user.')
        ->prefix('user')
        ->group(function (Router $router) {
            $router->post('/{id}/follow', [UserController::class, 'follow'])->name('follow'); //ok
        });

    $router->name('product.')
        ->prefix('product')
        ->group(function (Router $router) {
            $router->get('/', [ProductController::class, 'index'])->name('index'); //ok
            $router->get('/hot', [ProductController::class, 'hotProductList'])->name('hotProductList'); //ok
            $router->get('/favorite', [ProductController::class, 'favoriteList'])->name('favoriteList');
            $router->get('/{id}', [ProductController::class, 'show'])->name('show'); //ok
            $router->post('/{id}/favorite', [ProductController::class, 'favorite'])->name('favorite'); //ok
        });
    $router->get('/search-recent', [ProductController::class, 'searchRecent'])->name('searchRecent'); //ok

    $router->name('product_manager.')
        ->prefix('product-manager')
        ->group(function (Router $router) {
            $router->get('/', [ProductManagerController::class, 'index'])->name('index'); // ok
            $router->post('/', [ProductManagerController::class, 'store'])->name('store'); //ok
            $router->post('/{id}', [ProductManagerController::class, 'update'])->name('update'); //ok
            $router->get('/{id}', [ProductManagerController::class, 'show'])->name('show'); //ok
            $router->post('/{id}/delete', [ProductManagerController::class, 'delete'])->name('delete'); //ok
        });
    $router->name('buy_request_manager..')
        ->prefix('buy-request-manager')
        ->group(function (Router $router) {
            $router->get('/', [BuyRequestManagerController::class, 'index'])->name('index'); //ok
            $router->post('/', [BuyRequestManagerController::class, 'store'])->name('store'); //ok
            $router->post('/{id}', [BuyRequestManagerController::class, 'update'])->name('update'); //ok
            $router->get('/{id}', [BuyRequestManagerController::class, 'show'])->name('show'); // ok
            $router->post('/{id}/delete', [BuyRequestManagerController::class, 'delete'])->name('delete'); //ok
        });

    $router->name('buy_request')
        ->prefix('buy-request')
        ->group(function (Router $router) {
            $router->get('/favorite', [BuyRequestController::class, 'favoriteList'])->name('favoriteList');
            $router->get('/', [BuyRequestController::class, 'index'])->name('index'); //ok
            $router->get('/{id}', [BuyRequestController::class, 'show'])->name('show'); //ok
            $router->post('/{id}/favorite', [BuyRequestController::class, 'favorite'])->name('favorite'); //ok
        });

    // order
    $router->name('order.')
        ->prefix('order')
        ->group(function (Router $router) {
            $router->get('/', [OrderController::class, 'index'])->name('index');  //ok
            $router->get('/{id}', [OrderController::class, 'show'])->name('show'); //ok
            $router->post('/', [OrderController::class, 'store'])->name('store'); //ok
            $router->post('delete', [OrderController::class, 'delete'])->name('delete'); //ok
        });

    // chat
    $router->name('chat.')
        ->prefix('chat')
        ->group(function (Router $router) {
            $router->get('/', [ChatController::class, 'room'])->name('room'); //ok
            $router->get('/{id}/message', [ChatController::class, 'message'])->name('message');
            $router->post('/{id}/message', [ChatController::class, 'send'])->name('send');
        });
});
