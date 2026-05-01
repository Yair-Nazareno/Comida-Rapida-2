<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Table extends Model
{
    protected $fillable = [
        'number',
        'capacity',
        'status',
        'active',
    ];

    protected $casts = [
        'active'   => 'boolean',
        'capacity' => 'integer',
    ];

    // Una mesa tiene muchas órdenes
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Helpers de estado
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isOccupied(): bool
    {
        return $this->status === 'occupied';
    }

    // Marcar mesa como ocupada
    public function markAsOccupied(): void
    {
        $this->update(['status' => 'occupied']);
    }

    // Marcar mesa como disponible
    public function markAsAvailable(): void
    {
        $this->update(['status' => 'available']);
    }
}
