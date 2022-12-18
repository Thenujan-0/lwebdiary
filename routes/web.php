<?php

use App\Http\Controllers\DiaryController;
use App\Http\Controllers\DiaryEntryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use Barryvdh\Debugbar\Facades\Debugbar;

// use Debugbar;

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
Route::get("/login",[LoginController::class,"login"])->name("login");
Route::get("/signup",[LoginController::class,"signup"])->name("signup");
Route::get("/logout",[LoginController::class,"logoutUser"]);

// Route::get("/test",function(){return view('includes.errorPopup');});

Route::post('/writeDiary', [DiaryController::class,"writeDiary"])->name("writeDiary");
Route::post("createFirstDiary",[HomeController::class,"createFirstDiary"]);
Route::post("createDiary",[DiaryController::class,"createDiary"]);

Route::post("loginUser",[LoginController::class,"loginUser"]);

Route::post("registerUser",[LoginController::class,"registerUser"])->name("registerUser");

Route::resource("/diaryEntry",DiaryEntryController::class);

Route::post("/exportDiary",[DiaryController::class,"exportDiary"]);
Route::post("/dateExists",[DiaryController::class,"dateExists"]);
Route::post("/editDiaryData",[DiaryController::class,"editDiaryData"]);
Route::post("/getEmptyDiaryNames",[DiaryController::class,"getEmptyDiaryNames"]);
Route::post("/importDiary",[DiaryController::class,"importDiary"]);
Route::post("/getDiaryDatas",[DiaryController::class,"getDiaryDatas"]);

Route::post("simple",[HomeController::class,"setScreenSize"]);