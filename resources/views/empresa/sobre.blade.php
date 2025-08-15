@extends('layouts.app')

@section('title', $empresa->nome)

@section('content')
<link rel="stylesheet" href="{{ asset('css/EpSobre.css') }}">

<header class="profile-header">
    <div class="header-left">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/Qualityplus.png') }}" alt="QualityPlus Logo" class="profile-logo">
        </a>
    </div>

    <!-- Ícone de perfil -->
    <div class="profile-section">
        <a href="{{ route('perfil') }}">
            <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) . '?t=' . uniqid() : asset('images/Perfil.png') }}" 
                 alt="Mini Perfil" 
                 class="header-profile-image" 
                 id="header-profile-image">
        </a>
    </div>
</header>

    <section class="sobre-content py-5">
        <div class="container">
            <h1 class="text-center mb-4">Sobre {{ $empresa->nome }}</h1>

            <div class="row">
                <div class="col-md-6">
                    <div class="empresa-logo">
                        <img src="{{ asset('storage/' . $empresa->imagem) }}" alt="{{ $empresa->nome }}" class="img-fluid rounded shadow" style="max-width: 200px; width: 100%;">
                    </div>
                    <h2 class="mt-2">{{ $empresa->nome }}</h2>
                </div>

                <div class="col-md-6">
                    <div class="empresa-detalhes bg-light p-4 rounded shadow-sm">
                        <h4>CNPJ: {{ $empresa->cnpj }}</h4>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="sobre-empresa bg-light p-4 rounded shadow-sm">
                        <h3>Sobre a Empresa</h3>
                        <p>{{ $empresa->sobre }}</p>
                    </div>
                </div>
            </div>

            @auth
            <div class="text-center mt-4">
                <button id="editar-btn" class="btn-editar">Editar Informações</button>
            </div>

            <div id="editar-container" class="editar-container">
                <div class="editar-box">
                    <button id="fechar-btn" class="btn-fechar">&times;</button>
                    <h3>Editar Empresa</h3>
                    <form action="{{ route('empresa.update', $empresa->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="logo">Logo da Empresa</label>
                            <input type="file" name="imagem" class="form-control" id="logo">
                        </div>

                        <div class="form-group mt-3">
                            <label for="cnpj">CNPJ</label>
                            <input type="text" name="cnpj" class="form-control" id="cnpj" value="{{ $empresa->cnpj }}">
                        </div>

                        <div class="form-group mt-3">
                            <label for="sobre">Sobre a Empresa</label>
                            <textarea name="sobre" class="form-control" id="sobre" rows="4">{{ $empresa->sobre }}</textarea>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn-salvar">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </section>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const editarBtn = document.getElementById('editar-btn');
        const editarContainer = document.getElementById('editar-container');
        const fecharBtn = document.getElementById('fechar-btn');

        // Controle de abrir e fechar o editor
        if (editarBtn) {
            editarBtn.addEventListener('click', function() {
                editarContainer.classList.add('mostrar');
            });
        }

        if (fecharBtn) {
            fecharBtn.addEventListener('click', function() {
                editarContainer.classList.remove('mostrar');
            });
        }
    });
</script>

@endsection