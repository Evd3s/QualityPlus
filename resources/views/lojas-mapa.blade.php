@extends('layouts.app')

@section('content')
<!-- Adicionar o cabeçalho -->
<header class="profile-header">
    <div class="header-left">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/Qualityplus.png') }}" alt="QualityPlus Logo" class="profile-logo">
        </a>
    </div>
    <!-- Ícone de perfil -->
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
            <div class="stores-list" id="stores-list">
                <!-- As lojas próximas serão carregadas dinamicamente aqui -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/lojas-map.js') }}"></script>
@endsection