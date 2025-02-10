<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    //Accessor start_time
    public function getStartTimeAttribute($value){
        return Carbon::parse($value)->format('H:i');
    }

    //Accessor end_time
    public function getEndTimeAttribute($value){
        return Carbon::parse($value)->format('H:i');
    }
}
