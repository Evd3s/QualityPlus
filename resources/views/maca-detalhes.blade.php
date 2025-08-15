@extends('layouts.app')

@section('title', 'Detalhes da Maçã')

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
    <div class="product-container">
        <!-- Seção superior com imagem e detalhes do produto -->
        <div class="product-details-container">
            <div class="product-image-container">
                <img src="{{ asset('images/maca.png') }}" alt="Maçã" class="product-image">
            </div>
            <div class="product-info-container">
                <h2 class="product-title">Item</h2>
                <h1 class="product-name">Maçã</h1>
                <h3 class="product-section-title">Detalhes</h3>
                <p class="product-detail">Fruta</p>
                <p class="product-detail">52 calorias</p>
                <p class="product-price">Valor Médio R$ 9,98 por Kg.</p>
            </div>
        </div>

        <!-- Seção com preços em diferentes lojas -->
        <h3 class="section-title">Onde encontrar este produto</h3>
        <div class="stores-grid">
            <!-- Mix Mateus -->
            <div class="store-card">
                <div class="store-logo-container">
                    <img src="{{ asset('images/mix-mateus.png') }}" alt="Mix Mateus" class="store-logo">
                </div>
                <div class="store-info">
                    <h4 class="store-name">Preço da maçã:</h4>
                    <p class="store-price">R$ 2,99</p>
                </div>
            </div>

            <!-- Americanas -->
            <div class="store-card">
                <div class="store-logo-container">
                    <img src="{{ asset('images/americanas.png') }}" alt="Americanas" class="store-logo">
                </div>
                <div class="store-info">
                    <h4 class="store-name">Preço da maçã:</h4>
                    <p class="store-price">R$ 3,50</p>
                </div>
            </div>

            <!-- Outra loja -->
            <div class="store-card">
                <div class="store-logo-container">
                    <img src="{{ asset('images/store-placeholder.png') }}" alt="Super Mercado" class="store-logo">
                </div>
                <div class="store-info">
                    <h4 class="store-name">Preço da maçã:</h4>
                    <p class="store-price">R$ 3,29</p>
                </div>
            </div>
        </div>

        <!-- Seção com botão para visualizar no mapa -->
        <div class="map-section">
            <a href="{{ route('lojas-mapa') }}" class="map-button">
                Ver todas as lojas no mapa
            </a>
        </div>
    </div>
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
    
    /* Header (reaproveitado do dashboard) */
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
        min-height: calc(100vh - 170px); /* altura mínima para o footer ficar no final */
    }
    
    /* Container do produto */
    .product-container {
        background-color:rgb(228, 228, 228);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }
    
    /* Seção de detalhes do produto */
    .product-details-container {
        display: flex;
        background-color: #f5f5f5;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .product-image-container {
        flex: 1;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f5f5f5;
        max-width: 40%;
    }
    
    .product-image {
        max-width: 100%;
        max-height: 300px;
        object-fit: contain;
    }
    
    .product-info-container {
        flex: 1.5;
        padding: 30px;
        background-color: #f5f5f5;
    }
    
    .product-title {
        font-size: 22px;
        font-weight: 600;
        color: #555;
        margin-bottom: 5px;
    }
    
    .product-name {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #333;
    }
    
    .product-section-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #444;
    }
    
    .product-detail {
        font-size: 16px;
        margin-bottom: 8px;
        color: #555;
    }
    
    .product-price {
        font-size: 18px;
        font-weight: 600;
        margin-top: 15px;
        color: #333;
    }
    
    /* Seção de lojas */
    .section-title {
        font-size: 22px;
        margin: 10px 0 20px 0;
        color: black;
        text-align: center;
    }
    
    .stores-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .store-card {
        background-color:rgb(243, 243, 243);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .store-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .store-logo-container {
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color:rgb(243, 243, 243);
        height: 120px;
    }
    
    .store-logo {
        max-width: 100%;
        max-height: 80px;
        object-fit: contain;
    }
    
    .store-info {
        padding: 15px 20px;
        border-top: 1px solid #eee;
    }
    
    .store-name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }
    
    .store-price {
        font-size: 18px;
        font-weight: 700;
        color: #00B88A;
    }
    
    /* Seção do mapa */
    .map-section {
        display: flex;
        justify-content: center;
        margin: 30px 0 10px 0;
    }
    
    .map-button {
        padding: 12px 25px;
        background-color: #ffffff;
        color: #0088CC;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .map-button:hover {
        background-color: #0088CC;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    /* Rodapé (reaproveitado do dashboard) */
    .footer {
        background-color: #000;
        color: white;
        padding: 20px 0;
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
        .product-details-container {
            flex-direction: column;
        }
        
        .product-image-container {
            max-width: 100%;
            padding: 15px;
        }
        
        .product-info-container {
            padding: 20px;
        }
        
        .stores-grid {
            grid-template-columns: 1fr;
        }
        
        .footer-content {
            flex-direction: column;
            gap: 15px;
        }
    }
</style>
@endpush