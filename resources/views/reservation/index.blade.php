@extends('layouts.app')
@section('content')

@include('partials.page-title')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('reservations.create') }}" class="btn btn-primary waves-effect waves-light bx-pull-right">Tambah Reservasi</a>
                <h5 class="card-title mb-0">Daftar Semua Reservasi</h5>
            </div>
            <div class="card-body">
                <table id="reservationsTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Klien</th>
                            <th>Konsultan</th>
                            <th>Tanggal Reservasi</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Status Reservasi</th>
                            <th>Status Pembayaran</th>
                            <th>Pilihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $reservation )
                        <tr>
                            <th style="text-align: center">
                                {{ $loop->iteration }}
                            </th>
                            <td>
                                {{ $reservation->user->name ?? 'Klien Sudah Tidak Terdaftar' }}
                            </td>
                            <td>
                                {{ $reservation->consultant->name ?? 'Konsultan Sudah Tidak Terdaftar' }}
                            </td>
                            <td>
                                {{ format_date($reservation->reservation_date) }}
                            </td>
                            <td>
                                {{ $reservation->start_time }}
                            </td>
                            <td>
                                {{ $reservation->end_time }}
                            </td>
                            <td>
                                <span class="badge {{ getStatusBadge($reservation->reservation_status, 'reservation') }} text-uppercase">
                                    {{ $reservation->reservation_status }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ getStatusBadge($reservation->payment_status, 'payment') }} text-uppercase">
                                    {{ $reservation->payment_status }}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item edit-item-btn" href="{{ route('reservations.edit', $reservation->id) }}">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item btn-cancel" data-id="{{ $reservation->id }}">
                                                <i class="ri-close-circle-fill align-bottom me-2 text-muted"></i> Cancel
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item remove-item-btn" onclick="confirmDelete({{ $reservation->id }})">
                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                            </button>
                                            <form id="delete-form-{{ $reservation->id }}" action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display: none;">
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

@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('#reservationsTable').DataTable({
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

    $(document).on('click', '.btn-cancel', function(e){
        e.preventDefault();
        var reservationId = $(this).data('id');

        Swal.fire({
            title: "Batalkan Pesanan?",
            text: "Pastikan anda mengkonfirmasi kembali ke pengguna!",
            input: 'textarea',
            inputPlaceholder: 'Isikan alasan pembatalan reservasi!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "Konfirmasi Pembatalan!",
            cancelButtonText: "Tutup!",
            preConfirm: (cancellationReason) => {

                if(!cancellationReason){
                    Swal.showValidationMessage('Alasan pembatalan wajib diisi');
                    return false;
                }

                return new Promise((resolve) => {
                    $.ajax({
                        url: "{{ route('reservations.cancel') }}",
                        method: "POST",
                        data:{
                            _token: "{{ csrf_token() }}",
                            reservation_id: reservationId,
                            cancel_reason: cancellationReason,
                        },
                        success: function(response){
                            if(response.success){
                                Swal.fire({
                                    title: 'Proses Selesai',
                                    text: response.message,
                                    icon: 'success',
                                }).then(() => {
                                    location.reload();
                                })
                            }else{
                                Swal.fire({
                                    title: 'Proses Berhenti',
                                    text: response.message,
                                    icon: 'error'
                                });
                            }
                            resolve();
                        },
                        error: function(){
                            Swal.fire({
                                title: 'Terjadi Kesalahan',
                                text: 'Gagal membatalkan reservasi',
                                icon: 'error',
                            });
                            resolve();
                        }
                    });
                });
            }
        });

    });

</script>
@endpush
