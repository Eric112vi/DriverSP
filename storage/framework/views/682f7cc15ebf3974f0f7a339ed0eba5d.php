

<?php $__env->startSection('title'); ?>
    Permission
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Auth
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Cabang
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Cabang Table</h4>
                    <button type="button" class="btn btn-primary mt-3" id="openAddModal">Add</button>
                    <p class="card-title-desc">
                    </p>
                    <table id="table-cabang" class="table table-bordered table-hover nowrap w-100">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Branches name</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>


                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Cabang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm" name="addForm" class="form-horizontal" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="code1" class="form-label">Kode Cabang</label>
                            <input type="text" class="form-control" id="code1" name="code1" placeholder="Enter Name" value="" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="name1" class="form-label">Nama Cabang</label>
                            <input type="text" class="form-control" id="name1" name="name1" placeholder="Enter Name" value="" autocomplete="off" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-add">
                        Add
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Cabang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" name="editForm" class="form-horizontal" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id2" id="id2">
                        <div class="mb-3">
                            <label for="code2" class="form-label">Kode Cabang</label>
                            <input type="text" class="form-control" id="code2" name="code2" placeholder="Enter Name" value="" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="name2" class="form-label">Nama Cabang</label>
                            <input type="text" class="form-control" id="name2" name="name2" placeholder="Enter Name" value="" autocomplete="off" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-update">
                        Update
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

    <script>
        $(document).ready(function () {
            var table = $('#table-cabang').DataTable({
                pageLength: 50,
                "bAutoWidth": false,
                pagingType: 'full_numbers',
                processing: true,
                serverSide: true,
                scrollX: true,  
                ajax: {
                    url: "<?php echo e(route('branches.index')); ?>"
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    { data: 'nama_cabang', name: 'nama_cabang' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('data-id', data.id);
                },
            });
            $("#table-cabang").on("click", ".editBranch", function () { 
                var id = $(this).data('id');
                // AJAX request
                $.ajax({
                    url: "<?php echo e(route('branches.show', '')); ?>/" + id,
                    type: 'GET',
                    success: function (data) {
                        $('#name2').val(data.nama_cabang);
                        $('#code2').val(data.kode_cabang);
                        $('#id2').val(data.id);
                        $('#editModal').modal('show');
                    }
                });
            });

            $('#openAddModal').on('click', function () {
                $('#name1').val('');
                $('#code1').val('');
                $('#addModal').modal('show');
            });

            $('#btn-add').on('click', function (e) {
                e.preventDefault();
                const data = {
                    kode_cabang: $('#code1').val(),
                    nama_cabang: $('#name1').val(),
                }
                console.log(data);
                // AJAX request
                $.ajax({
                    url: '<?php echo e(route("branches.store")); ?>',
                    type: 'POST',
                    data: data,
                    dataType: "json",
                    success: function (data) {
                        // Hide the modal
                        $('#addModal').modal('hide');
                        // Reload DataTable
                        table.ajax.reload(null, false);
                        swal.fire(
                            'Added!',
                            'Cabang has been added.',
                            'success'
                        )
                    }
                });
            });
            $('#btn-update').on('click', function (e) {
                e.preventDefault();
                var id = $('#id2').val();
                const data = {
                    kode_cabang: $('#code2').val(),
                    nama_cabang: $('#name2').val(),
                }
                // AJAX request
                $.ajax({
                    url: '<?php echo e(route("branches.update", '')); ?>/' + id,
                    type: 'PUT',
                    data: data,
                    dataType: "json",
                    success: function (data) {
                        // Hide the modal
                        $('#editModal').modal('hide');
                        // Reload DataTable
                        table.ajax.reload(null, false);
                        swal.fire(
                            'Updated!',
                            'Cabang has been updated.',
                            'success'
                        )
                    }
                });
            });

            $('#addModal').on('hidden.bs.modal', function () {
                $('#code1').val('');
                $('#name1').val('');
            });

            $('#editModal').on('hidden.bs.modal', function () {
                $('#code2').val('');
                $('#name2').val('');
            });

            $("#table-cabang").on("click", ".deleteBranch", function () { 
                var id = $(this).data('id');
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // AJAX request
                        $.ajax({
                            url: '<?php echo e(route("branches.destroy", '')); ?>/' + id,
                            type: 'DELETE',
                            dataType: "json",
                            success: function (data) {
                                // Reload DataTable
                                table.ajax.reload(null, false);
                                Swal.fire(
                                    'Deleted!',
                                    'Your data has been deleted.',
                                    'success'
                                )
                            }
                        });
                    }
                }) 
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\CS-App\resources\views/auth/cabang.blade.php ENDPATH**/ ?>