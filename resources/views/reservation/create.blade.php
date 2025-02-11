@extends('layouts.app')
@section('content')
    @include('partials.page-title')

    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tambah Reservasi Baru</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <form action="{{ route('reservations.store') }}" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Klien</label>
                                    <select id="user_id" class="form-select @error('user_id') is-invalid @enderror" name="user_id" data-choices data-choices-sorting="true">
                                        <option selected>Pilih Klien</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="consultant_id" class="form-label">Konsultan</label>
                                    <select id="consultant_id" class="form-select @error('consultant_id') is-invalid @enderror" name="consultant_id" data-choices data-choices-sorting="true">
                                        <option selected>Pilih Konsultan</option>
                                        @foreach($consultants as $consultant)
                                        <option value="{{ $consultant->id }}">{{ $consultant->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('consultant_id')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Jam Mulai</label>
                                    <input type="time" value="{{ old('start_time') }}"
                                           class="form-control @error('start_time') is-invalid @enderror"
                                           placeholder="Pilih Jam Mulai"
                                           name="start_time" id="start_time">

                                    @error('start_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">Jam Selesai</label>
                                    <input type="time" value="{{ old('end_time') }}"
                                           class="form-control" name="end_time" id="end_time" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reservation_date" class="form-label">Tanggal Reservasi </label>
                                    <input type="date" class="form-control @error('reservation_date') is-invalid @enderror" name="reservation_date" value="{{ old('reservation_date') }}"  id="reservation_date">
                                    @error('reservation_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reservation_status" class="form-label">Status Reservasi</label>
                                    <select id="reservation_status" class="form-select @error('reservation_status') is-invalid @enderror" name="reservation_status" data-choices data-choices-sorting="true">
                                        <option selected>Pilih Status Reservasi</option>
                                        <option value="pending">Ditunda</option>
                                        <option value="confirmed">Dikonfirmasi</option>
                                        <option value="cancelled">Dibatalkan</option>
                                    </select>
                                    @error('reservation_status')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="total_amount_format" class="form-label">Total Pembayaran</label>
                                    <input type="text" class="form-control" id="total_amount_format" readonly>

                                    <!-- Hidden field untuk menyimpan nilai asli dalam bentuk integer/decimal -->
                                    <input type="hidden" id="total_amount" name="total_amount">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_status" class="form-label">Status Pembayaran</label>
                                    <select id="payment_status" class="form-select @error('payment_status') is-invalid @enderror" name="payment_status" data-choices data-choices-sorting="true">
                                        <option selected>Pilih Status Pembayaran</option>
                                        <option value="pending">Ditunda</option>
                                        <option value="paid">Dibayar</option>
                                        <option value="failed">Digagalkan</option>
                                    </select>
                                    @error('payment_status')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection

@push('scripts')
    <script>
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
                document.getElementById('total_amount_format').value = 'Rp .' + formattedTotal;

                // Simpan nilai total dalam bentuk integer untuk disimpan ke database
                document.getElementById('total_amount').value = total.toFixed(0);
            }else{
                document.getElementById('end_time').value= "";
                document.getElementById('total_amount').value = "";
                document.getElementById('total_amount_format').value = "";
            }
        });
    </script>

@endpush
