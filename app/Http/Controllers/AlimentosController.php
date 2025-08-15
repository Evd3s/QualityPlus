<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlimentosController extends Controller
{
    /**
     * Exibe os detalhes da maçã
     *
     * @return \Illuminate\View\View
     */
    public function mostrarMaca()
    {
        // Aqui poderíamos buscar dados da maçã de um banco de dados
        // Por enquanto estamos usando dados estáticos
        $maca = [
            'nome' => 'Maçã',
            'categoria' => 'Fruta',
            'calorias' => '52 calorias',
            'preco_medio' => 'R$ 9,98 por Kg.',
        ];

        $lojas = [
            [
                'nome' => 'Mix Mateus',
                'imagem' => 'mix-mateus.png',
                'preco' => 'R$ 2,99',
            ],
            [
                'nome' => 'Americanas',
                'imagem' => 'americanas.png',
                'preco' => 'R$ 3,50',
            ],
            [
                'nome' => 'Super Mercado',
                'imagem' => 'store-placeholder.png',
                'preco' => 'R$ 3,29',
            ],
        ];

        return view('maca-detalhes', compact('maca', 'lojas'));
    }

    /**
     * Lista todos os alimentos disponíveis
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Futuramente, listar todos os alimentos do banco de dados
        $alimentos = [
            ['nome' => 'Maçã', 'imagem' => 'maca.png', 'categoria' => 'Fruta'],
            // Outros alimentos poderiam ser listados aqui
        ];

        return view('alimentos.index', compact('alimentos'));
    }
}