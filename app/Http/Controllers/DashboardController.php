<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Produto;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Se a URL tiver ?categoria=, usa ela; senão, usa 'Alimentos' como padrão
        $categoria = $request->query('categoria', 'Alimentos');

        $empresas = Empresa::where('status', true)->get();
        $categorias = Produto::select('categoria')->distinct()->pluck('categoria');

        // Busca produtos filtrados pela categoria (padrão ou informada)
        $produtosFiltrados = Produto::where('categoria', $categoria)->get();

        return view('dashboard', compact('empresas', 'categorias', 'produtosFiltrados', 'categoria'));
    }
}
