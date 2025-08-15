<?php

namespace App\Http\Controllers;

use App\Models\Empresa; // Certifique-se de importar a classe Empresa
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Pegando as empresas ativas
        $empresas = Empresa::where('status', true)->get(); // Retorna uma coleção de objetos Empresa
        
        // Retorna a view 'dashboard' passando as empresas para a view
        return view('dashboard', compact('empresas'));
    }
}
