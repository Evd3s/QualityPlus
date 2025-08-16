@extends('layouts.app')

@section('title', 'Categorias de Produtos')

@section('content')
<link rel="stylesheet" href="{{ asset('css/EpSobre.css') }}">

<section class="sobre-content" style="padding: 40px 20px;">
    <div class="container" style="max-width: 960px; margin: 0 auto;">
        <h1 class="text-center mb-5" style="font-size: 32px; font-weight: bold; color: #004A99;">
            Categorias de Produtos
        </h1>

        @if($categorias->count())
        <div class="d-flex flex-wrap justify-content-center gap-4">
            @foreach($categorias as $categoria)
            <a href="{{ route('produtos.por.categoria', ['categoria' => $categoria]) }}"
                class="btn btn-outline-primary"
                style="padding: 12px 24px; border-radius: 12px; font-size: 16px; text-transform: capitalize;">
                {{ $categoria }}
            </a>
            @endforeach
        </div>
        @else
        <p class="text-center" style="color: #666; font-size: 18px;">Nenhuma categoria encontrada.</p>
        @endif
    </div>
</section>
@endsection
