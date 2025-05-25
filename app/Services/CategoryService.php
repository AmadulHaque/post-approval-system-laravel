<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryService
{


    public function getCategories()
    {
        $page = request()->get('page', 1);
        $perPage = request()->get('per_page', 10);
        $sortBy = request()->get('sort_by', 'created_at');
        $search = request()->get('search', '');


        return Category::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy($sortBy)
            ->paginate($perPage, ['*'], 'page', $page);
    }


    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }

    public function updateCategory(string $id, array $data): Category
    {
        $category = $this->findCategoryById($id);
        if (!$category) {
            throw new \Exception('Category not found');
        }
        $category->update($data);
        return $category;
    }
    
    public function deleteCategory(string $id): bool
    {
        $category = $this->findCategoryById($id);
        return $category->delete();
    }

    public function findCategoryById(string $id):Category
    {
        $category =  Category::find($id);
        if (!$category) {
            throw (new ModelNotFoundException('Category not found', 404))->setModel(Category::class);
        }
        return $category;
    }

}
