<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    protected $primaryKey = 'id_kecamatan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_kecamatan',
        'nama_kecamatan',
        // Add other fillable properties here
    ];
    public function lokasi()
    {
        return $this->hasMany(Lokasi::class, 'id_kecamatan', 'id_kecamatan');
    }
}
