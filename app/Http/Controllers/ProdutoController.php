<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    // Armazena um novo produto
    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nome' => 'required|string|max:255',
            'preco' => 'nullable|numeric|min:0',
            'quantidade' => 'required|integer|min:0',
            'categoria' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagem' => 'required|image|max:2048',
        ]);

        $path = $request->file('imagem')->store('produtos', 'public');

        Produto::create([
            'empresa_id' => $request->empresa_id,
            'nome' => $request->nome,
            'preco' => $request->preco,
            'quantidade' => $request->quantidade,
            'categoria' => $request->categoria,
            'descricao' => $request->descricao,
            'imagem' => $path,
        ]);

        return redirect()->back()->with('success', 'Produto cadastrado com sucesso!');
    }

    // Exibe detalhes de um produto
    public function show($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produto.show', compact('produto'));
    }

    // Lista produtos por categoria (exibido em uma página separada)
    public function porCategoria($categoria)
    {
        $produtos = Produto::where('categoria', $categoria)->get();

        return view('produto.por_categoria', compact('produtos', 'categoria'));
    }

    // Mostra o formulário para editar um produto (se for página separada)
    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produto.edit', compact('produto'));
    }

    // Atualiza o produto no banco
    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'nullable|numeric|min:0',
            'quantidade' => 'required|integer|min:0',
            'categoria' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagem' => 'nullable|image|max:2048',
        ]);

        $produto->nome = $request->nome;
        $produto->preco = $request->preco;
        $produto->quantidade = $request->quantidade;
        $produto->categoria = $request->categoria;
        $produto->descricao = $request->descricao;

        if ($request->hasFile('imagem')) {
            // Deleta imagem antiga se existir
            if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
                Storage::disk('public')->delete($produto->imagem);
            }
            $path = $request->file('imagem')->store('produtos', 'public');
            $produto->imagem = $path;
        }

        $produto->save();

        return redirect()->route('empresa.sobre', $produto->empresa_id)->with('success', 'Produto atualizado com sucesso!');
    }

    // Exclui um produto
    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);

        // Deleta imagem do storage
        if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
            Storage::disk('public')->delete($produto->imagem);
        }

        $produto->delete();

        return redirect()->back()->with('success', 'Produto excluído com sucesso!');
    }
}
