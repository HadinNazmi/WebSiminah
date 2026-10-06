<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kontainer extends Model
{
    use HasUuids;

    protected $table = 'kontainer';
    protected $primaryKey = 'id_kontainer';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_kontainer',
        'id_lokasi',
        'kapasitas',
        'keterangan',
        // Add other fillable properties here
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id_lokasi');
    }
    public function sumbangan()
{
    return $this->hasMany(Sumbangan::class, 'id_kontainer');
}
}
