<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->resource->id,
            'nombre'          => $this->resource->name,
            'slug'            => $this->resource->slug,
            'activo'          => $this->resource->active,
            'total_productos' => $this->whenCounted('products'),
            'productos'       => ProductResource::collection(
                $this->whenLoaded('products')
            ),
            'creado_en' => $this->resource->created_at->format('d/m/Y'),
        ];
    }
}
