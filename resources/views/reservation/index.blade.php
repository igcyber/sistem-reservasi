@extends('layouts.app')
@section('content')

@include('partials.page-title')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                {{-- <a href="{{ route('reservations.create') }}" class="btn btn-primary waves-effect waves-light bx-pull-right">Tambah Reservasi</a> --}}
                <button type="button" class="btn btn-primary waves-effect waves-light bx-pull-right" data-bs-toggle="modal" data-bs-target="#createReservationModal">
                    Tambah Reservasi
                </button>
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
                                @if($reservation->reservation_status === 'cancelled')
                                    <span class="badge badge-soft-danger text-uppercase">
                                        {{ $reservation->reservation_status }}
                                    </span>
                                @else
                                    <button class="btn {{getStatusBadge($reservation->reservation_status, 'reservation') }} btn-sm btnStatusReservation text-uppercase" Uid="{{ $reservation->id }}"  status="{{ $reservation->reservation_status }}">
                                        {{ $reservation->reservation_status }}
                                    </button>
                                @endif


                            </td>
                            <td>
                                @if($reservation->reservation_status === 'cancelled')
                                    <span class="badge badge-soft-danger text-uppercase">
                                        cancelled
                                    </span>
                                @else
                                    <button class="btn {{getStatusBadge($reservation->payment_status, 'payment') }} btn-sm btnStatusPayment text-uppercase" Uid="{{ $reservation->id }}" status="{{ $reservation->payment_status }}">
                                        {{ $reservation->payment_status }}
                                    </button>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @if($reservation->reservation_status == 'cancelled')
                                            <li>
                                                <button class="dropdown-item remove-item-btn" onclick="confirmDelete({{ $reservation->id }})">
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                </button>
                                                <form id="delete-form-{{ $reservation->id }}" action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </li>
                                        @else
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
                                        @endif
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
@include('reservation.__create-modal')
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

        // Inisialisasi Select2 untuk dropdown
        $('.js-example-basic-single').select2();

        // Inisialisasi kembali Select2 setelah validasi gagal
        @if ($errors->any())
            $('#user_id').val('{{ old('user_id') }}').trigger('change');
            $('#consultant_id').val('{{ old('consultant_id') }}').trigger('change');
        @endif
    })

    const today = new Date().toISOString().split('T')[0];
    document.getElementById('reservation_date').setAttribute('min', today);
    document.getElementById('reservation_date').value = today;
    const pricePerHour = 5000;

    document.getElementById('start_time').addEventListener('change', function(){
        const startTime = this.value;

        if(startTime){
            const startDate = new Date(`1970-01-01T${startTime}:00`);
            startDate.setHours(startDate.getHours() + 1);
            const endTime = startDate.toTimeString().slice(0, 5);
            document.getElementById('end_time').value = endTime;

            const total = pricePerHour;

            // Format sebagai mata uang Rupiah
            const formattedTotal = new Intl.NumberFormat('id-ID').format(total);

            // Tampilkan di input field dengan format Rupiah
            document.getElementById('total_amount_format').value = 'Rp. ' + formattedTotal;

            // Simpan nilai total dalam bentuk integer untuk disimpan ke database
            document.getElementById('total_amount').value = total.toFixed(0);

        }else{
            document.getElementById('end_time').value= "";
            document.getElementById('total_amount').value = "";
            document.getElementById('total_amount_format').value = "";
        }
    });

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

    $(".table").on('click', '.btnStatusReservation', function(){
        var Uid = $(this).attr('Uid');
        var status = $(this).attr('status');

        $.ajax({
            url: '/status-reservation/'+Uid+'/'+status,
            type: 'GET',
            success: function(){
                Swal.fire({
                    title: 'Proses Selesai',
                    text: 'Status Berhasil Diperbarui',
                    icon: 'success'
                }).then(() => {
                    location.reload();
                });
            }
        })
    })

    $(".table").on('click', '.btnStatusPayment', function(){
        var Uid = $(this).attr('Uid');
        var status = $(this).attr('status');

        $.ajax({
            url: '/status-payment/'+Uid+'/'+status,
            type: 'GET',
            success: function(){
                Swal.fire({
                    title: 'Proses Selesai',
                    text: 'Status Berhasil Diperbarui',
                    icon: 'success'
                }).then(() => {
                    location.reload();
                });
            }
        })
    })

      // Pastikan modal terbuka jika ada error pada form
    @if($errors->any())
        // Menampilkan modal ketika ada error
        var myModal = new bootstrap.Modal(document.getElementById('createReservationModal'));
        myModal.show();
    @endif

</script>
@endpush
