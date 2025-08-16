<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function create()
    {
        return view('empresa.create');
    }

    public function store(Request $request)
    {
        $cnpjExistente = Empresa::where('cnpj', $request->cnpj)->first();

        if ($cnpjExistente) {
            return redirect()->back()->with('error', 'CNPJ já cadastrado.');
        }

        $request->validate([
            'nome'   => 'required|string|max:255',
            'cnpj'   => 'required|string|max:18|unique:empresas,cnpj',
            'imagem' => 'required|image|max:2048',
            'sobre'  => 'required|string',
        ]);

        $imagemPath = $request->file('imagem')->store('empresas', 'public');

        Empresa::create([
            'nome'   => $request->nome,
            'cnpj'   => $request->cnpj,
            'imagem' => $imagemPath,
            'sobre'  => $request->sobre,
        ]);

        return redirect()->route('dashboard')->with('success', 'Empresa criada com sucesso!');
    }

    public function sobre($id)
    {
        $empresa = Empresa::findOrFail($id);
        $produtos = $empresa->produtos()->get();

        return view('empresa.sobre', compact('empresa', 'produtos'));
    }

    public function edit($id)
    {
        $empresa = Empresa::findOrFail($id);
        return view('empresa.edit', compact('empresa'));
    }

    public function update(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);

        $request->validate([
            'imagem' => 'nullable|image|max:2048',
            'cnpj'   => 'required|string|max:18|unique:empresas,cnpj,' . $empresa->id,
            'sobre'  => 'nullable|string',
        ]);

        if ($request->hasFile('imagem')) {
            if ($empresa->imagem && \Storage::disk('public')->exists($empresa->imagem)) {
                \Storage::disk('public')->delete($empresa->imagem);
            }
            $imagemPath = $request->file('imagem')->store('empresas', 'public');
            $empresa->imagem = $imagemPath;
        }

        $empresa->cnpj = $request->input('cnpj');
        $empresa->sobre = $request->input('sobre', $empresa->sobre);

        $empresa->save();

        return redirect()->route('empresa.sobre', $empresa->id)->with('success', 'Informações da empresa atualizadas com sucesso!');
    }
}
