<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $table = 'lokasi';
    protected $primaryKey = 'id_lokasi';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_lokasi',
        'id_kecamatan',
        'is_kecamatan',
        'nama_kelurahan',
        'latitude',
        'longitude',
        'gambar',
        'deskripsi',
        // Add other fillable properties here
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }
    public function adminkelurahan()
    {
        return $this->hasMany(Adminkelurahan::class, 'id_lokasi', 'id_lokasi');
    }

    public function kontainer()
    {
        return $this->hasMany(Kontainer::class, 'id_lokasi', 'id_lokasi');
    }

    public function permintaan()
    {
        return $this->hasMany(Permintaan::class, 'id_lokasi', 'id_lokasi');
    }
}
