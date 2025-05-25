<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TagService
{


    public function getAll()
    {
        $page = request()->get('page', 1);
        $perPage = request()->get('per_page', 10);
        $sortBy = request()->get('sort_by', 'created_at');
        $search = request()->get('search', '');


        return Tag::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy($sortBy)
            ->paginate($perPage, ['*'], 'page', $page);
    }


    public function create(array $data): Tag
    {
        return Tag::create($data);
    }

    public function update(string $id, array $data): Tag
    {
        $tag = $this->findById($id);
        if (!$tag) {
            throw new \Exception('Tag not found');
        }
        $tag->update($data);
        return $tag;
    }

    public function delete(string $id): bool
    {
        $tag = $this->findById($id);
        return $tag->delete();
    }

    public function findById(string $id):Tag
    {
        $tag =  Tag::find($id);
        if (!$tag) {
            throw (new ModelNotFoundException('Tag not found', 404))->setModel(Tag::class);
        }
        return $tag;
    }

}
