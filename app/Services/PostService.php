<?php

namespace App\Services;

use App\Enum\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostService
{
    public function getAll()
    {
        $page = request()->get('page', 1);
        $perPage = request()->get('per_page', 10);
        $sortBy = request()->get('sort_by', 'created_at');
        $search = request()->get('search', '');


        return Post::query()
            ->with(['user:id,name', 'tags:id,name', 'categories:id,name','media'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy($sortBy, 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function create(array $data): Post
    {
        return DB::transaction(function () use ($data) {
            // Authenticated user
            $user = Auth::user();

            // Create post
            $post = Post::create([
                'title' => $data['title'],
                'slug' => \Str::slug($data['title']),
                'content' => $data['content'],
                'user_id' => $user->id,
                'status' => $data['status'],
                'published_at' => $data['status'] === 'published' ? now() : null,
                'thumbnail' => $data['thumbnail'],
            ]);

            // Attach tags
            $post->tags()->attach($data['tag_ids']);

            // Attach categories
            $post->categories()->attach($data['category_ids']);

            return $post;
        });
    }

    public function update(string $id, array $data): Post
    {
        $post = $this->findById($id);
        return DB::transaction(function () use ($post, $data) {
            // Update post data
            $post->title = $data['title'];
            $post->slug = \Str::slug($data['title']);
            $post->content = $data['content'];
            $post->status = $data['status'];
            $post->published_at = $data['status'] === 'published' ? now() : null;
            $post->thumbnail = $data['thumbnail'] ?? '';
            $post->save();

            // Sync categories
            $post->categories()->sync($data['category_ids']);

            // Sync tags
            $post->tags()->sync($data['tag_ids']);

            return $post;
        });
    }

    public function delete(string $id): void
    {
        $post = $this->findById($id);
        DB::transaction(function () use ($post) {

            $post->categories()->detach();
            $post->tags()->detach();

            // Soft delete the post
            $post->delete();
        });
    }

    public function findById(string $id)
    {
        return Post::findOrFail($id);
    }


    public function categories()
    {
        return Category::all();
    }

    public function tags()
    {
        return Tag::all();
    }



    // ---------------- Frontend Methods ----------------
    public function getAllPosts()
    {
        $page = request()->get('page', 1);
        $perPage = request()->get('per_page', 10);
        $sortBy = request()->get('sort_by', 'created_at');
        $search = request()->get('search', '');


        return Post::query()
            ->where('status', PostStatus::PUBLISHED->value)
            ->with(['user:id,name','media'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy($sortBy, 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
    }


    public function getPostBySlug(string $slug)
    {
        return  Post::where('slug', $slug)
                ->with(['user:id,name','media','categories:id,name','tags:id,name'])
                ->where('status', PostStatus::PUBLISHED->value)
                ->firstOrFail();
    }


}
