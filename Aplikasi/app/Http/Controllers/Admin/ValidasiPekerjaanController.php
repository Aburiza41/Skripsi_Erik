<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValidasiPekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guestLands = \App\Models\GuestLand::where('status_proses', '=', '6')->get();
        // dd($guestLands);
        return view('pages.admin.proses-pekerjaan.validasi-pekerjaan.index')->with(compact('guestLands'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $type)
    {
        // dd($type);
        if ($type == 'selesai') {
            $validated = $request->validate([
                'status_proses' => 'nullable|numeric',
            ]);
            $guestLand = \App\Models\GuestLand::find($id);

            \App\Models\GuestLand::find($id)->update([
                'status_proses' => $validated['status_proses'],
                'created_at' => now(),
            ]);
            // dd($guestLand);
            // dd($status);

            \App\Models\StatusPekerjaan::create([
                'guest_land_id' => $guestLand->id,
                'status_pekerjaan' => $validated['status_proses'],
                'batas_waktu_pekerjaan' => "",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            session(['success' => 'Berhasil Menambahkan Data']);
            return back();
        } elseif ($type == 'update') {
        } else {
            abort(404);
        }
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
