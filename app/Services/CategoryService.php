<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        //return Category::withCount('products')
          //             ->orderBy('name')
            //           ->get();
            return Category::orderBy('name')->get();
    }

    public function getById(int $id): Category
    {
       // return Category::withCount('products')
         //              ->with('products')
           //            ->findOrFail($id);
            return Category::findOrFail($id);
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        return $category;
    }

    public function delete(Category $category): void
    {
        if ($category->products()->count() > 0) {
            throw new \Exception('No puedes eliminar una categoría con productos.');
        }

        $category->delete();
    }
}
