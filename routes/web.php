<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapaLojasController;


Route::middleware(['auth'])->group(function () {
   
    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil');
    Route::post('/perfil/update', [ProfileController::class, 'update'])->name('perfil.update');
    Route::post('/perfil/update-role', [ProfileController::class, 'updateRole'])->name('perfil.updateRole');
    Route::post('/perfil/upgrade-role', [ProfileController::class, 'upgradeRole'])->name('perfil.upgrade-role');

   
    Route::get('/empresa/create', [EmpresaController::class, 'create'])->name('empresa.create');
    Route::post('/empresa', [EmpresaController::class, 'store'])->name('empresa.store');
    Route::get('/empresa/{id}/edit', [EmpresaController::class, 'edit'])->name('empresa.edit');
    Route::put('/empresa/{id}', [EmpresaController::class, 'update'])->name('empresa.update');

    
    Route::post('/produto', [ProdutoController::class, 'store'])->name('produto.store');
    Route::put('/produto/{id}', [ProdutoController::class, 'update'])->name('produto.update');
    Route::delete('/produto/{id}', [ProdutoController::class, 'destroy'])->name('produto.destroy');
    Route::get('/produto/{id}/edit', [ProdutoController::class, 'edit'])->name('produto.edit');

    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    
    Route::get('/lojas-mapa', [MapaLojasController::class, 'index'])->name('lojas-mapa');
});




Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/about', function () {
    return view('about');
})->name('about');


Route::get('/contact', function () {
    return view('contact');
})->name('contact');


Route::get('/produto/{id}', [ProdutoController::class, 'show'])->name('produto.show');


Route::get('/empresa/{id}/sobre', [EmpresaController::class, 'sobre'])->name('empresa.sobre');


Route::get('/produtos/categoria/{categoria}', [ProdutoController::class, 'porCategoria'])->name('produtos.por_categoria');


Auth::routes();


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
