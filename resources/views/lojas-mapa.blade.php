@extends('layouts.app')

@section('title', 'Mapa de Lojas')

@section('content')>
<header class="profile-header">
    <div class="header-left">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/Qualityplus.png') }}" alt="QualityPlus Logo" class="profile-logo">
        </a>
    </div>
    <div class="profile-section">
        <a href="{{ route('perfil') }}">
            <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) . '?t=' . uniqid() : asset('images/Perfil.png') }}" alt="Mini Perfil" class="header-profile-image" id="header-profile-image">
        </a>
    </div>
</header>

<div class="map-container">
    <div class="map-search-container">
        <div class="search-box">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="search-input" placeholder="Pesquisa..." class="search-input">
        </div>
    </div>
    
    <div class="map-content">
        
        <div id="map"></div>
        
        
        <div class="nearby-stores">
            <h2>Perto de você!</h2>
            
            
            <div id="loading" class="loading-indicator" style="display: none;">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Buscando estabelecimentos...</p>
            </div>
            
            
            <div class="stores-list" id="stores-list">
                
            </div>
            
            
            <div id="no-results" class="no-results" style="display: none;">
                <p>Clique no mapa para buscar estabelecimentos próximos.</p>
            </div>
        </div>
    </div>
    
    
    <div class="filters-container">
        <div class="filter-group">
            <label>Raio de busca:</label>
            <select id="radius">
                <option value="500">500m</option>
                <option value="1000" selected>1km</option>
                <option value="2000">2km</option>
                <option value="5000">5km</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label>Tipos:</label>
            <div class="filter-checkboxes">
                <label><input type="checkbox" id="restaurants" checked> Restaurantes</label>
                <label><input type="checkbox" id="shops" checked> Lojas</label>
                <label><input type="checkbox" id="tourism" checked> Turismo</label>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('js/lojas-map.js') }}"></script>
@endsection