<?php

use App\Http\Controllers\ConsultsController1;
use App\Http\Controllers\ProfileController;
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/profissional/cadastro-disponibilidade', function () {
    if(Auth::user()->type == "Profissional"){
        return view('profissional.cadastroDisponibilidade');
    } else {
        return redirect()->route('dashboard')->with('msg', 'Acesso Negado!');
    }
})->name('cadastro-disponibilidade');

Route::post('/consult', [ConsultsController1::class, 'store'])->name('consult.store');

require __DIR__.'/auth.php';

