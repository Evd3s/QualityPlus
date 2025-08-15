@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
<!-- Cabeçalho com navegação -->
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

<!-- Conteúdo principal -->
<div class="main-container">
    <!-- Banner com mapa -->
    <div class="banner-container">
        <div class="banner-text">
            <h2>Veja qualquer loja perto de</h2>
            <h2>você em tempo Real</h2>
        </div>
        <div class="banner-map">
            <a href="{{ route('lojas-mapa') }}">
                <img src="{{ asset('images/google-maps.png') }}" alt="Mapa Google" class="map-image">
            </a>
        </div>
    </div>

    <!-- Listagem de empresas -->
    <section class="categories">
        <h3 class="section-title">Perto de você!</h3>
        
        <div class="items">
            @foreach ($empresas as $empresa)
                <a href="{{ route('empresa.sobre', ['id' => $empresa->id]) }}" class="item-card">
                    <div class="rating">4.5 ⭐</div>
                    <div class="item-img">
                        <img src="{{ asset('storage/' . $empresa->imagem) }}" alt="{{ $empresa->nome }}">
                    </div>
                    <div class="item-name">{{ $empresa->nome }}</div>
                </a>
            @endforeach
        </div>
        
        <h3 class="section-title">Alimentos</h3>
        <div class="items">
            <a href="{{ route('alimentos.maca') }}" class="item-card">
                <div class="item-img">
                    <img src="{{ asset('images/maca.png') }}" alt="Maçã">
                </div>
                <div class="item-name">Maçã</div>
            </a>
            <!-- Espaços para mais itens -->
            <div class="item-card empty"></div>
            <div class="item-card empty"></div>
        </div>
        
        <h3 class="section-title">Artesanato</h3>
        <div class="items">
            <div class="item-card empty"></div>
            <!-- Espaços para mais itens -->
        </div>
        
        <h3 class="section-title">Tecnologia</h3>
        <div class="items">
            <div class="item-card empty"></div>
            <!-- Espaços para mais itens -->
        </div>
    </section>
</div>

<!-- Rodapé -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-item">
            <img src="{{ asset('images/Email.png') }}" alt="Email" class="footer-icon">
            <span>Quality@gmail.com</span>
        </div>
        <div class="footer-item">
            <img src="{{ asset('images/Instagram.png') }}" alt="Instagram" class="footer-icon">
            <span>@QualityPlus</span>
        </div>
        <div class="footer-item">
            <img src="{{ asset('images/WhatsApp.png') }}" alt="WhatsApp" class="footer-icon">
            <span>(91) 98934-3498</span>
        </div>
    </div>
</footer>

<!-- Logout Form (escondido mas acessível para JavaScript) -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection

@push('styles')
<style>
    /* Reset e estilos globais */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f5f5f5;
        color: #333;
    }
    
    a {
        text-decoration: none;
        color: inherit;
    }
    
    ul {
        list-style: none;
    }
    
    /* Header */
    .profile-header {
        position: sticky;
        top: 0;
        width: 100%;
        height: 65px;
        background-color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }
    
    .header-left {
        display: flex;
        align-items: center;
    }
    
    .profile-logo {
        height: 40px;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    
    .profile-logo:hover {
        opacity: 0.8;
    }
    
    .nav-custom ul {
        display: flex;
        gap: 15px;
    }
    
    .nav-custom a {
        text-decoration: none;
        color: #333;
        font-weight: 600;
        padding: 8px 15px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    
    .nav-custom a:hover {
        background-color: #f0f0f0;
    }
    
    .profile-section {
        display: flex;
        align-items: center;
    }
    
    .header-profile-image {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid #f0f0f0;
    }
    
    /* Container principal */
    .main-container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    /* Banner */
    .banner-container {
        position: relative;
        display: flex;
        background-color: #111;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 30px;
        height: 210px;
    }
    
    .banner-text {
        flex: 1;
        color: white;
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .banner-text h2 {
        font-size: 24px;
        margin: 5px 0;
    }
    
    .banner-map {
        flex: 1;
        overflow: hidden;
    }
    
    .map-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .banner-controls {
        position: absolute;
        width: 100%;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        justify-content: space-between;
        padding: 0 10px;
    }
    
    .banner-arrow {
        width: 30px;
        height: 30px;
        background-color: rgba(255, 255, 255, 0.3);
        border: none;
        border-radius: 50%;
        color: white;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Área de pesquisa */
    .search-section {
        margin-bottom: 30px;
    }
    
    .search-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }
    
    .search-wrapper {
        position: relative;
        width: 300px;
    }
    
    .search-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        background: url('{{ asset('images/lupa.png') }}') no-repeat center;
        background-size: contain;
    }
    
    .search-input {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border: none;
        border-radius: 25px;
        background-color: #f0f0f0;
        font-size: 14px;
    }
    
    .btn-create {
        padding: 12px 20px;
        background: linear-gradient(to right, #00B88A, #00A070);
        color: white;
        border-radius: 25px;
        font-weight: 600;
        transition: transform 0.3s, box-shadow 0.3s;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
    }
    
    /* Categorias e itens */
    .categories {
        padding: 20px 0;
    }
    
    .section-title {
        font-size: 20px;
        margin-bottom: 15px;
        color: #333;
    }
    
    .items {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .item-card {
        position: relative;
        background-color: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-bottom: 10px;
    }
    
    .item-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .rating {
        position: absolute;
        top: 8px;
        left: 8px;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 3px 6px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: bold;
        z-index: 1;
    }
    
    .item-img {
        width: 100%;
        height: 100px;
        overflow: hidden;
    }
    
    .item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .item-name {
        margin-top: 10px;
        font-size: 14px;
        font-weight: 600;
        text-align: center;
    }
    
    .item-card.empty {
        background-color: #f5f5f5;
        min-height: 150px;
    }
    
    /* Rodapé */
    .footer {
        background-color: #000;
        color: white;
        padding: 20px 0;
        margin-top: 40px;
    }
    
    .footer-content {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .footer-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .footer-icon {
        width: 24px;
        height: 24px;
    }
    
    /* Responsividade */
    @media (max-width: 768px) {
        .banner-container {
            flex-direction: column;
            height: auto;
        }
        
        .banner-text {
            padding: 20px;
        }
        
        .search-container {
            flex-direction: column;
        }
        
        .search-wrapper {
            width: 100%;
        }
        
        .items {
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        }
        
        .footer-content {
            flex-direction: column;
            gap: 15px;
        }
    }
</style>
@endpush