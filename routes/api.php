<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CohortController;



//Route::resource('cohorts', CohortController::class);

Route::get('cohorts/index', [CohortController::class, 'index'])->name('cohorts.index');
Route::post('cohorts/create', [CohortController::class, 'store']);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   // return $request->user();
//});
