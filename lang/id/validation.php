<?php

return [
    'required' => ':attribute wajib diisi.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'min' => [
        'string' => ':attribute minimal harus :min karakter.',
    ],
    'max' => [
        'string' => ':attribute maksimal :max karakter.',
    ],
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'unique' => ':Attribute sudah digunakan, silakan pilih yang lain.',
    'numeric' => ':attribute harus berupa angka.',
    'integer' => ':attribute harus sesuai pilihan',
    'exists' => ':attribute pilihan tidak ada',
    'after_or_equal' => ':attribute harus setelah atau tepat pukul :date.',
    'before_or_equal' => ':attribute harus sebelum atau tepat pukul :date.',
    'after' => ':attribute harus diisi setelah :date.',

    'attributes' => [
        'name' => 'Nama lengkap',
        'username' => 'Nama pengguna',
        'password' => 'Kata sandi',
        'password_confirmation' => 'Konfirmasi kata sandi',
        'email' => 'Alamat email',
        'phone' => 'Nomor handphone',
        'role_id' => 'Hak Akses',
        'user_id' => 'Klien',
        'consultant_id' => 'Konsultan',
        'start_time' => 'Jam mulai',
        'end_time' => 'Jam selesai',
        'reservation_date' => 'Tanggal reservasi'
    ],
];
