@extends('layouts.app')

@section('title', $produto->nome)

@section('content')
<link rel="stylesheet" href="{{ asset('css/EpProduto.css') }}">

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

<section class="produto-section">
    <div class="produto-container">
        
        <h1 class="produto-titulo">
            {{ $produto->nome }}
        </h1>

        <div class="produto-imagem-wrapper">
            <img 
                src="{{ asset('storage/' . $produto->imagem) }}" 
                alt="{{ $produto->nome }}" 
                class="produto-imagem"
            >
        </div>

        @if($produto->preco)
            <p class="produto-preco">
                R$ {{ number_format($produto->preco, 2, ',', '.') }}
            </p>
        @endif

        @if($produto->quantidade > 0)
            <p class="produto-quantidade" style="font-weight: 600; margin-top: 8px;">
                Quantidade disponível: {{ $produto->quantidade }}
            </p>
        @endif

        {{-- Exibindo categoria --}}
        @if(!empty($produto->categoria))
            <p class="produto-categoria" style="font-weight: 600; margin-top: 8px; color: #555;">
                Categoria: {{ $produto->categoria }}
            </p>
        @endif

        <p class="produto-descricao">
            {{ $produto->descricao }}
        </p>

        <div class="produto-botao-voltar-wrapper">
            <a href="{{ route('empresa.sobre', $produto->empresa_id) }}" 
               class="produto-botao-voltar">
                Voltar para a Empresa
            </a>
        </div>
    </div>
</section>
@endsection
