<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SampahController;
use App\Models\Sampah;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/sampah',[SampahController::class,'index']);
Route::store('/sampah/store',[SampahController::class,'store_trash'])->name("store_trash");
Route::get('/generate-token',[SampahController::class,'generateToken']);
Route::get('/sampah/{id}', [SampahController::class, 'show']);
Route::patch('/sampah/update/{id}',[SampahController::class, 'update']);
Route::delete('/sampah/delete/{id}',[SampahController::class, 'destroy']);
Route::get('/sampah/show/trash', [SampahController::class, 'trash']);
Route::get('/sampah/trash/restore/{id}', [SampahController::class, 'restore']);
Route::get('/sampah/trash/delete/permanent/{id}', [SampahController::class, 'permanenDelete']);
