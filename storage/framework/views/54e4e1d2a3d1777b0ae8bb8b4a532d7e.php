<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Página Inicial'); ?></title>
    <!-- Link para o arquivo de estilos -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/maps/style.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Estilos adicionais (se houver) -->
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="container">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    
    <!-- Scripts -->
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\Inaldo Pontes\Desktop\QualityPlus-main\resources\views/layouts/app.blade.php ENDPATH**/ ?>