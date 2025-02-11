<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
                return redirect()->route('reservations.index')->with('success', 'Data Reservasi Berhasil Diperbarui');
            }, 3);
        }catch(Exception $e){

            // Log the error
            Log::error('Reservation creation failed: ' . $e->getMessage());

            // Redirect with an error message
            return redirect()->route('reservations.index')->with('error', 'Data Reservasi Gagal Ditambahkan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        $users = User::where('role_id', 3)->whereNull('deleted_at')->get();
        $consultants = User::where('role_id', 2)->whereNull('deleted_at')->get();
        // dd($users, $consultants);
        return view('reservation.edit',[
            'reservation' => $reservation,
            'users' => $users,
            'consultants' => $consultants,
            'base_route' => self::$base_route,
            'base_page_name' => self::$base_page_name,
            'current_page_name' => 'Edit Reservasi'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'consultant_id' => 'required|exists:users,id',
            'reservation_date' => 'required|date',
            'start_time' => 'required|date_format:H:i|after_or_equal:09:00|before_or_equal:15:00',
            'end_time' => 'required|date_format:H:i',
            'reservation_status' => 'required|in:pending,confirmed,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
            'total_amount' => 'nullable|numeric|min:0',
            'cancel_reason' => 'nullable|string'
        ]);

        try{
            return DB::transaction(function() use ($reservation, $validatedData){

                // Update user with validated data
                $reservation->update($validatedData);

                // Success Redirect with message
                return redirect()->route('reservations.index')->with('success', 'Data Reservasi Berhasil Diperbarui');

            });
        }catch(Exception $e){
            // Log the error
            Log::error('Reservation creation failed: ' . $e->getMessage());

            // Redirect with an error message
            return redirect()->route('reservations.index')->with('error', 'Data Reservasi Gagal Diperbarui');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Data Reservasi Berhasil Dihapus');
    }

    public function cancel(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'cancel_reason' => 'required|string'
        ]);

        $reservation = Reservation::findOrFail($request->reservation_id);
        $reservation->reservation_status = 'cancelled';
        $reservation->cancel_reason = $request->cancel_reason;
        $reservation->save();

        return response()->json([
            'success' => true,
            'message' => 'Reservasi telah dibatalkan, mohon hubungi kembali pengguna'
        ]);
    }

    public function getAllReservations()
    {
        $reservations = Reservation::all();
        $events = [];
        foreach($reservations as $reservation)
        {
            // Tentukan warna berdasarkan status reservasi
            $color = match ($reservation->reservation_status) {
                'cancelled' => '#dc3545', // Merah (danger)
                'confirmed' => '#28a745', // Hijau (success)
                'pending' => '#ffc107', // Kuning (warning)
            };

            $events[] = [
                'title' => 'Reservasi atas nama ' . $reservation->user->name . ' Konsultasi dengan ' . $reservation->consultant->name,
                'start' => $reservation->reservation_date .'T'. $reservation->start_time,
                'end' => $reservation->reservation_date .'T'. $reservation->end_time,
                'backgroundColor' => $color,
                'borderColor' => $color,
            ];
        }
        return response()->json($events);
    }
}
