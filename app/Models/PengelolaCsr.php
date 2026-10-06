<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengelolaCsr extends Model
{
    protected $table = 'pengelola_csr';
    protected $primaryKey = 'id_pengelola';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_pengelola',
        'nama_pengelola',
        'username',
        'password',
        // Add other fillable properties here
    ];
}
