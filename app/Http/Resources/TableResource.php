<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->resource->id,
            'numero'   => $this->resource->number,
            'capacidad' => $this->resource->capacity,

             //Estado con etiqueta legible
            'estado'   => $this->resource->status,
            'estado_display' => $this->getStatusDisplay(),

            'activo'   => $this->resource->active,

             //Si está disponible para asignar
            'disponible' => $this->resource->isAvailable(),

            'creado_en' => $this->resource->created_at->format('d/m/Y'),
        ];
    }

    // Traduce el status a español
    private function getStatusDisplay(): string
    {
        return match($this->resource->status) {
            'available'   => 'Disponible',
            'occupied'    => 'Ocupada',
            'reserved'    => 'Reservada',
            'maintenance' => 'Mantenimiento',
            default       => 'Desconocido',
        };
    }
}
