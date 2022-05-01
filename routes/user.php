<?php

use App\Http\Controllers\User\BannerController;
use App\Http\Controllers\User\CarController;
use App\Http\Controllers\User\CarFavoriteController;
use App\Http\Controllers\User\CarManagerController;
use App\Http\Controllers\User\CarMediaController;
use App\Http\Controllers\User\ChatController;
use App\Http\Controllers\User\ContactUsController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\PageStaticController;
use App\Http\Controllers\User\OrderController;
use Illuminate\Routing\Router;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\SearchHistoryController;
use App\Http\Controllers\User\AccountController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::name('banner.')->prefix('banner')->group(function () {
    Route::get('{id}', [BannerController::class, 'show'])->name('show');
});
Route::prefix('car')->group(function () {
    Route::get('/', [CarController::class, 'index'])->name('car.index');
    Route::get('detail/{id}', [CarController::class, 'show'])->name('car.show');
});

Route::get('transaction-law', [PageStaticController::class, 'transactionLaw'])->name('transaction_law');
Route::get('about', [PageStaticController::class, 'about'])->name('about');
Route::get('privacy-policy', [PageStaticController::class, 'privacyPolicy'])->name('privacy_policy');
Route::get('terms-of-service', [PageStaticController::class, 'termsOfService'])->name('terms_of_service');
Route::get('label-convention', [PageStaticController::class, 'labelConvention'])->name('label_convention');

Route::group(['middleware' => ['guest']], function () {
    Auth::routes(['logout' => false]);
});

Route::group(['middleware' => ['auth:user']], function (Router $router) {
    $router->any('logout', 'Auth\LoginController@logout')->name('logout');

    // my page
    $router->name('account.')
        ->prefix('account')
        ->group(function (Router $router) {
            $router->get('', [AccountController::class, 'index'])->name('index');
            $router->get('info', [AccountController::class, 'show'])->name('show');
            $router->get('edit-password', [AccountController::class, 'editPassword'])->name('edit_password');
            $router->post('update-password', [AccountController::class, 'updatePassword'])->name('update_password');
       });

    // order
    $router->name('order.')
        ->prefix('order')
        ->group(function (Router $router) {
            $router->get('/', [OrderController::class, 'index'])->name('index');
            $router->get('detail/{id}', [OrderController::class, 'detail'])->name('detail');

            $router->get('request/{carId?}', [OrderController::class, 'requestForm'])->name('request_form');
            $router->post('request', [OrderController::class, 'request'])->name('request');
            $router->post('update-status/{id}', [OrderController::class, 'updateStatus'])->name('update_status');
            $router->get('delete/{id}', [OrderController::class, 'delete'])->name('delete');
            $router->get('buy', [OrderController::class, 'getListHumanBuy'])->name('buy');
            $router->get('buy/{id}', [OrderController::class, 'getDetailHumanBuy'])->name('buy_detail');
            $router->get('sell', [OrderController::class, 'getListHumanSell'])->name('sell');
            $router->get('sell/{id}', [OrderController::class, 'getDetailHumanSell'])->name('sell_detail');
        });

    // car-manager
    $router->name('car_manager.')
        ->prefix('car-manager')
        ->group(function (Router $router) {
            $router->get('/', [CarManagerController::class, 'index'])->name('index');
            $router->get('detail/{id}', [CarManagerController::class, 'show'])->name('show');
            $router->get('create', [CarManagerController::class, 'create'])->name('create');
            $router->post('store', [CarManagerController::class, 'store']);
            $router->get('edit/{id}', [CarManagerController::class, 'edit'])->name('edit');
            $router->post('update/{id}', [CarManagerController::class, 'update']);
            $router->post('delete/{id}', [CarManagerController::class, 'delete']);
            $router->post('release/{id}', [CarManagerController::class, 'release']);
            $router->post('request-public/{id}', [CarManagerController::class, 'requestPublic'])->name('request_public');
            $router->post('update-status/{id}', [CarManagerController::class, 'updateStatus'])->name('update_status');
        });
    // car-media
    $router->name('car_media.')
        ->prefix('car-media')
        ->group(function (Router $router) {
            $router->post('upload', [CarMediaController::class, 'upload']);
            $router->post('update-photo-position', [CarMediaController::class, 'updatePhotoPosition']);
        });

    // chat
    $router->name('chat.')
        ->prefix('chat')
        ->group(function (Router $router) {
            $router->get('/', [ChatController::class, 'index'])->name('index');
            $router->get('/room', [ChatController::class, 'room'])->name('room');
            $router->get('/room/{id}/message', [ChatController::class, 'message'])->name('message');
            $router->post('/room/{id}/message', [ChatController::class, 'send'])->name('send');
        });

    $router->name('car_favorite.')
        ->prefix('car-favorite')
        ->group(function (Router $router) {
            $router->get('/', [CarFavoriteController::class, 'index'])->name('index');
            $router->post('store', [CarFavoriteController::class, 'store']);
        });

    // search history
    $router->name('search_history.')
        ->prefix('search-history')
        ->group(function (Router $router) {
            $router->get('/', [SearchHistoryController::class, 'index'])->name('index');
            $router->post('delete/{id}', [SearchHistoryController::class, 'delete']);
        });

    // notification
    $router->name('notification.')
           ->prefix('notification')
           ->group(function (Router $router) {
               $router->get('/', [NotificationController::class, 'index'])->name('index');
               $router->get('/{id}', [NotificationController::class, 'show'])->name('show');
           });
});
Route::name('blog.')->prefix('blog')->group(function (Router $router) {
        $router->get('/', [PostController::class, 'index'])->name('index');
        $router->get('detail/{id}', [PostController::class, 'show'])->name('show');
    });

Route::prefix('contact')->group(function (){
    Route::get('/', [ContactUsController::class, 'index'])->name('contact.index');
    Route::post('request', [ContactUsController::class, 'request'])->name('contact.request');
});

