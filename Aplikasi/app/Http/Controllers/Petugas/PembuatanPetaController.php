<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembuatanPetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guestLands = \App\Models\GuestLand::where([['user_id', '=', \Illuminate\Support\Facades\Auth::user()->id], ['status_proses', '=', '5']])->get();
        return view('pages.petugas.proses-pekerjaan.pembuatan-peta.index')->with(compact('guestLands'));
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
        // dd($id);
        $guestLand = \App\Models\GuestLand::where('id', '=', $id)->first();
        // dd($guestLand);
        return view('pages.petugas.proses-pekerjaan.pembuatan-peta.edit')->with(compact('guestLand'));
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
            'luas_bidang' => 'required|numeric',
            'koordinat_bidang' => 'required|file',
            'peta_bidang' => 'required|file|mimetypes:application/pdf',
            'status_pengerjaan' => 'required',
        ]);

        $array = explode('.', $request->koordinat_bidang->getClientOriginalName());

        if ($array['1'] !== "geojson") {
            return back()
                ->withErrors("file koordinat bidang not geojson format")
                ->withInput();
        }

        $koordinat_bidang = \Illuminate\Support\Facades\Storage::disk('public')->put('koordinat-bidang', $validated['koordinat_bidang']);
        $peta_bidang = \Illuminate\Support\Facades\Storage::disk('public')->put('peta-bidang', $validated['peta_bidang']);
        // dd($peta_bidang);
        $guesland = \App\Models\GuestLand::find($id);

        $guesland->luas_tanah = $validated['luas_bidang'];
        $guesland->koordinat_bidang = $koordinat_bidang;
        $guesland->peta_bidang = $peta_bidang;
        $guesland->status_proses = $validated['status_pengerjaan'];
        $guesland->save();

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
        //
    }
}
