@extends('layouts.app')

@section('title', 'Editar Produto')

@section('content')
<div class="container" style="max-width: 600px; margin: 40px auto;">
    <h1>Editar Produto: {{ $produto->nome }}</h1>

    @if ($errors->any())
        <div style="background-color: #f8d7da; padding: 10px; border-radius: 6px; margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color: #721c24;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produto.update', $produto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ old('nome', $produto->nome) }}" required class="form-control mb-3">

        <label for="preco">Preço:</label>
        <input type="number" step="0.01" name="preco" id="preco" value="{{ old('preco', $produto->preco) }}" class="form-control mb-3">

        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" id="quantidade" value="{{ old('quantidade', $produto->quantidade) }}" required class="form-control mb-3">

        <label for="categoria">Categoria:</label>
        <input type="text" name="categoria" id="categoria" value="{{ old('categoria', $produto->categoria) }}" required class="form-control mb-3">

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" rows="4" required class="form-control mb-3">{{ old('descricao', $produto->descricao) }}</textarea>

        <label for="imagem">Imagem (deixe em branco para manter a atual):</label>
        <input type="file" name="imagem" id="imagem" class="form-control mb-3">

        <button type="submit" class="btn btn-primary">Atualizar Produto</button>
        <a href="{{ route('empresa.sobre', $produto->empresa_id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
