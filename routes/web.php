<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\TravelController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*route group*/
Route::middleware(['auth', 'verified'])
    ->name('user.')
    ->prefix('user')
    ->group(function () {

        // Rotta personalizzata per creare una tappa con il parametro {travel}
        Route::get('/travels/{travel}/stages/create', [StageController::class, 'create'])->name('stages.create');
        Route::post('/travels/{travel:slug}/stages', [StageController::class, 'store'])->name('stages.store');
        Route::resource('/travels', TravelController::class)->parameters(['travels' => 'travel:slug']);
        Route::resource('/stages', StageController::class)->only(['index', 'show', 'destroy'])->parameters(['stages' => 'stage:slug']);
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
