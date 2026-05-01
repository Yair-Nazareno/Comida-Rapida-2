<?php

namespace App\Services;

use App\Models\Table;

class TableService
{
    // Listar todas las mesas
    public function getAll(array $filters = []): \Illuminate\Database\Eloquent\Collection
    {
        $query = Table::query();

        // Filtrar por estado
        // GET /api/tables?status=available
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filtrar solo activas
        // GET /api/tables?active=true
        if (isset($filters['active'])) {
            $query->where('active', $filters['active']);
        }

        return $query->orderBy('number')->get();
    }

    // Obtener una mesa
    public function getById(int $id): Table
    {
        return Table::findOrFail($id);
    }

    // Crear mesa
    public function create(array $data): Table
    {
        return Table::create($data);
    }

    // Actualizar mesa
    public function update(Table $table, array $data): Table
    {
        $table->update($data);
        return $table;
    }

    // Cambiar solo el estado
    public function updateStatus(Table $table, string $status): Table
    {
        // Verifica que no esté ocupada antes de cambiar
        if ($table->isOccupied() && $status === 'available') {
            throw new \Exception('No puedes liberar una mesa con una orden activa.');
        }

        $table->update(['status' => $status]);
        return $table;
    }

    // Eliminar mesa
    public function delete(Table $table): void
    {
        if ($table->isOccupied()) {
            throw new \Exception('No puedes eliminar una mesa ocupada.');
        }

        $table->delete();
    }
}
