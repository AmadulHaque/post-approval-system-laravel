<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostController extends Controller
{
    protected $routeRouteName = 'posts.index';
    public function __construct(private PostService $postService)
    {}


    public function index(): View
    {
        $posts = $this->postService->getAll();
        return view('backend.pages.post.index', compact('posts'));
    }

    public function create(): View
    {
        $categories = $this->postService->categories();
        $tags = $this->postService->tags();
        return view('backend.pages.post.create',compact('categories','tags'));
    }


    public function store(PostRequest $request): RedirectResponse
    {
        try {
            $this->postService->create($request->validated());
            return redirect()->route($this->routeRouteName)
                ->with('success', 'Post created successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('posts.create')
                ->with('error', 'Failed to create post : ' . $th->getMessage());
        }
    }


    public function edit(string $id): RedirectResponse|View
    {
        try {
            $categories = $this->postService->categories();
            $tags = $this->postService->tags();
            $post  = $this->postService->findById($id);
            return view('backend.pages.post.edit', compact('post','categories','tags'));
        } catch (ModelNotFoundException $e) {
            abort(404, 'Post not found');
        }catch (\Throwable $th) {
            return redirect()->route($this->routeRouteName)
                ->with('error', 'Failed to edit post: ' . $th->getMessage());
        }
    }

    public function update(PostRequest $request, string $id): RedirectResponse
    {
       try {
            $this->postService->update($id, $request->validated());
            return redirect()->route($this->routeRouteName)
                ->with('success', 'Post updated successfully');
       }catch (ModelNotFoundException $e) {
            abort(404, 'Post not found');
        }catch (\Throwable $th) {
            return redirect()->route('posts.edit', parameters: $id)
                ->with('error', 'Failed to update post: ' . $th->getMessage());
       }
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $this->postService->delete($id);
            return redirect()->route($this->routeRouteName)
                ->with('success', 'Post deleted successfully');
        }catch (ModelNotFoundException $e) {
            abort(404, 'Post not found');
        }catch (\Throwable $th) {
            return redirect()->route($this->routeRouteName)
                ->with('error', 'Failed to deleted post: ' . $th->getMessage());
        }
    }
}
