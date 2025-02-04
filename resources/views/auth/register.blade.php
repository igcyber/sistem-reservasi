@extends('layouts.guest')
@section('content')
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                            <a href="#" class="d-inline-block auth-logo">
                                <img src="{{ asset('assets/images/icon-customer-service.png') }}" alt="" height="120">
                            </a>
                        </div>
                        <p class="mt-3 fs-15 fw-medium">Sistem Reservasi Konsultasi Berbasis Web</p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Selamat Datang!</h5>
                                <p class="text-muted">Silahkan isi form untuk mendaftar.</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="needs-validation">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control pe-5 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Isikan nama lengkap anda">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control pe-5 @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" placeholder="Isikan username anda">
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Nomor Handphone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control pe-5 @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Isikan nomor handphone anda">
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Alamat Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control pe-5 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Isikan alamat email anda">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password-input">Password <span class="text-danger">*</span></label>
                                        <div class="position-relative input-group mb-3">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Isikan password anda" name="password" id="password-input">


                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-primary text-decoration-none" type="button" type="button" id="password-toggle">
                                                    <i class="ri-eye-fill align-middle"></i>
                                                </button>
                                            </div>

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password-confirmed">Konfirmasi Password <span class="text-danger">*</span></label>
                                        <div class="position-relative input-group mb-3">
                                            <input type="password" class="form-control" placeholder="Tulis ulang password anda" name="password_confirmation" id="password-confirmed">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-primary text-decoration-none" type="button" type="button" id="password-toggle">
                                                    <i class="ri-eye-fill align-middle"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="image-profile">Gambar Profil</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="file" class="form-control" name="image" id="image-profile">
                                            @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <p class="text-muted"><span class="text-danger">* </span> Wajib diisi</p>
                                        <button class="btn btn-success w-100" type="submit">Register</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center">
                        <p class="mb-0">Sudah punya akun ? <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline"> Login </a> </p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const togglePasswordBtn = document.querySelector('#password-toggle');
            const passwordInput = document.querySelector('#password-input');

            togglePasswordBtn.addEventListener('click', function(){
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
            });
        });
    </script>
@endpush
