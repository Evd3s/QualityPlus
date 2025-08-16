@extends('layouts.app')

@section('title', 'Criar Nova Empresa')

@section('content')
<div class="container dashboard-container">

    <!-- Cabeçalho -->
    <header class="header-custom d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/Qualityplus.png') }}" alt="QualityPlus Logo" class="profile-logo">
        </a>
        <div class="profile-logout d-flex align-items-center">
            <a href="{{ route('perfil') }}">
                <img src="{{ auth()->user()->profile_image 
                    ? asset('storage/' . auth()->user()->profile_image) . '?t=' . uniqid() 
                    : asset('images/Perfil.png') }}" 
                    alt="Mini Perfil" 
                    class="header-profile-image">
            </a>
            <form action="{{ route('logout') }}" method="POST" class="ms-3">
                @csrf
                <button type="submit" class="logout-btn btn btn-outline-dark btn-sm">
                    <i class="fa fa-sign-out me-1"></i> Sair
                </button>
            </form>
        </div>
    </header>

    <!-- Container principal -->
    <div class="empresa-wrapper d-flex flex-column flex-lg-row gap-4">

        <!-- Preview da empresa -->
        <div class="empresa-preview card p-4 flex-fill">
            <div class="logo-container">
                <img 
                    id="preview-img" 
                    src="" 
                    alt="Logo da Empresa"
                    style="display:none;"
                />
            </div>
            <h2 id="empresa-nome" class="fw-bold">Nome da Empresa</h2>
            <p id="empresa-detalhes" class="text-muted">Detalhes sobre a empresa...</p>
        </div>

        <!-- Formulário -->
        <div class="empresa-form card p-4 flex-fill">
            <h4 class="mb-3 fw-bold text-primary">Cadastro de Empresa</h4>

            <form action="{{ route('empresa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="nome" class="form-label">Nome da Empresa</label>
                    <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome') }}" required>
                    @error('nome')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="cnpj" class="form-label">CNPJ</label>
                    <input type="text" name="cnpj" id="cnpj" class="form-control" value="{{ old('cnpj') }}" required>
                    @error('cnpj')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="imagem" class="form-label">Imagem</label>
                    <input type="file" name="imagem" id="imagem" class="form-control" accept="image/*" onchange="previewImage(event)">
                    @error('imagem')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="sobre" class="form-label">Sobre</label>
                    <textarea name="sobre" id="sobre" class="form-control" rows="5" style="resize: none;" required>{{ old('sobre') }}</textarea>
                    @error('sobre')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Criar Empresa</button>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const output = document.getElementById('preview-img');
        const logoContainer = output.parentElement;
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(){
                output.src = reader.result;
                output.style.display = 'block';
                logoContainer.classList.remove('no-logo');
            };
            reader.readAsDataURL(file);
        } else {
            output.src = "";
            output.style.display = 'none';
            logoContainer.classList.add('no-logo');
        }
    }

    // Atualiza nome e descrição em tempo real
    document.getElementById('nome').addEventListener('input', function() {
        document.getElementById('empresa-nome').textContent = this.value || 'Nome da Empresa';
    });

    document.getElementById('sobre').addEventListener('input', function() {
        document.getElementById('empresa-detalhes').textContent = this.value || 'Detalhes sobre a empresa...';
    });

    // Inicializa placeholder para logo
    document.getElementById('preview-img').parentElement.classList.add('no-logo');
</script>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endpush
