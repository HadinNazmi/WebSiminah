<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_admin_kelurahan' => $this->id_admin_kelurahan,
            'id_user' => $this->id_user,
            'id_lokasi' => $this->id_lokasi,
            'nama_kelurahan' => LokasiResource::collection($this->nama_kelurahan),
            'nama_admin' => $this->nama_admin,
            'alamat_rumah'=> $this->tanggal_batas_pendaftaran,
            'no_hp' => $this->no_hp,
        ];
    }
}
