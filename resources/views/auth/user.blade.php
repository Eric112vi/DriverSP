@extends('layouts.master')

@section('title')
    User
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Auth
        @endslot
        @slot('title')
            User
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">User Table</h4>
                    <button type="button" class="btn btn-primary mt-3" id="openAddModal">Add</button>
                    <p class="card-title-desc">
                    </p>
                    <table id="table-user" class="table table-bordered table-hover nowrap w-100">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Status</th>
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
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm" name="addForm" class="form-horizontal" action="{{ route('addstaff') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id1" id="user_id1">
                        <div class="row mb-5">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="name1" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name1" name="name1" placeholder="Enter Name" value="" autocomplete="off" required>
                                </div>
                                <div class="mb-3">
                                    <label for="username1" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username1" name="username1" placeholder="Enter Username" value="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-8"></div>
                        </div>

                        <h3 class="mb-5">User Permissions</h3>
                        @php
                            $cabang = $permissions->filter(function($p) {
                                return \Illuminate\Support\Str::startsWith((string)$p->name, 'cabang_');
                            });
                            $others = $permissions->reject(function($p) {
                                return \Illuminate\Support\Str::startsWith((string)$p->name, 'cabang_');
                            });
                        @endphp

                        <h5 class="ms-3 mb-3">Cabang</h5>
                        @foreach($cabang as $permission)
                            <div class="form-check form-switch ms-2 mb-3">
                                <input class="form-check-input" type="checkbox" id="permission{{ $permission->id }}" name="permission{{ $permission->id }}" value="{{ $permission->id }}" autocomplete="off">
                                <label class="form-check-label" for="permission{{ $permission->id }}">
                                    {{ implode(' ', array_map('strtoupper', explode('_', str_replace('cabang_', '', $permission->name)))) }}
                                </label>
                            </div>
                        @endforeach

                        @if($others->isNotEmpty())
                            <h4 class="ms-3 mt-5 mb-3">Other Permissions</h4>
                            @foreach($others as $permission)
                                <div class="form-check form-switch ms-2 mb-3">
                                    <input class="form-check-input" type="checkbox" id="permission{{ $permission->id }}" name="permission{{ $permission->id }}" value="{{ $permission->id }}" autocomplete="off">
                                    <label class="form-check-label" for="permission{{ $permission->id }}">
                                        {{ ucwords(str_replace('_', ' ', \Illuminate\Support\Str::plural($permission->name))) }}
                                    </label>
                                </div>
                            @endforeach
                        @endif
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
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" name="editForm" class="form-horizontal" action="{{ route('updatestaff') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id2" id="user_id2">
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="name2" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name2" name="name2" placeholder="Enter Name" value="" autocomplete="off" required>
                                </div>
                                <div class="mb-3">
                                    <label for="username2" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username2" name="username2" placeholder="Enter Username" value="" autocomplete="off" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editstatus2" class="form-label">Status</label>
                                    <select class="form-select" id="editstatus2" name="editstatus2" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-8"></div>
                        </div>

                        <h3 class="mb-3">User Permissions</h3>
                        @php
                            $cabang = $permissions->filter(function($p) {
                                return \Illuminate\Support\Str::startsWith((string)$p->name, 'cabang_');
                            });
                            $others = $permissions->reject(function($p) {
                                return \Illuminate\Support\Str::startsWith((string)$p->name, 'cabang_');
                            });
                        @endphp

                        <h5 class="mb-3">Cabang</h5>
                        @foreach($cabang as $permission)
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="permission_edit{{ $permission->id }}" name="permission_edit{{ $permission->id }}" value="{{ $permission->id }}" autocomplete="off">
                                <label class="form-check-label" for="permission_edit{{ $permission->id }}">
                                    {{ implode(' ', array_map('strtoupper', explode('_', str_replace('cabang_', '', $permission->name)))) }}
                                </label>
                            </div>
                        @endforeach

                        @if($others->isNotEmpty())
                            <h4 class="mb-3">Other Permissions</h4>
                            @foreach($others as $permission)
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="permission_edit{{ $permission->id }}" name="permission_edit{{ $permission->id }}" value="{{ $permission->id }}" autocomplete="off">
                                    <label class="form-check-label" for="permission_edit{{ $permission->id }}">
                                        {{ ucwords(str_replace('_', ' ', \Illuminate\Support\Str::plural($permission->name))) }}
                                    </label>
                                </div>
                            @endforeach
                        @endif
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



@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var table = $('#table-user').DataTable({
                pageLength: 50,
                "bAutoWidth": false,
                pagingType: 'full_numbers',
                processing: true,
                serverSide: true,
                scrollX: true,  
                ajax: {
                    url: "{{ route('users.index') }}"
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    { data: 'name', name: 'name' },
                    { data: 'username', name: 'username' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('data-id', data.uuid);
                },
            });
            
            $('#openAddModal').on('click', function () {
                $('#name1').val('');
                $('#username1').val('');
                $('#addModal input[type=checkbox][id^="permission"]').prop('checked', false);
                $('#addModal').modal('show');
            });

            $('#btn-add').on('click', function (e) {
                e.preventDefault();
                const permissions = $('#addModal input[type=checkbox][id^="permission"]:checked').map(function () {
                    return $(this).val();
                }).get();

                const data = {
                    name: $('#name1').val(),
                    username: $('#username1').val(),
                    permissions: permissions,
                }
                $.ajax({
                    url: '{{ route("addstaff")}}',
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
                            'New user has been added.',
                            'success'
                        )
                    }
                });
            });
            $("#table-user").on("click", ".editStaff", function () { 
                var user_id = $(this).data('id');
                // AJAX request
                $.ajax({
                    url: '{{ route("editstaff")}}',
                    type: 'GET',
                    data: {
                        user_id: user_id
                    },
                    success: function (data) {
                        $('#name2').val(data.name);
                        $('#username2').val(data.username);
                        $('#editstatus2').val(data.status);
                        $('#user_id2').val(data.uuid);
                        $('#editModal input[type=checkbox][id^="permission_edit"]').prop('checked', false);
                        if (Array.isArray(data.permissions)) {
                            data.permissions.forEach(function (id) {
                                $('#permission_edit' + id).prop('checked', true);
                            });
                        }
                        $('#editModal').modal('show');
                    }
                });
            });

            $('#btn-update').on('click', function (e) {
                e.preventDefault();
                var user_id = $('#user_id2').val();
                const permissions = $('#editModal input[type=checkbox][id^="permission_edit"]:checked').map(function () {
                    return $(this).val();
                }).get();

                const data = {
                    name: $('#name2').val(),
                    username: $('#username2').val(),
                    status: $('#editstatus2').val(),
                    user_id: user_id,
                    permissions: permissions,
                }
                // AJAX request
                $.ajax({
                    url: '{{ route("updatestaff")}}',
                    type: 'POST',
                    data: data,
                    dataType: "json",
                    success: function (data) {
                        // Hide the modal
                        $('#editModal').modal('hide');
                        // Reload DataTable
                        table.ajax.reload(null, false);
                        swal.fire(
                            'Updated!',
                            'User has been updated.',
                            'success'
                        )
                    }
                });
            });

            $("#table-user").on("click", ".resetpassStaff", function () { 
                var user_id = $(this).data('id');

                swal.fire({
                    title: 'Are you sure?',
                    text: "Password will be reset to (spart112)!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#556ee6',
                    cancelButtonColor: '#f46a6a',
                    confirmButtonText: 'Yes, reset it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        resetPassword(user_id);
                    }
                });
            });

            function resetPassword(user_id) {
                // AJAX request
                $.ajax({
                    url: '{{ route("resetpassstaff")}}',
                    type: 'POST',
                    data: {
                        user_id: user_id
                    },
                    success: function (data) {
                        swal.fire(
                            'Success!',
                            'Password has been reset to (spart112).',
                            'success'
                        )
                    }
                });
            }

            $('#addModal').on('hidden.bs.modal', function () {
                $('#name1').val('');
                $('#username1').val('');
            });

            $('#editModal').on('hidden.bs.modal', function () {
                $('#name2').val('');
                $('#username2').val('');
                $('#editstatus2').val('');
                $('#user_id2').val('');
            });
        });
    </script>

@endsection
