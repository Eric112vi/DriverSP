

<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.Login'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>

    <body class="page-auth-bg">
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('content'); ?>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-light m-5">
                                            <h4>Welcome Back !</h4>
                                            <h5>Sign in to continue.</h5>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="<?php echo e(URL::asset('build/images/driver.png')); ?>" alt=""
                                            style="width: 140px; height: 140px">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0 bg-primary-subtle">
                                <div class="auth-logo">
                                    <a href="<?php echo e(route('dashboard')); ?>" class="auth-logo-light">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light border border-primary border-3">
                                                <img src="<?php echo e(URL::asset('build/images/driver_square.png')); ?>" alt=""
                                                    class="rounded-circle" height="70">
                                            </span>
                                        </div>
                                    </a>

                                    <a href="<?php echo e(route('dashboard')); ?>" class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light border border-primary-subtle border-5">
                                                <img src="<?php echo e(URL::asset('build/images/driver_square.png')); ?>" alt=""
                                                    class="rounded-circle" height="70">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2">
                                    <form class="form-horizontal" action="<?php echo e(route('login')); ?>" method="post">
                                        <?php echo csrf_field(); ?>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                placeholder="Enter username">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" class="form-control" name="password" placeholder="Enter password"
                                                    aria-label="Password" aria-describedby="password-addon">
                                                <button class="btn btn-light " type="button" id="password-addon"><i
                                                        class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember-check" name="remember">
                                            <label class="form-check-label" for="remember-check">
                                                Remember me
                                            </label>
                                        </div>

                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script-bottom'); ?>
<script>
$(function(){
    <?php if(session('loginError')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Login Error',
            text: <?php echo json_encode(session('loginError')); ?>

        });
    <?php endif; ?>

    <?php if($errors->any()): ?>
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: <?php echo json_encode(implode('<br>', $errors->all())); ?>

        });
    <?php endif; ?>

    <?php if(session('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: <?php echo json_encode(session('success')); ?>

        });
    <?php endif; ?>
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-without-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\CS-App\resources\views/auth-login.blade.php ENDPATH**/ ?>