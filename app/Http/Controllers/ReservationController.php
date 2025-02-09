<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ReservationRequest;

class ReservationController extends Controller
{

    protected static $base_route = 'reservations.index';
    protected static $base_page_name = 'Kelola Reservasi';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::select('id','user_id','consultant_id','reservation_date','start_time','end_time','reservation_status','payment_status','total_amount','cancel_reason')->with(['user', 'consultant'])->get();
        return view('reservation.index', [
            'reservations' => $reservations,
            'base_route' => self::$base_route,
            'base_page_name' => self::$base_page_name,
            'current_page_name' => 'Daftar Semua Reservasi'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select('id','role_id','name')->where('role_id', 3)->whereNull('deleted_at')->get();
        $consultants = User::select('id','role_id','name')->where('role_id', 2)->whereNull('deleted_at')->get();
        return view('reservation.create',[
            'users' => $users,
            'consultants' => $consultants,
            'base_route' => self::$base_route,
            'base_page_name' => self::$base_page_name,
            'current_page_name' => 'Tambah Reservasi Baru'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationRequest $request)
    {
        try{
            return DB::transaction(function () use ($request){
                Reservation::create([
                    'user_id' => $request->user_id,
                    'consultant_id' => $request->consultant_id,
                    'reservation_date' => $request->reservation_date,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'reservation_status' => $request->reservation_status,
                    'payment_status' => $request->payment_status,
                    'total_amount' => $request->total_amount ?? 0 ,
                    'cancel_reason' => $request->cancel_reason ?? ''
                ]);

                // Success Redirect with message
                return redirect()->route('reservations.index')->with('success', 'Reservasi Berhasil Ditambahkan');
            }, 3);
        }catch(Exception $e){

            // Log the error
            Log::error('User creation failed: ' . $e->getMessage());

            // Redirect with an error message
            return redirect()->route('reservations.index')->with('error', 'Reservasi Gagal Ditambahkan');
        }


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        $users = User::where('role_id', 3)->whereNull('deleted_at')->get();
        $consultants = User::where('role_id', 2)->whereNull('deleted_at')->get();

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
