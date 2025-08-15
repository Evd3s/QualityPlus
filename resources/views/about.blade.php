@extends('layouts.app')

@section('content')
<div class="container">
    <header class="header-custom">
        <!-- Logo -->
        <div class="logo">
            <span class="green">Quality</span><span class="blue">Plus+</span>
        </div>

        <!-- Navegação -->
        <nav class="nav-custom">
            <ul class="d-flex list-unstyled m-0">
                <li><a href="{{ route('about') }}" class="text-dark mx-3">Sobre</a></li>
                <li><a href="{{ route('contact') }}" class="text-dark mx-3">Contato</a></li>
            </ul>
        </nav>

        <!-- Perfil e Logout -->
        <div class="profile-logout d-flex align-items-center">
            <div class="profile-icon">
                <img src="{{ asset('images/perfil.png') }}" alt="Perfil" class="rounded-circle" width="40" height="40">
            </div>

            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="logout-btn">Sair</button>
            </form>
        </div>
    </header>

    <section class="content">
        <h1>Sobre QualityPlus+</h1>
        <p>QualityPlus+ é uma plataforma criada para aumentar a visibilidade de microempresas, oferecendo ferramentas e recursos para que o seu negócio cresça mais rápido.</p>
    </section>
</div>
@endsection
