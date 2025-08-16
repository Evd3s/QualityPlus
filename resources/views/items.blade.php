<section class="categories mt-4">
    @foreach ($categorias as $categoria => $itens)
        <h4 class="category">{{ $categoria }}</h4>
        <div class="items">
            @forelse ($itens as $item)
                <div class="item">
                    <img src="{{ asset('images/' . $item['imagem']) }}" alt="{{ $item['nome'] }}">
                    <div>
                        <p>{{ $item['nome'] }}</p>
                        
                        <!-- Sistema de Estrelas -->
                        <div class="rating" data-item-id="{{ $item['id'] }}">
                            <span class="star" data-value="1">&#9733;</span>
                            <span class="star" data-value="2">&#9733;</span>
                            <span class="star" data-value="3">&#9733;</span>
                            <span class="star" data-value="4">&#9733;</span>
                            <span class="star" data-value="5">&#9733;</span>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Nenhum item disponível.</p>
            @endforelse
        </div>
    @endforeach
</section>
