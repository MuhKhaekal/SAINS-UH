<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('users')
                    ->select('id', 'name', 'nim', 'email')
                    ->get();
        
        return view('dashboard.admin.index', compact('users'));
    }

    public function create()
    {
        return view('dashboard.admin.create-user');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|unique:users,nim',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|string|max:1',
            'password' => 'required|min:8',
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'nim' => $request->nim,
            'email' => $request->email,
            'gender' => $request->gender,       
            'password' => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = DB::table('users')
                    ->where('id', $id)
                    ->first();
        
        return view('dashboard.admin.edit-user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|unique:users,nim,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        $data = [
            'name' => $request->name,
            'nim' => $request->nim,
            'email' => $request->email,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('users')
            ->where('id', $id)
            ->update($data);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::table('users')
            ->where('id', $id)
            ->delete();

        return redirect()->route('admin.users.index')
                        ->with('success', 'User berhasil dihapus');
    }
}