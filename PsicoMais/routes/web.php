<?php

use App\Http\Controllers\ConsultController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Models\Consult;


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
    $consults = Consult::all();
    $sortedConsults = $consults->sortBy(function ($consult) {
        return $consult->date . ' ' . $consult->time;
    });
    $users = User::all();
    return view('dashboard', compact('sortedConsults', 'users'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::get('/consult/create', [ConsultController::class, 'create'])->name('consult.create');
Route::get('/consult/display', [ConsultController::class, 'display'])->name('consult.display');
Route::get('/consult/list', [ConsultController::class, 'list'])->name('consult.list');
Route::get('/consult/history', [ConsultController::class, 'history'])->name('consult.history');

Route::post('/consult/create', [ConsultController::class, 'create'])->name('consult.create');
Route::post('/consult', [ConsultController::class, 'store'])->name('consult.store');
Route::post('/consult/mark/{id}', [ConsultController::class, 'mark'])->name('consult.mark');
Route::post('/consult/cancel/{id}', [ConsultController::class, 'cancel'])->name('consult.cancel');
Route::post('/consult/destroy/{id}', [ConsultController::class, 'destroy'])->name('consult.destroy');

require __DIR__ . '/auth.php';