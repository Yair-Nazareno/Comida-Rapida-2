<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->resource->id,
            'nombre'         => $this->resource->name,
            'descripcion'    => $this->resource->description,
            'precio'         => $this->resource->price,
            'precio_display' => 'S/ ' . number_format($this->resource->price, 2),
            'imagen'         => $this->resource->image_url,
            'disponible'     => $this->resource->available,
            'categoria'      => new CategoryResource(
                $this->whenLoaded('category')
            ),
            'creado_en' => $this->resource->created_at->format('d/m/Y'),
        ];
    }
}
