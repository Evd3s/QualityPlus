<?php

namespace App\Http\Controllers;

use App\Models\Empresa; 
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        
        $empresas = Empresa::where('status', true)->get();

        
        $categorias = [
            'Tecnologia' => Empresa::where('categoria', 'Tecnologia')->get(),
            'Saúde' => Empresa::where('categoria', 'Saúde')->get(),
            
        ];

       
        return view('dashboard', compact('empresas', 'categorias'));
    }
}
