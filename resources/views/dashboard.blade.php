@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
<header class="profile-header">
    <div class="header-left">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/Qualityplus.png') }}" alt="QualityPlus Logo" class="profile-logo">
        </a>
    </div>
    <div class="profile-section">
        <a href="{{ route('perfil') }}">
            <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) . '?t=' . uniqid() : asset('images/Perfil.png') }}" 
                 alt="Mini Perfil" 
                 class="header-profile-image" 
                 id="header-profile-image">
        </a>
    </div>
</header>

<div class="main-container">
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

    
    <section class="categories">
        <h3 class="section-title">Categorias</h3>
        <div class="items filtro-categorias">
            @foreach ($categorias as $cat)
                <a href="{{ route('produtos.por_categoria', ['categoria' => $cat]) }}" 
                   class="item-card filtro-card" style="flex-direction: column; padding: 10px;">
                   
                    <div class="item-img" style="width: 80px; height: 80px; margin-bottom: 8px; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                        <img src="{{ asset('images/categorias/' . strtolower($cat) . '.jpg') }}" 
                             alt="{{ ucfirst($cat) }}" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    
                    <div class="item-name" style="font-weight: 700; font-size: 16px; color: white; text-align: center;">
                        {{ ucfirst($cat) }}
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    
    @if($categoria)
        @if($produtosFiltrados->count())
        <section class="categories">
            <h3 class="section-title">{{ ucfirst($categoria) }}</h3> 
            <div class="items">
                @foreach ($produtosFiltrados as $produto)
                    <a href="{{ route('produto.show', $produto->id) }}" class="item-card">
                        <div class="item-img">
                            <img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}">
                        </div>
                        <div class="item-name">{{ $produto->nome }}</div>
                    </a>
                @endforeach
            </div>
        </section>
        @else
            <p style="text-align:center; color:#666;">Nenhum produto encontrado na categoria </p>
        @endif
    @endif

    
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
    </section>
</div>

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

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection

@push('styles')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Arial', sans-serif; background-color: #f5f5f5; color: #333; }
    a { text-decoration: none; color: inherit; }
    ul { list-style: none; }

    .profile-header { position: sticky; top: 0; width: 100%; height: 65px; background-color: white; display: flex; align-items: center; justify-content: space-between; padding: 0 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); z-index: 1000; }
    .profile-logo { height: 40px; cursor: pointer; transition: opacity 0.2s; }
    .profile-logo:hover { opacity: 0.8; }
    .profile-section { display: flex; align-items: center; }
    .header-profile-image { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; cursor: pointer; border: 2px solid #f0f0f0; }

    .main-container { width: 100%; max-width: 1200px; margin: 0 auto; padding: 20px; }

    .banner-container { position: relative; display: flex; background-color: #111; border-radius: 15px; overflow: hidden; margin-bottom: 30px; height: 210px; }
    .banner-text { flex: 1; color: white; padding: 30px; display: flex; flex-direction: column; justify-content: center; }
    .banner-text h2 { font-size: 24px; margin: 5px 0; }
    .banner-map { flex: 1; overflow: hidden; }
    .map-image { width: 100%; height: 100%; object-fit: cover; }

    .filtro-categorias { display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap; }
    .filtro-card { flex: 1 1 150px; background: #006BE6; color: white; border-radius: 15px; display: flex; justify-content: center; align-items: center; padding: 20px 10px; font-weight: 700; font-size: 18px; transition: background-color 0.3s; cursor: pointer; text-align: center; white-space: nowrap; flex-direction: column; }
    .filtro-card:hover, .filtro-card.active { background: #004a99; text-decoration: none; }
    .filtro-card .item-img { width: 80px; height: 80px; margin-bottom: 8px; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.15); }
    .filtro-card .item-img img { width: 100%; height: 100%; object-fit: cover; }
    .filtro-card .item-name { font-weight: 700; font-size: 16px; color: white; text-align: center; }

    .categories { padding: 20px 0; }
    .section-title { font-size: 20px; margin-bottom: 15px; color: #333; }
    .items { display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 20px; margin-bottom: 30px; }
    .item-card { position: relative; background-color: white; border-radius: 15px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: transform 0.3s, box-shadow 0.3s; display: flex; flex-direction: column; align-items: center; padding-bottom: 10px; cursor: pointer; }
    .item-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    .rating { position: absolute; top: 8px; left: 8px; background-color: rgba(255,255,255,0.9); padding: 3px 6px; border-radius: 10px; font-size: 12px; font-weight: bold; z-index: 1; }
    .item-img { width: 100%; height: 100px; overflow: hidden; }
    .item-img img { width: 100%; height: 100%; object-fit: cover; }
    .item-name { margin-top: 10px; font-size: 14px; font-weight: 600; text-align: center; }

    .footer { background-color: #000; color: white; padding: 20px 0; margin-top: 40px; }
    .footer-content { display: flex; justify-content: center; align-items: center; flex-wrap: wrap; gap: 30px; max-width: 1200px; margin: 0 auto; padding: 0 20px; }
    .footer-item { display: flex; align-items: center; gap: 10px; }
    .footer-icon { width: 24px; height: 24px; }

    @media (max-width: 768px) {
        .banner-container { flex-direction: column; height: auto; }
        .banner-text { padding: 20px; }
        .items { grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); }
        .footer-content { flex-direction: column; gap: 15px; }
        .filtro-categorias { flex-direction: column; }
    }
</style>
@endpush
