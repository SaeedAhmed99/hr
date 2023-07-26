<?php

use App\Http\Controllers\DesktopClientApiController;
use Illuminate\Http\Request;
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

Route::get('/dextop_login', [DesktopClientApiController::class, "dextop_login"]);

Route::get('/dextop_projects', [DesktopClientApiController::class, "dextop_projects"]);

Route::get('/dextop_time_tracker', [DesktopClientApiController::class, "dextop_time_tracker"]);

Route::get('/dextop_screenshot_duration', [DesktopClientApiController::class, "dextop_screenshot_duration"]);

Route::get('/dextop_time_tracker_stop', [DesktopClientApiController::class, "dextop_time_tracker_stop"]);

Route::post('/dextop_test_upload', [DesktopClientApiController::class, "dextop_test_upload"]);

Route::post('/dextop_no_ui_upload', [DesktopClientApiController::class, "dextop_no_ui_upload"]);
