<?php

namespace App\Http\Controllers;

use Log;
use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PDO;

class UserController extends Controller
{
    protected static $base_route = 'users.index';
    protected static $base_page_name = 'Kelola Pengguna';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::select('id','role_id','name','username','phone','image','email','deleted_at')
                ->with('role:id,name')
                ->orderBy('name', 'asc')
                ->get();
        $roles = Role::select('id', 'name')->get();

        return view('user.index', [
            'users' => $users,
            'roles' => $roles,
            'base_route' => self::$base_route,
            'base_page_name' => self::$base_page_name,
            'current_page_name' => 'Daftar Semua Pengguna'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $roles = Role::select('id', 'name')->get();
    //     return view('user.create',[
    //         'roles' => $roles,
    //         'base_route' => self::$base_route,
    //         'base_page_name' => self::$base_page_name,
    //         'current_page_name' => 'Tambah Pengguna Baru'
    //     ]);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        // dd($request);
        try {
            return DB::transaction(function () use ($request) {

                // Check if an image is uploaded
                $imageName = null;
                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('public/users');
                    $imageName = basename($imagePath); // Store only filename
                }

                // Create user directly
                User::create([
                    'name' => $request->name,
                    'username' => $request->username,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'password' => Hash::make('password'),
                    'image' => $imageName, // Will be NULL if no image uploaded
                    'role_id' => $request->role_id
                ]);

                // Success Redirect with message
                return redirect()->route('users.index')->with('success', 'Data Pengguna Berhasil Ditambah');
            }, 3);
        } catch (Exception $e) {
            // If an image was uploaded but transaction fails, delete it
            if (isset($imagePath) && Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }

            // Log the error
            Log::error('User creation failed: ' . $e->getMessage());

            // Redirect with an error message
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
            'base_page_name' => self::$base_page_name,
            'current_page_name' => 'Edit Pengguna'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$user->id],
            'phone' => ['required', 'string', 'max:15'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role_id' => ['integer']
        ]);

        try{
            return DB::transaction(function () use ($request, $user, $validatedData){
                //Check if a new image is uploaded
                if($request->hasFile('image')){
                    //Delete old image if exists
                    if ($user->image) {
                        Storage::delete('public/users/' . basename($user->image));
                    }

                    //Upload new image
                    $imagePath = $request->file('image')->store('public/users');
                    $validatedData['image'] = basename($imagePath);
                }

                // Update user with validated data
                $user->update($validatedData);

                // Success Redirect with message
                return redirect()->route('users.index')->with('success', 'Data Pengguna Berhasil Diperbarui');
            });
        }catch(Exception $e){
            // If an image was uploaded but transaction fails, delete it
            if (isset($imagePath) && Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }

            // Log the error
            Log::error('User creation failed: ' . $e->getMessage());

            // Redirect with an error message
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
        return redirect()->route('users.index')->with('success', 'Data Pengguna Berhasil Dihapus');

    }
}
