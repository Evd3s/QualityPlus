@extends('layouts.app')

@section('content')
<div class="container">
    <header class="header">
        <div class="logo"><span class="green">Quality</span><span class="blue">Plus+</span></div>
        <nav>
            <ul class="d-flex list-unstyled m-0">
                <li><a href="{{ route('home') }}" class="text-dark mx-3">Home</a></li>
                <li><a href="{{ route('about') }}" class="text-dark mx-3">Sobre</a></li>
                <li><a href="{{ route('contact') }}" class="text-dark mx-3">Contato</a></li>
            </ul>
        </nav>
    </header>

    <section class="content">
        <h1>Entre em contato conosco</h1>
        <p>Se você tem alguma dúvida ou gostaria de saber mais sobre como podemos ajudar a sua empresa, entre em contato conosco!</p>
        <!-- Adicionar formulário ou detalhes de contato -->
    </section>
</div>
@endsection
