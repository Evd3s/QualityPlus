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
        // Verifica se o CNPJ já existe
        $cnpjExistente = Empresa::where('cnpj', $request->cnpj)->first();

        if ($cnpjExistente) {
            return redirect()->back()->with('error', 'CNPJ já cadastrado.');
        }

        // Validação dos campos
        $request->validate([
            'nome'   => 'required|string|max:255',
            'cnpj'   => 'required|string|max:18|unique:empresas,cnpj',  // Verifica se o CNPJ é único
            'imagem' => 'required|image|max:2048',
            'sobre'  => 'required|string',
        ]);

        // Salvando a imagem no storage
        $imagemPath = $request->file('imagem')->store('empresas', 'public');

        // Criando a empresa no banco de dados
        Empresa::create([
            'nome'   => $request->nome,
            'cnpj'   => $request->cnpj,
            'imagem' => $imagemPath,
            'sobre'  => $request->sobre,
        ]);

        // ✅ Redirecionando para a dashboard com a mensagem de sucesso
        return redirect()->route('dashboard')->with('success', 'Empresa criada com sucesso!');
    }

    public function sobre($id)
    {
        $empresa = Empresa::findOrFail($id);
        return view('empresa.sobre', compact('empresa'));
    }

    // Método para exibir o formulário de edição
    public function edit($id)
    {
        $empresa = Empresa::findOrFail($id);
        return view('empresa.edit', compact('empresa'));
    }

    // Método para atualizar as informações da empresa
    public function update(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);

        // Validação dos dados de atualização
        $request->validate([
            'imagem' => 'nullable|image|max:2048',
            'cnpj'   => 'required|string|max:18|unique:empresas,cnpj,' . $empresa->id,  // Verifica o CNPJ único, mas exceto para a empresa em edição
            'sobre'  => 'nullable|string',
        ]);

        // Se uma nova imagem foi enviada, faça o upload
        if ($request->hasFile('imagem')) {
            // Remover a imagem antiga, se necessário
            if ($empresa->imagem && \Storage::disk('public')->exists($empresa->imagem)) {
                \Storage::disk('public')->delete($empresa->imagem);
            }
            $imagemPath = $request->file('imagem')->store('empresas', 'public');
            $empresa->imagem = $imagemPath;
        }

        // Atualiza os outros campos
        $empresa->cnpj = $request->input('cnpj');
        $empresa->sobre = $request->input('sobre');

        // Salva as alterações no banco de dados
        $empresa->save();

        // Redireciona com uma mensagem de sucesso
        return redirect()->route('empresa.sobre', $empresa->id)->with('success', 'Informações da empresa atualizadas com sucesso!');
    }
}
