<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAll(array $filters = []): \Illuminate\Database\Eloquent\Collection
    {
        $query = Product::with('category');

        if (!empty($filters['category'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('slug', $filters['category']);
            });
        }

        if (isset($filters['available'])) {
            $query->where('available', $filters['available']);
        }

        return $query->orderBy('name')->get();
    }

    public function getById(int $id): Product
    {
        return Product::with('category')->findOrFail($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product->load('category');
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }
}
