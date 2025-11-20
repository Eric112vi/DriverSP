<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

    <head>
        <meta charset="utf-8" />
        <base href="<?php echo e(url('/')); ?>/">
        <title> <?php echo $__env->yieldContent('title'); ?> </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo e(URL::asset('build/images/favicon.ico')); ?>">
        <style>
        .page-auth-bg {
            /* overlay plus image, keeps text readable */
            background: linear-gradient(rgba(0,0,0,0.35), rgba(0,0,0,0.35)),
                        url('<?php echo e(asset('build/images/6080984.jpg')); ?>') center/cover no-repeat fixed;
            background-size: cover;
            min-height: 100vh;
        }
        </style>
        <?php echo $__env->make('layouts.head-css', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </head>

    <?php echo $__env->yieldContent('body'); ?>
    
    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->make('layouts.vendor-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </body>
</html><?php /**PATH C:\laragon\www\CS-App\resources\views/layouts/master-without-nav.blade.php ENDPATH**/ ?>