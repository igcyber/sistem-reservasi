<?php

return [
    'required' => ':attribute wajib diisi.',
    'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
    'min' => [
        'string' => 'Kolom :attribute minimal harus :min karakter.',
    ],
    'max' => [
        'string' => 'Kolom :attribute maksimal :max karakter.',
    ],
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'unique' => ':Attribute sudah digunakan, silakan pilih yang lain.',
    'numeric' => 'Kolom :attribute harus berupa angka.',

    'attributes' => [
        'name' => 'Nama lengkap',
        'username' => 'Nama pengguna',
        'password' => 'Kata sandi',
        'password_confirmation' => 'Konfirmasi kata sandi',
        'email' => 'Alamat email',
        'phone' => 'Nomor handphone',
    ],
];
