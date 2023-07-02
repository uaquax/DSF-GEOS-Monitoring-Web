<?php

use App\Http\Controllers\FilesController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect("/", "/files")->middleware("webOwner");
Route::resource("/files", FilesController::class)->middleware("webOwner");
Route::resource('/login', LoginController::class);