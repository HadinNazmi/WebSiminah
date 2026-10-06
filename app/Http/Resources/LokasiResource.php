<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LokasiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_lokasi' => $this->id_lokasi,
            'nama_kelurahan' => $this->nama_kelurahan,
            'latitude' => $this->latitude,
            'longitude'=> $this->longitude,
            'deskripsi'=> $this->deskripsi,
        ];
    }
}
