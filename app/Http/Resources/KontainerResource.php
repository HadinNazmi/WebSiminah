<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KontainerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_kontainer' => $this->id_kontainer,
            'id_lokasi' => $this->id_lokasi,
            'nama_kelurahan' => LokasiResource::collection($this->nama_kelurahan),
            'kapasitas' => $this->kapasitas,
            'keterangan'=> $this->keterangan,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
    }
}
