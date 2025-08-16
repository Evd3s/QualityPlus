<?php $__env->startSection('title', 'Criar Nova Empresa'); ?>

<?php $__env->startSection('content'); ?>
<div class="container dashboard-container">
    <!-- Cabeçalho com navegação -->
    <header class="d-flex justify-content-between align-items-center header-custom">
        <a href="<?php echo e(route('dashboard')); ?>">
            <img src="<?php echo e(asset('images/Qualityplus.png')); ?>" alt="QualityPlus Logo" class="profile-logo">
        </a>

        <!-- Ícone de perfil e logout -->
        <div class="profile-logout d-flex align-items-center">
        <a href="<?php echo e(route('perfil')); ?>">
        <img src="<?php echo e(auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) . '?t=' . uniqid() : asset('images/Perfil.png')); ?>" 
             alt="Mini Perfil" 
             class="header-profile-image" 
             id="header-profile-image">
        </a>
        <form action="<?php echo e(route('logout')); ?>" method="POST" style="display: inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="logout-btn btn btn-link text-dark">
                    <i class="fa fa-sign-out"></i> Sair
                </button>
            </form>
            </div>
    </header>

    <!-- Formulário para criar a empresa -->
    <div class="empresa-container">
        <div class="empresa-logo">
            <img src="<?php echo e(asset('storage/empresas/default.png')); ?>" id="preview-img" alt="Logo da Empresa" style="display: none;">
        </div>
        <div class="empresa-info">
            <h2 id="empresa-nome"><?php echo e(old('nome', 'Nome da Empresa')); ?></h2>
            <p id="empresa-detalhes"><?php echo e(old('sobre', 'Detalhes sobre a empresa...')); ?></p>
        </div>

        <form action="<?php echo e(route('empresa.store')); ?>" method="POST" enctype="multipart/form-data" class="empresa-form">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="nome">Nome da Empresa</label>
                <input type="text" name="nome" id="nome" value="<?php echo e(old('nome')); ?>" required>
                <?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="cnpj">CNPJ</label>
                <input type="text" name="cnpj" id="cnpj" value="<?php echo e(old('cnpj')); ?>" required>
                <?php $__errorArgs = ['cnpj'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="imagem">Imagem</label>
                <input type="file" name="imagem" id="imagem" accept="image/*" onchange="previewImage(event)">
                <div class="image-preview">
                    <img id="preview-img" src="#" alt="Pré-visualização" style="display: none;">
                </div>
                <?php $__errorArgs = ['imagem'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="sobre">Sobre</label>
                <textarea name="sobre" id="sobre" required><?php echo e(old('sobre')); ?></textarea>
                <?php $__errorArgs = ['sobre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <button type="submit" class="btn-create">Criar Empresa</button>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview-img');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Atualizar o cabeçalho dinamicamente com o nome e a descrição
    document.getElementById('nome').addEventListener('input', function() {
        document.getElementById('empresa-nome').textContent = this.value || 'Nome da Empresa';
    });

    document.getElementById('sobre').addEventListener('input', function() {
        document.getElementById('empresa-detalhes').textContent = this.value || 'Detalhes sobre a empresa...';
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/create.css')); ?>">
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Inaldo Pontes\Desktop\QualityPlus-main\resources\views/empresa/create.blade.php ENDPATH**/ ?>