<!-- resources/views/empresa/partials/editar_empresa.blade.php -->
<div id="editar-container" class="editar-container" style="display:none; position: fixed; top: 0; left:0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999; justify-content: center; align-items: center;">
    <div class="editar-box position-relative" style="background: white; padding: 20px; border-radius: 10px; max-width: 500px; width: 90%;">
        <button id="fechar-btn" class="btn-fechar" style="position: absolute; top: 10px; right: 15px; font-size: 28px; background: none; border: none; cursor: pointer;">&times;</button>
        <h3>Editar Empresa</h3>

        <form action="{{ route('empresa.update', $empresa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="logo">Logo da Empresa</label>
                <input type="file" name="imagem" class="form-control" id="logo" accept="image/*">
            </div>

            <div class="form-group mt-3">
                <label for="cnpj">CNPJ</label>
                <input type="text" name="cnpj" class="form-control" id="cnpj" value="{{ $empresa->cnpj }}" required>
            </div>

            <div class="form-group mt-3">
                <label for="sobre">Sobre a Empresa</label>
                <textarea name="sobre" class="form-control" id="sobre" rows="4" required>{{ $empresa->sobre }}</textarea>
            </div>

            <div class="form-group mt-4 text-right">
                <button type="submit" class="btn-salvar">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>
