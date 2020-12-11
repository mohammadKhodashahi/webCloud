<?php

use App\Http\Controllers\Api\File;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUploadController;

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
    return view('welcome');
});

Route::group([
    'middleware' => ['auth:sanctum', 'verified'],
], function (Router $router) {
    $router->get('/dashboard', [FileUploadController::class, 'fileUpload'])->name('dashboard');
    $router->post('/dashboard', [FileUploadController::class, 'fileUploadPost'])->name('file.upload.post');

    $router->get('/download/file/{id}', [FileUploadController::class, 'fileDownload'])->name('file.download');

    $router->delete('/api/file/{id}',[File::class,'delete'])->name('api.file');
    $router->put('/api/file/{id}',[File::class,'update'])->name('api.file');
});




