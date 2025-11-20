<!-- JAVASCRIPT -->
<script src="<?php echo e(URL::asset('build/libs/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/metismenu/metisMenu.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/simplebar/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/node-waves/waves.min.js')); ?>"></script>
<!-- Sweet Alerts js -->
<script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>

<!-- Sweet alert init js-->
<script src="<?php echo e(URL::asset('build/js/pages/sweet-alerts.init.js')); ?>"></script>
<!-- Required datatable js -->
<script src="<?php echo e(URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
<!-- Buttons examples -->
<script src="<?php echo e(URL::asset('build/libs/datatables.net-buttons/js/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/datatables.net-buttons/js/buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/datatables.net-buttons/js/buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/datatables.net-buttons/js/buttons.colVis.min.js')); ?>"></script>

<!-- Responsive examples -->
<script src="<?php echo e(URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/moment/moment.js')); ?>"></script>
<?php echo $__env->yieldContent('script'); ?>

<!-- App js -->
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })
</script>

<?php echo $__env->yieldContent('script-bottom'); ?><?php /**PATH C:\laragon\www\CS-App\resources\views/layouts/vendor-scripts.blade.php ENDPATH**/ ?>