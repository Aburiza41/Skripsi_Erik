<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PemilihanPetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guestLands = \App\Models\GuestLand::get();
        // dd($guestLands);
        return view('pages.admin.proses-pekerjaan.pemilihan-petugas.index')->with(compact('guestLands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guestLand = \App\Models\GuestLand::find($id);
        $petugas = \App\Models\User::where('level', '=', '1')->get();
        return view('pages.admin.proses-pekerjaan.pemilihan-petugas.edit')->with(compact('guestLand', 'petugas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'petugas' => 'required|numeric',
            'batas_waktu_pekerjaan' => 'required|date',
        ]);

        $guestLand = \App\Models\GuestLand::find($id);

        $guestLand->user_id = $validated['petugas'];

        $guestLand->save();

        $status_pekerjaan = \App\Models\StatusPekerjaan::create([
            'guest_land_id' => $guestLand->id,
            'status_pekerjaan' => 1,
            'batas_waktu_pekerjaan' => $validated['petugas'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session(['success' => 'Berhasil Menambahkan Petugas']);
        return redirect()->route('adminPemilihanPetugas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
