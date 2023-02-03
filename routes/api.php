<?php

use App\Http\Controllers\AttendancesController;
use App\Http\Controllers\CourseStudentsController;
use App\Http\Controllers\StudentsController;
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

Route::prefix('v1')->group(function() {
    Route::get('students', [StudentsController::class, 'index']);
    Route::get('courses/{course}/students', CourseStudentsController::class);
    Route::get('courses/{course}/attendances', [AttendancesController::class, 'index']);
    Route::post('courses/{course}/attendances', [AttendancesController::class, 'store']);
});