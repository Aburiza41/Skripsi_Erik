<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestLandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $guestLands = \App\Models\GuestLand::where('status_pengerjaan', '=', '0')->get();
        $guestLands = \App\Models\GuestLand::get();
        return view('pages.admin.guest-land.index')->with(compact('guestLands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $desa = \App\Models\Village::get();
        $petugas = \App\Models\User::where('level', '=', '1')->get();
        return view('pages.admin.guest-land.create')->with(compact('desa', 'petugas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \App\Models\StatusPekerjaan::truncate();
        \App\Models\GuestLand::truncate();
        // dd($request->input());
        $validated = $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'nomor_sertifikat' => 'required|numeric',
            'nib' => 'required|numeric',
            'desa' => 'required|numeric',
            'nomor_telpon' => 'required|numeric|min:10',
            'nomor_hak' => 'nullable|numeric',
            'petugas' => 'nullable|numeric',
            'batas_waktu_pekerjaan' => 'required|date',
        ]);

        $status = 0;
        if ($validated['petugas'] !== null) {
            $status = 1;
        }

        $guestLand = \App\Models\GuestLand::create([
            'user_id' => $validated['petugas'],
            'nama_pemilik' => $validated['nama_pemilik'],
            'nomor_sertifikat' => $validated['nomor_sertifikat'],
            'nib' => $validated['nib'],
            'village_id' => $validated['desa'],
            'nomor_telpon' => $validated['nomor_telpon'],
            'nomor_hak' => $validated['nomor_hak'],
            'status_proses' => $status,
            'batas_waktu_proses' => $validated['batas_waktu_pekerjaan'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // dd($guestLand);

        \App\Models\StatusPekerjaan::create([
            'guest_land_id' => $guestLand->id,
            'status_pekerjaan' => $status,
            'batas_waktu_pekerjaan' => $validated['batas_waktu_pekerjaan'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($status == 1) {
            \App\Models\StatusPekerjaan::create([
                'guest_land_id' => $guestLand->id,
                'status_pekerjaan' => $status,
                'batas_waktu_pekerjaan' => $validated['batas_waktu_pekerjaan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        session(['success' => 'Berhasil Menambahkan Data']);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd($id);
        $guestLand = \App\Models\GuestLand::find($id);
        return view('pages.admin.guest-land.show')->with(compact('guestLand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guestLand = \App\Models\GuestLand::find($id)->first();
        $desa = \App\Models\Village::get();
        $petugas = \App\Models\User::where('level', '=', '1')->get();
        // dd($guestLand);
        return view('pages.admin.guest-land.edit')->with(compact('desa', 'petugas', 'guestLand'));
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
        // dd($request->input());

        // dd($guestLand->statusPekerjaans);
        $validated = $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'nomor_sertifikat' => 'required|numeric',
            'nib' => 'required|numeric',
            'desa' => 'required|string|max:255',
            'nomor_telpon' => 'required|numeric|min:10',
            'nomor_hak' => 'required|numeric|min:10',
            'petugas' => 'nullable|numeric',
            'batas_waktu_pekerjaan' => 'nullable|date',
        ]);
        $guestLand = \App\Models\GuestLand::find($id);

        $status = $guestLand->status_proses;
        if ($validated['petugas'] !== null) {
            $status = 1;
        }

        \App\Models\GuestLand::find($id)->update([
            'user_id' => $validated['petugas'],
            'nama_pemilik' => $validated['nama_pemilik'],
            'nomor_sertifikat' => $validated['nomor_sertifikat'],
            'nib' => $validated['nib'],
            'village_id' => $validated['desa'],
            'nomor_telpon' => $validated['nomor_telpon'],
            'nomor_hak' => $validated['nomor_hak'],
            'status_proses' => $status,
            'batas_waktu_proses' => $validated['batas_waktu_pekerjaan'],
            'created_at' => now(),
        ]);
        // dd($guestLand);
        // dd($status);

        \App\Models\StatusPekerjaan::create([
            'guest_land_id' => $guestLand->id,
            'status_pekerjaan' => $status,
            'batas_waktu_pekerjaan' => $validated['batas_waktu_pekerjaan'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session(['success' => 'Berhasil Menambahkan Data']);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guestLand = \App\Models\GuestLand::find($id)->delete();
        session(['success' => 'Berhasil Menambahkan Data']);
        return back();
    }
}
