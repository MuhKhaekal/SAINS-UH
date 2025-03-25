<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faculties = DB::table('faculties')
                    ->select('id', 'fakultas_name')
                    ->get();

        return view('dashboard.admin.index', compact('faculties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.create-fakultas');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fakultas_name' => 'required|string|max:255',
        ]);

        DB::table('faculties')->insert([
            'fakultas_name' => $request->fakultas_name,
        ]);

        return redirect()->route('admin.fakultas.index')
                        ->with('success', 'Fakultas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $faculty = DB::table('faculties')
    //                 ->where('id', $id)
    //                 ->first();

    //     return view('dashboard.admin.show-fakultas', compact('faculty'));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $faculty = DB::table('faculties')
                        ->where('id', id)
                        ->first();
        return view ('dashboard.admin.edit-faculty', compact('faculty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'fakultas_name' => 'required|string|max:255'
        ]);

        $data = [
            'fakultas_name' => $request->fakultas_name
        ];

        DB::table('faculties')
            ->where('id',id)
            ->update($data);

        return redirect()->route('admin.faculties')
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
