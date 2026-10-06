<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adminkelurahan extends Model
{
    protected $table = 'adminkelurahan';
    protected $primaryKey = 'id_admin_kelurahan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_user',
        'id_lokasi',
        'nama_admin',
        'alamat_rumah',
        'no_hp',
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id_lokasi');
    }
}
