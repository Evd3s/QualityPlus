@extends('layouts.app')

@section('title', ucfirst($categoria))

@section('content')

<style>
    .container {
        max-width: 1200px;
        margin: 40px auto 60px;
        padding: 0 15px;
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
    }

    .header-logo img {
        height: 50px;
        width: auto; 
        cursor: pointer;
        border-radius: 0; 
        transition: transform 0.3s ease;
    }

    .header-perfil img {
        height: 50px;
        width: 50px;
        cursor: pointer;
        border-radius: 50%; 
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .header-logo img:hover,
    .header-perfil img:hover {
        transform: scale(1.05);
    }

    
    .produtos-grid {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 24px;
        padding-bottom: 10px;
        
        scroll-behavior: smooth;
    }

    .produtos-grid::-webkit-scrollbar {
        height: 8px;
    }
    .produtos-grid::-webkit-scrollbar-thumb {
        background: #004A99;
        border-radius: 4px;
    }
    .produtos-grid::-webkit-scrollbar-track {
        background: #e1e1e1;
        border-radius: 4px;
    }

    .card-produto {
        flex: 0 0 260px; 
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        overflow: hidden;
        padding: 16px;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
        scroll-snap-align: start; 
    }

    .card-produto:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .card-produto-img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 14px;
    }

    .card-produto-titulo {
        font-size: 20px;
        font-weight: 700;
        color: #004A99;
        margin-bottom: 12px;
        text-align: center;
    }

    .btn-custom {
        background-color: #006BE6;
        color: white;
        padding: 10px 16px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-align: center;
        transition: background-color 0.3s ease;
        margin-top: auto;
        text-decoration: none;
        user-select: none;
    }

    .btn-custom:hover {
        background-color: #004A99;
    }

    /* Responsivo */
    @media(max-width: 768px) {
        .header-top {
            flex-direction: column;
            gap: 16px;
            align-items: flex-start;
        }
        .produtos-grid {
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 20px;
        }
    }

</style>

<section class="container">

    
    <div class="header-top">
        <div class="header-logo">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('images/Qualityplus.png') }}" alt="QualityPlus Logo">
            </a>
        </div>
        <div class="header-perfil">
            <a href="{{ route('perfil') }}">
                <img 
                    src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) . '?t=' . uniqid() : asset('images/perfil.png') }}" 
                    alt="Perfil Logo" 
                >
            </a>
        </div>
    </div>

    <h1 class="text-center mb-5" style="font-size: 32px; font-weight: bold; color: #004A99;">
        {{ ucfirst($categoria) }}
    </h1>

    @if($produtos->count())
        <div class="produtos-grid">
            @foreach($produtos as $produto)
                <div class="card-produto">
                    <img src="{{ asset('storage/' . $produto->imagem) }}" 
                         alt="{{ $produto->nome }}" 
                         class="card-produto-img">
                    
                    <h4 class="card-produto-titulo">
                        {{ $produto->nome }}
                    </h4>
                    
                    @if($produto->preco)
                        <p class="card-produto-preco" style="color: #00B88A; font-weight: 700; font-size: 18px; text-align: center; margin-bottom: 12px;">
                            R$ {{ number_format($produto->preco, 2, ',', '.') }}
                        </p>
                    @endif
                    
                    <a href="{{ route('produto.show', $produto->id) }}" class="btn-custom">
                        Ver Detalhes
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center" style="color: #666; font-size: 18px;">
            Nenhum produto encontrado nesta categoria.
        </p>
    @endif

</section>

@endsection
