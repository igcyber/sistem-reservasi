<?php

use Illuminate\Support\Carbon;

if (!function_exists('getStatusBadge')) {
    function getStatusBadge($status, $type = 'reservation')
    {
        $statusClasses = [
            'reservation' => [
                'pending' => 'badge-soft-warning',
                'confirmed' => 'badge-soft-success',
                'cancelled' => 'badge-soft-danger',
            ],
            'payment' => [
                'pending' => 'badge-soft-warning',
                'paid' => 'badge-soft-success',
                'failed' => 'badge-soft-danger',
            ],
        ];

        return $statusClasses[$type][$status] ?? 'badge-secondary';
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
