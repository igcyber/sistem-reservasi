@extends('layouts.app')
@section('content')

@include('partials.page-title')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                {{-- <a href="{{ route('users.create') }}" class="btn btn-primary waves-effect waves-light bx-pull-right">Tambah Pengguna</a> --}}
                <!-- Tambah Pengguna -->
                <button type="button" class="btn btn-primary waves-effect waves-light bx-pull-right" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    Tambah Pengguna
                </button>
                <h5 class="card-title mb-0">Daftar Semua Pengguna</h5>
            </div>
            <div class="card-body">
                <table id="usersTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Nomor Handphone</th>
                            <th>Hak Akses</th>
                            <th>Email</th>
                            <th>Pilihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user )
                        <tr>
                            <th style="text-align: center">
                                {{ $loop->iteration }}
                            </th>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->username }}
                            </td>
                            <td>
                                {{ $user->phone }}
                            </td>
                            <td>
                                {{ $user->role->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item edit-item-btn" href="{{ route('users.edit', $user->id) }}">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <button class="dropdown-item remove-item-btn" onclick="confirmDelete({{ $user->id }})">
                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                            </button>
                                            <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div><!--end col-->
</div><!--end row-->

{{-- create user modal --}}
@include('user.__create-modal')

@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('#usersTable').DataTable({
            responsive: true,
            language:{
                search: "Cari Data :",
                zeroRecords: "Tidak ada data yang ditemukan",
                infoEmpty: "Tidak ada data tersedia",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    })

    // Pastikan modal terbuka jika ada error pada form
    @if($errors->any())
        // Menampilkan modal ketika ada error
        var myModal = new bootstrap.Modal(document.getElementById('createUserModal'));
        myModal.show();
    @endif

</script>
@endpush
