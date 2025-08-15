<?php

namespace App\Http\Controllers;

use App\Models\Empresa; // Certifique-se de importar o modelo Empresa
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Pegue as empresas do banco com status 'true'
        $empresas = Empresa::where('status', true)->get();

        // Exemplo simples de categorias (substitua conforme a estrutura real do seu banco)
        $categorias = [
            'Tecnologia' => Empresa::where('categoria', 'Tecnologia')->get(),
            'Saúde' => Empresa::where('categoria', 'Saúde')->get(),
            // Adicione outras categorias conforme necessário
        ];

        // Retorna a view passando as variáveis 'empresas' e 'categorias'
        return view('dashboard', compact('empresas', 'categorias'));
    }
}
