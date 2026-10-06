<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sumbangan extends Model
{
    protected $table = 'sumbangan';

    protected $primaryKey = 'id_sumbangan';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_donatur',
        'id_kontainer',
        'tanggal',
        'berat',
        'photo',
        'status',
        'keterangan',
        'poin_reward',
    ];

    public function donatur()
    {
        return $this->belongsTo(Donatur::class, 'id_donatur', 'id_donatur');
    }

    public function kontainer()
    {
        return $this->belongsTo(Kontainer::class, 'id_kontainer', 'id_kontainer');
    }
}
