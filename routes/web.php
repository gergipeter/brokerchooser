<?php

use App\Http\Controllers\AbTestController;
use App\Http\Controllers\AbVariantController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function() {
    return view('landing');
})->name('landing');

Route::group(['prefix' => 'ab-test'], function () {
    Route::get('/create', [AbTestController::class, 'createTest'])->name('create-test.get');
    Route::post('/create', [AbTestController::class, 'createTest'])->name('create-test.post');
    Route::post('/start/{id}', [AbTestController::class, 'startTest'])->name('start-test');
    Route::post('/stop/{id}', [AbTestController::class, 'stopTest'])->name('stop-test');
    Route::get('/list', [AbTestController::class, 'listAllTests'])->name('list-all-tests');
});

Route::get('/list-all-variants', [AbVariantController::class, 'listAllVariants'])->name('list-all-variants');

Route::get('/chart-data', [ChartController::class, 'getChartData'])->name('get-chart-data');

Route::post('/track-mouse', [EventController::class, 'trackMouse']);
