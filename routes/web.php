<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapaLojasController;
use App\Http\Controllers\AlimentosController;
use Illuminate\Support\Facades\Auth;

Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil');
    Route::post('/perfil/update', [ProfileController::class, 'update'])->name('perfil.update');
    Route::post('/perfil/update-role', [ProfileController::class, 'updateRole'])->name('perfil.updateRole');
});

// Página inicial (Home)
Route::get('/', function () {
    return view('home');  // Certifique-se de que o arquivo home.blade.php exista
})->name('home');

// Página Sobre (About)
Route::get('/about', function () {
    return view('about');  // Certifique-se de que a view 'about' exista
})->name('about');

// Página de Contato (Contact)
Route::get('/contact', function () {
    return view('contact');  // Certifique-se de que a view 'contact' exista
})->name('contact');

// Autenticação padrão do Laravel
Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/empresa/create', [EmpresaController::class, 'create'])->name('empresa.create');
    Route::post('/empresa', [EmpresaController::class, 'store'])->name('empresa.store');
    Route::get('/empresa/{id}/edit', [EmpresaController::class, 'edit'])->name('empresa.edit');  // Rota para exibir o formulário de edição
    Route::put('/empresa/{id}', [EmpresaController::class, 'update'])->name('empresa.update');  // Rota para atualizar a empresa
});

// Rotas de autenticação
// Substitua suas rotas existentes por estas:
Route::middleware(['security'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Mantenha as outras rotas como estão:
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::post('/avaliar-item', [AvaliacaoController::class, 'avaliarItem'])->middleware('auth')->name('avaliar-item');
Route::get('/empresa/{id}/sobre', [EmpresaController::class, 'sobre'])->name('empresa.sobre');
Route::get('/lojas-mapa', [MapaLojasController::class, 'index'])->middleware('auth')->name('lojas-mapa');
Route::get('/alimentos/maca', [AlimentosController::class, 'mostrarMaca'])->name('alimentos.maca');
Route::get('/alimentos', [App\Http\Controllers\AlimentosController::class, 'index'])->name('alimentos.index');
Route::post('/perfil/upgrade-role', [ProfileController::class, 'upgradeRole'])->name('perfil.upgrade-role');
