<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kecamatan extends Model
{
    use HasUuids;

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
