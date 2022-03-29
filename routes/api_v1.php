<?php

use Core\Application\Controllers\V1\ExampleController;
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

Route::group(['prefix' => 'example'], function () {
    Route::options('options', [ExampleController::class, 'options'])->middleware('cors');
    Route::match('HEAD', 'options', [ExampleController::class, 'head']);
    Route::get('get', [ExampleController::class, 'all']);
    Route::get('get/{id}', [ExampleController::class, 'get']);
    Route::post('post', [ExampleController::class, 'post']);
    Route::put('put', [ExampleController::class, 'put']);
    Route::patch('patch', [ExampleController::class, 'patch']);
    Route::delete('delete', [ExampleController::class, 'delete']);
});
