<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $table = 'reward';
    protected $primaryKey = 'id_reward';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_reward',
        'nama_reward',
        'stok',
        'jumlah_poin',
        'masa_berlaku',
        'gambar',
        'status'
        // Add other fillable properties here
    ];

    public function redeem()
    {
        return $this->hasMany(Redeem::class, 'id_reward', 'id_reward');
    }
}
