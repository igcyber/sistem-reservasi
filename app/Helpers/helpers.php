<?php

use Illuminate\Support\Carbon;

if (!function_exists('getStatusBadge')) {
    function getStatusBadge($status, $type = 'reservation')
    {
        $statusClasses = [
            'reservation' => [
                'pending' => 'btn-warning',
                'confirmed' => 'btn-success',
                'cancelled' => 'btn-danger',
            ],
            'payment' => [
                'pending' => 'btn-warning',
                'paid' => 'btn-success',
                'failed' => 'btn-danger',
            ],
        ];

        return $statusClasses[$type][$status] ?? 'btn-secondary';
    }
}

if (!function_exists('format_date')) {
    /**
     * Format a date to dd-mm-yyyy.
     *
     * @param string|null $date
     * @return string|null
     */
    function format_date($date)
    {
        return $date ? Carbon::parse($date)->format('d-m-Y') : null;
    }
}


if(!function_exists('formatRupiah')) {
 /**
     * Format angka ke dalam format mata uang Rupiah
     *
     * @param  float  $amount
     * @return string
     */
    function formatRupiah($amount)
    {
        // Format angka dengan pembatas ribuan dan prefix "Rp"
        return "Rp " . number_format($amount, 0, ',', '.');
    }
}
