<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SensorResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'logged_at' => $this->logged_at,
            'suhu' => (float) $this->suhu,
            'kelembapan' => (float) $this->kelembapan,
            'kecepatan_angin' => (float) $this->kecepatan_angin,
            'debit_air' => (float) $this->debit_air,
            'ketinggian_air' => (float) $this->ketinggian_air,
            'curah_hujan' => (float) $this->curah_hujan,
            'source' => $this->source,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
