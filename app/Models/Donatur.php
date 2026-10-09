<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Donatur extends Authenticatable
{
        use HasApiTokens, HasFactory, Notifiable, HasUuids;
        protected $hidden = ['password'];

    protected $table = 'donatur';
    protected $primaryKey = 'id_donatur';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_hp',
        'nama_donatur',
        'alamat_donatur',
        'kelurahan',
        'photo',
        'password',
        'poin',
        // Add other fillable properties here
    ];

    public function redeem()
    {
        return $this->hasMany(Redeem::class, 'id_donatur', 'id_donatur');
    }

    public function sumbangan()
    {
        return $this->hasMany(Sumbangan::class, 'id_donatur', 'id_donatur');
    }
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_donatur', 'id_donatur');
    }
}
