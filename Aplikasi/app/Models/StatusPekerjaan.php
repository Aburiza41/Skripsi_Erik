<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPekerjaan extends Model
{
    use HasFactory;
    protected $fillable = ['guest_land_id', 'status_pekerjaan', 'batas_waktu_pekerjaan'];

    public function guesLand()
    {
        return $this->belongsTo(\App\Models\GuestLand::class);
    }
}
