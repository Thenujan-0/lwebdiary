<?php

use App\Http\Controllers\DiaryController;
use App\Http\Controllers\DiaryEntryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;

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

Route::get('/', [HomeController::class,"index"])->name("index");
Route::post('/writeDiary', [DiaryController::class,"writeDiary"])->name("writeDiary");

Route::post("createFirstDiary",[HomeController::class,"createFirstDiary"]);

Route::get("/login",[LoginController::class,"login"])->name("login");
Route::get("/signup",[LoginController::class,"signup"])->name("signup");

Route::post("loginUser",[LoginController::class,"loginUser"]);
Route::post("registerUser",[LoginController::class,"registerUser"])->name("registerUser");

Route::resource("/diaryEntry",DiaryEntryController::class);
