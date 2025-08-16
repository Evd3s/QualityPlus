@extends('layouts.app')

@section('title', $empresa->nome)

@section('content')
<link rel="stylesheet" href="{{ asset('css/EpSobre.css') }}">

<header class="header-custom">
    <div class="logo">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/Qualityplus.png') }}" alt="QualityPlus Logo" style="height: 40px;">
        </a>
    </div>
    <div class="profile-section">
        <a href="{{ route('perfil') }}">
            <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) . '?t=' . uniqid() : asset('images/Perfil.png') }}"
                 alt="Perfil"
                 class="header-profile-image"
                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
        </a>
    </div>
</header>

<section class="sobre-content" style="padding: 40px 20px;">
    <div class="container" style="max-width: 960px; margin: 0 auto;">

        @if(session('success'))
            <div class="alert alert-success" style="max-width: 700px; margin: 0 auto 20px auto; padding: 12px; background-color: #d4edda; border-radius: 6px; color: #155724;">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-center mb-4" style="font-size: 32px; font-weight: bold;">Sobre {{ $empresa->nome }}</h1>

        <div class="row" style="display: flex; flex-wrap: wrap; gap: 40px;">
            <div class="col-md-6" style="flex: 1;">
                <div class="empresa-logo text-center">
                    <img src="{{ asset('storage/' . $empresa->imagem) }}" alt="{{ $empresa->nome }}" class="img-fluid rounded shadow" style="max-width: 220px; width: 100%;">
                </div>
                <h2 class="mt-3 text-center" style="font-size: 24px;">{{ $empresa->nome }}</h2>
            </div>

            <div class="col-md-6" style="flex: 1;">
                <div class="empresa-detalhes bg-light p-4 rounded shadow-sm" style="background-color: #f9f9f9;">
                    <h4><strong>CNPJ:</strong> {{ $empresa->cnpj }}</h4>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="sobre-empresa bg-light p-4 rounded shadow-sm" style="background-color: #f9f9f9;">
                    <h3>Sobre a Empresa</h3>
                    <p style="white-space: pre-line;">{{ $empresa->sobre }}</p>
                </div>
            </div>
        </div>

        @auth
        <div class="text-center mt-4">
            <button id="editar-btn" class="btn-editar">Editar Informações</button>
            <button id="cadastrar-produto-btn" class="btn-editar" style="margin-left: 15px;">Cadastrar Produto</button>
        </div>

        <!-- Modal editar empresa -->
        <div id="editar-container" class="modal" style="display: none;">
            <div class="modal-content">
                <span id="fechar-btn" class="fechar">&times;</span>
                <h3>Editar Informações da Empresa</h3>

                <form action="{{ route('empresa.update', $empresa->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="nome">Nome da Empresa</label>
                        <input type="text" id="nome" name="nome" value="{{ old('nome', $empresa->nome) }}" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="cnpj">CNPJ</label>
                        <input type="text" id="cnpj" name="cnpj" value="{{ old('cnpj', $empresa->cnpj) }}" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="sobre">Sobre a Empresa</label>
                        <textarea id="sobre" name="sobre" rows="5" class="form-control" required>{{ old('sobre', $empresa->sobre) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="imagem">Imagem da Empresa (deixe vazio para manter a atual)</label>
                        <input type="file" id="imagem" name="imagem" accept="image/*" class="form-control-file">
                    </div>

                    <div style="margin-top: 15px;">
                        <button type="submit" class="btn-editar">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal cadastrar produto -->
        <div id="cadastrar-produto-container" class="modal" style="display: none;">
            <div class="modal-content">
                <span id="fechar-cadastrar-produto-btn" class="fechar">&times;</span>
                <h3>Cadastrar Novo Produto</h3>

                <form action="{{ route('produto.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">

                    <div class="form-group">
                        <label for="nome-produto">Nome do Produto</label>
                        <input type="text" id="nome-produto" name="nome" value="{{ old('nome') }}" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="preco-produto">Preço</label>
                        <input type="number" step="0.01" id="preco-produto" name="preco" value="{{ old('preco') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="quantidade-produto">Quantidade</label>
                        <input type="number" id="quantidade-produto" name="quantidade" value="{{ old('quantidade') }}" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="categoria-produto">Categoria</label>
                        <input type="text" id="categoria-produto" name="categoria" value="{{ old('categoria') }}" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="descricao-produto">Descrição</label>
                        <textarea id="descricao-produto" name="descricao" rows="4" required class="form-control">{{ old('descricao') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="imagem-produto">Imagem</label>
                        <input type="file" id="imagem-produto" name="imagem" accept="image/*" required class="form-control-file">
                    </div>

                    <div style="margin-top: 15px;">
                        <button type="submit" class="btn-editar">Cadastrar Produto</button>
                    </div>
                </form>
            </div>
        </div>
        @endauth

        @if($produtos->count())
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="text-center mb-4" style="font-size: 28px; font-weight: bold;">Produtos da Empresa</h3>

                <div class="d-flex flex-wrap justify-content-center gap-4">
                    @foreach($produtos as $produto)
                    <div class="card-produto" style="width: 260px; background: white; border-radius: 15px; box-shadow: 0 0 8px rgba(0,0,0,0.08); overflow: hidden; padding: 16px; transition: 0.3s;">
                        <img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}" class="card-produto-img" style="width: 100%; height: 160px; object-fit: cover; border-radius: 10px; margin-bottom: 10px;">
                        <h4 class="card-produto-titulo" style="font-size: 18px; font-weight: bold; text-align: center;">{{ $produto->nome }}</h4>
                        @if($produto->preco)
                        <p class="card-produto-preco" style="color: #1e7e34; font-weight: bold; margin: 5px 0; text-align: center;">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                        @endif
                        <p class="card-produto-quantidade" style="font-size: 14px; text-align: center; color: #555; margin-bottom: 10px;">
                            Quantidade disponível: {{ $produto->quantidade }}
                        </p>
                        <p class="card-produto-categoria" style="font-size: 14px; text-align: center; color: #888; margin-bottom: 10px;">
                            Categoria: {{ $produto->categoria }}
                        </p>
                        <p class="card-produto-desc" style="font-size: 14px; text-align: center; margin-bottom: 10px; color: #555;">{{ \Illuminate\Support\Str::limit($produto->descricao, 80) }}</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('produto.show', $produto->id) }}" class="btn-custom" style="background-color: #3490dc; color: white; padding: 6px 12px; border-radius: 8px; text-decoration: none; font-weight: 500;">Ver</a>

                            <!-- Botão editar produto abre modal -->
                            <button class="btn-custom btn-editar-produto" 
                                    style="background-color: #ffc107; color: black; padding: 6px 12px; border-radius: 8px; font-weight: 500; border: none;"
                                    data-produto-id="{{ $produto->id }}">
                                Editar
                            </button>

                            <form action="{{ route('produto.destroy', $produto->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-custom" style="background-color: #dc3545; color: white; padding: 6px 12px; border-radius: 8px; font-weight: 500; border: none;">Excluir</button>
                            </form>
                        </div>
                    </div>

                    <!-- Modal editar produto (único para cada produto) -->
                    <div class="modal editar-produto-modal" id="editar-produto-modal-{{ $produto->id }}" style="display: none;">
                        <div class="modal-content">
                            <span class="fechar editar-produto-fechar" data-produto-id="{{ $produto->id }}">&times;</span>
                            <h3>Editar Produto: {{ $produto->nome }}</h3>

                            <form action="{{ route('produto.update', $produto->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">

                                <div class="form-group">
                                    <label for="nome-{{ $produto->id }}">Nome</label>
                                    <input type="text" id="nome-{{ $produto->id }}" name="nome" value="{{ old('nome', $produto->nome) }}" required class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="preco-{{ $produto->id }}">Preço</label>
                                    <input type="number" step="0.01" id="preco-{{ $produto->id }}" name="preco" value="{{ old('preco', $produto->preco) }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="quantidade-{{ $produto->id }}">Quantidade</label>
                                    <input type="number" id="quantidade-{{ $produto->id }}" name="quantidade" value="{{ old('quantidade', $produto->quantidade) }}" required class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="categoria-{{ $produto->id }}">Categoria</label>
                                    <input type="text" id="categoria-{{ $produto->id }}" name="categoria" value="{{ old('categoria', $produto->categoria) }}" required class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="descricao-{{ $produto->id }}">Descrição</label>
                                    <textarea id="descricao-{{ $produto->id }}" name="descricao" rows="4" required class="form-control">{{ old('descricao', $produto->descricao) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="imagem-{{ $produto->id }}">Imagem (deixe vazio para manter a atual)</label>
                                    <input type="file" id="imagem-{{ $produto->id }}" name="imagem" accept="image/*" class="form-control-file">
                                </div>

                                <div style="margin-top: 15px;">
                                    <button type="submit" class="btn-editar">Salvar Alterações</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Modal editar empresa
        const editarBtn = document.getElementById('editar-btn');
        const editarContainer = document.getElementById('editar-container');
        const fecharBtn = document.getElementById('fechar-btn');

        if (editarBtn && editarContainer && fecharBtn) {
            editarBtn.addEventListener('click', () => {
                editarContainer.style.display = 'block';
            });

            fecharBtn.addEventListener('click', () => {
                editarContainer.style.display = 'none';
            });
        }

        // Modal cadastrar produto
        const cadastrarProdutoBtn = document.getElementById('cadastrar-produto-btn');
        const cadastrarProdutoContainer = document.getElementById('cadastrar-produto-container');
        const fecharCadastrarProdutoBtn = document.getElementById('fechar-cadastrar-produto-btn');

        if (cadastrarProdutoBtn && cadastrarProdutoContainer && fecharCadastrarProdutoBtn) {
            cadastrarProdutoBtn.addEventListener('click', () => {
                cadastrarProdutoContainer.style.display = 'block';
            });

            fecharCadastrarProdutoBtn.addEventListener('click', () => {
                cadastrarProdutoContainer.style.display = 'none';
            });
        }

        // Modais editar produto (para vários produtos)
        const btnsEditarProduto = document.querySelectorAll('.btn-editar-produto');
        btnsEditarProduto.forEach(btn => {
            btn.addEventListener('click', () => {
                const produtoId = btn.getAttribute('data-produto-id');
                const modal = document.getElementById('editar-produto-modal-' + produtoId);
                if (modal) modal.style.display = 'block';
            });
        });

        const btnsFecharProduto = document.querySelectorAll('.editar-produto-fechar');
        btnsFecharProduto.forEach(span => {
            span.addEventListener('click', () => {
                const produtoId = span.getAttribute('data-produto-id');
                const modal = document.getElementById('editar-produto-modal-' + produtoId);
                if (modal) modal.style.display = 'none';
            });
        });

        // Fechar modal clicando fora do conteúdo
        window.addEventListener('click', (e) => {
            document.querySelectorAll('.editar-produto-modal, #editar-container, #cadastrar-produto-container').forEach(modal => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    });
</script>

<style>
    /* Modal geral padrão */
    .modal {
        position: fixed;
        z-index: 1500;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
        display: none;
    }
    .modal .modal-content {
        background-color: #fff;
        margin: 60px auto;
        padding: 20px 30px;
        border-radius: 12px;
        width: 90%;
        max-width: 480px;
        position: relative;
    }
    .modal .fechar {
        position: absolute;
        right: 15px;
        top: 10px;
        font-size: 28px;
        font-weight: bold;
        color: #333;
        cursor: pointer;
    }
    .modal .fechar:hover {
        color: #dc3545;
    }
    .modal .form-group {
        margin-bottom: 12px;
    }
    .modal .form-control,
    .modal .form-control-file,
    .modal textarea {
        width: 100%;
        padding: 6px 8px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 14px;
    }
    .btn-editar {
        background-color: #ffc107;
        border: none;
        padding: 10px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        color: black;
        transition: background-color 0.3s ease;
    }
    .btn-editar:hover {
        background-color: #e0a800;
    }
</style>

@endsection
