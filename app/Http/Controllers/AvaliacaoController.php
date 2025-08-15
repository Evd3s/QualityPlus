<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    public function avaliarItem(Request $request)
    {
        // Validação dos dados recebidos
        $validated = $request->validate([
            'item_id' => 'required|integer|exists:items,id',  // Verifique se o item existe
            'rating' => 'required|integer|min:1|max:5',       // Avaliação de 1 a 5
        ]);

        // Salva ou atualiza a avaliação
        $avaliacao = Avaliacao::updateOrCreate(
            ['item_id' => $validated['item_id']],
            ['rating' => $validated['rating']]
        );

        // Retorna resposta JSON com sucesso
        return response()->json(['message' => 'Avaliação salva com sucesso!']);
    }
}
