@extends('layouts.app')

@section('title', 'Criar Nova Empresa')

@section('content')
<div class="container dashboard-container">
    <!-- Cabeçalho com navegação -->
    <header class="d-flex justify-content-between align-items-center header-custom">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/Qualityplus.png') }}" alt="QualityPlus Logo" class="profile-logo">
        </a>

        <!-- Ícone de perfil e logout -->
        <div class="profile-logout d-flex align-items-center">
        <a href="{{ route('perfil') }}">
        <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) . '?t=' . uniqid() : asset('images/Perfil.png') }}" 
             alt="Mini Perfil" 
             class="header-profile-image" 
             id="header-profile-image">
        </a>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn btn btn-link text-dark">
                    <i class="fa fa-sign-out"></i> Sair
                </button>
            </form>
            </div>
    </header>

    <!-- Formulário para criar a empresa -->
    <div class="empresa-container">
        <div class="empresa-logo">
            <img src="{{ asset('storage/empresas/default.png') }}" id="preview-img" alt="Logo da Empresa" style="display: none;">
        </div>
        <div class="empresa-info">
            <h2 id="empresa-nome">{{ old('nome', 'Nome da Empresa') }}</h2>
            <p id="empresa-detalhes">{{ old('sobre', 'Detalhes sobre a empresa...') }}</p>
        </div>

        <form action="{{ route('empresa.store') }}" method="POST" enctype="multipart/form-data" class="empresa-form">
            @csrf

            <div class="form-group">
                <label for="nome">Nome da Empresa</label>
                <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required>
                @error('nome')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="cnpj">CNPJ</label>
                <input type="text" name="cnpj" id="cnpj" value="{{ old('cnpj') }}" required>
                @error('cnpj')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="imagem">Imagem</label>
                <input type="file" name="imagem" id="imagem" accept="image/*" onchange="previewImage(event)">
                <div class="image-preview">
                    <img id="preview-img" src="#" alt="Pré-visualização" style="display: none;">
                </div>
                @error('imagem')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="sobre">Sobre</label>
                <textarea name="sobre" id="sobre" required>{{ old('sobre') }}</textarea>
                @error('sobre')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-create">Criar Empresa</button>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview-img');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Atualizar o cabeçalho dinamicamente com o nome e a descrição
    document.getElementById('nome').addEventListener('input', function() {
        document.getElementById('empresa-nome').textContent = this.value || 'Nome da Empresa';
    });

    document.getElementById('sobre').addEventListener('input', function() {
        document.getElementById('empresa-detalhes').textContent = this.value || 'Detalhes sobre a empresa...';
    });
</script>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endpush
