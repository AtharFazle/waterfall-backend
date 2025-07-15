<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     * 

     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'order' => $this->order,
            'isActive' => $this->is_active == 1,
            'url' => $this->getImageUrl(),
            'uploadDate' => $this->created_at,
        ];
    }

    private function getImageUrl()
    {
        // Jika file_path berisi 'public/', hapus prefix tersebut
        $cleanPath = str_replace('public/', '', $this->file_path);

        return asset('storage/' . $cleanPath);
    }
}
