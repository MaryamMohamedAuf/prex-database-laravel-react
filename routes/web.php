<?php

use App\Http\Controllers\CohortController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route::resource('cohorts', CohortController::class);

 Route::get('/cohorts/index', [CohortController::class, 'index'])->name('cohorts.index');
 Route::post('cohorts/create', [CohortController::class, 'create'])->name('cohorts.create');


 //Route::post('/register', [CohortController::class, 'store'])->name('RegisteredUser.store');

//Route::post('/index', [CohortController::class, 'store'])->name('cohorts.index');

// Route::get('/', [CohortController::class, 'edit']);
// Route::get('/', [CohortController::class, 'update']);
// Route::get('/', [CohortController::class, 'destroy']);

// Route::get('cohorts', [CohortController::class, 'index']);
// Route::post('cohorts', [CohortController::class, 'store']);

Route::get('/set-cohort/{id}', function ($id) {
    session(['cohort_id' => $id]);
    return response()->json(['message' => 'Cohort ID set in session', 'cohort_id' => $id]);
});

require __DIR__.'/auth.php';
