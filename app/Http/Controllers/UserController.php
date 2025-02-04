<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected static $base_route = 'users.index';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::select('id','role_id','name','username','phone','image','email','deleted_at')
                ->with('role:id,name')
                ->orderBy('name', 'asc')
                ->get();

        return view('user.index', [
            'users' => $users,
            'base_route' => self::$base_route,
            'current_route' => 'Daftar Semua Pengguna'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::select('id', 'name')->get();
        return view('user.create',[
            'roles' => $roles,
            'base_route' => self::$base_route,
            'current_route' => 'Tambah Pengguna Baru'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $request->validated();

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/users', $image->hashName());

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'image' => $image->hashName(),
            'role_id' => $request->role_id
        ]);

        if($user){
            return redirect()->route('users.index')->with('success', 'Data Pengguna Berhasil Ditambah');
        }else{
            return redirect()->route('users.index')->with('error', 'Data Pengguna Gagal Ditambah');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::select('id', 'name')->get();
        return view('user.edit', [
            'roles' => $roles,
            'user' => $user,
            'base_route' => self::$base_route,
            'current_route' => 'Edit Pengguna'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$user->id],
            'phone' => ['required', 'string', 'max:15'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role_id' => ['required', 'integer']
        ]);

        if($request->file('image') == ''){
            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'phone' => $request->phone,
                'email' => $request->email,
                'role_id' => $request->role_id
            ]);
        }else{
            //delete image lama
            Storage::disk('local')->delete('public/users' . basename($user->image) );

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/users', $image->hashName());

            //update dengan image
            $user->update([
                'image' => $image->hashName(),
                'name' => $request->name,
                'username' => $request->username,
                'phone' => $request->phone,
                'email' => $request->email,
                'role_id' => $request->role_id
            ]);

        }

        if($user){
            return redirect()->route('users.index')->with('success', 'Data Pengguna Berhasil Diperbarui');
        }else{
            return redirect()->route('users.index')->with('error', 'Data Pengguna Gagal Diperbarui');
        }



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Storage::disk('local')->delete('public/users' . basename($user->image) );
        $user->delete();

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Data Pengguna Berhasil Dihapus');

    }
}
