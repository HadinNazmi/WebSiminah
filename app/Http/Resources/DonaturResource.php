<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonaturResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_donatur' => $this->id_donatur,
            'no_hp' => $this->no_hp,
            'nama_donatur' => $this->nama_donatur,
            'alamat_donatur'=> $this->alamat_donatur,
            'kelurahan'=> $this->kelurahan,
            'photo'=> asset('storage/donatur') . '/' .$this->photo,
        ];
    }
}
