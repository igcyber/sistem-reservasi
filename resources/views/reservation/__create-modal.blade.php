<div class="modal fade fadeInRight" id="createReservationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="createReservationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createReservationModalLabel">Tambah Reservasi Baru</h5>
            </div>
            <hr>
            <div class="modal-body px-3 py-2">
                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-xxl-6">
                            <label for="user_id" class="form-label">Klien</label>
                            <select id="user_id" class="form-select @error('user_id') is-invalid @enderror js-example-basic-single" name="user_id">
                                <option selected disabled value="">Pilih Klien</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-xxl-6">
                            <label for="consultant_id" class="form-label">Konsultan</label>
                            <select id="consultant_id" class="form-select @error('consultant_id') is-invalid @enderror js-example-basic-single" name="consultant_id">
                                <option selected disabled value="">Pilih Konsultan</option>
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

                        <div class="col-xxl-6">
                            <label for="start_time" class="form-label">Jam Mulai</label>
                            <input type="time" value="{{ old('start_time') }}"
                            class="form-control @error('start_time') is-invalid @enderror"
                            placeholder="Pilih Jam Mulai"
                            name="start_time" id="start_time">

                            @error('start_time')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xxl-6">
                            <label for="end_time" class="form-label">Jam Selesai</label>
                            <input type="time" value="{{ old('end_time') }}"
                            class="form-control" name="end_time" id="end_time" readonly>
                        </div>

                        <div class="col-xxl-6">
                            <label for="reservation_date" class="form-label">Tanggal Reservasi </label>
                            <input type="date" class="form-control @error('reservation_date') is-invalid @enderror" name="reservation_date" value="{{ old('reservation_date') }}"  id="reservation_date">
                            @error('reservation_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xxl-6">
                            <label for="total_amount_format" class="form-label">Total Pembayaran</label>
                            <input type="text" class="form-control" id="total_amount_format" readonly>

                            <!-- Hidden field untuk menyimpan nilai asli dalam bentuk integer/decimal -->
                            <input type="hidden" id="total_amount" name="total_amount">
                        </div>

                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                {{-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button> --}}
                                <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Tutup</a>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </form>
            </div>
        </div>
    </div>
</div>

