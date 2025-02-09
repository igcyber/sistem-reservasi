<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'consultant_id',
        'reservation_date',
        'start_time',
        'end_time',
        'reservation_status',
        'total_amount',
        'payment_status',
        'cancel_reason'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function consultant(){
        return $this->belongsTo(User::class, 'consultant_id');
    }

    public function reservation_detail(){
        return $this->hasOne(ReservationDetail::class);
    }
}
