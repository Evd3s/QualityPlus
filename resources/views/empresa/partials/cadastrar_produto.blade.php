
<div id="cadastrar-produto-container" class="editar-container" style="display:none; position: fixed; top: 0; left:0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999; justify-content: center; align-items: center;">
    <div class="editar-box position-relative" style="background: white; padding: 20px; border-radius: 10px; max-width: 500px; width: 90%;">
        <button id="fechar-cadastrar-produto-btn" class="btn-fechar" style="position: absolute; top: 10px; right: 15px; font-size: 28px; background: none; border: none; cursor: pointer;">&times;</button>
        <h3>Cadastrar Novo Produto</h3>

        <form action="{{ route('produto.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">

            <div class="form-group">
                <label for="nome">Nome do Produto</label>
                <input type="text" name="nome" class="form-control" id="nome" required>
            </div>

            <div class="form-group mt-3">
                <label for="preco">Preço (opcional)</label>
                <input type="number" step="0.01" min="0" name="preco" class="form-control" id="preco">
            </div>

            <div class="form-group mt-3">
                <label for="quantidade">Quantidade</label>
                <input type="number" step="1" min="0" name="quantidade" class="form-control" id="quantidade" required>
            </div>
            
            <div class="form-group mt-3">
                <label for="categoria">Categoria</label>
                <input type="text" name="categoria" class="form-control" id="categoria" required>
            </div>

            <div class="form-group mt-3">
                <label for="descricao">Descrição</label>
                <textarea name="descricao" class="form-control" id="descricao" rows="3" required></textarea>
            </div>

            <div class="form-group mt-3">
                <label for="imagem">Imagem</label>
                <input type="file" name="imagem" class="form-control" id="imagem" accept="image/*" required>
            </div>

            <div class="form-group mt-4 text-right">
                <button type="submit" class="btn-salvar">Adicionar Produto</button>
            </div>
        </form>
    </div>
</div>
