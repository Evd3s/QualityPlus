<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Produto;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        
        $categoria = $request->query('categoria', 'Alimentos');

        $empresas = Empresa::where('status', true)->get();
        $categorias = Produto::select('categoria')->distinct()->pluck('categoria');

        
        $produtosFiltrados = Produto::where('categoria', $categoria)->get();

        return view('dashboard', compact('empresas', 'categorias', 'produtosFiltrados', 'categoria'));
    }
}
