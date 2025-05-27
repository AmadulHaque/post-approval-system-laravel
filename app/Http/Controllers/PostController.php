<?php

namespace App\Http\Controllers;

use App\Cache\PostCache;
use App\Enum\PostStatus;
use App\Http\Requests\UserPostStoreRequest;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        private PostService $postService,
        private PostCache $postCache
    ){}


    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 10);
        $key = "page_{$page}_per_page_{$perPage}";
        $posts = $this->postCache->get($key, function () use ($page, $perPage) {
            return $this->postService->getAllPosts();
        });

        return view('frontend.pages.home.index',compact('posts'));
    }

    public function posts(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 10);
        $key = "page_{$page}_per_page_{$perPage}";
        $posts = $this->postCache->get($key, function () use ($page, $perPage) {
            return $this->postService->getAllPosts();
        });

        return view('frontend.pages.home.post_items',compact('posts'))->render();
    }


    public function show($slug)
    {
        $key = "post_detail_{$slug}";
        $post = $this->postCache->get($key, function () use ($slug) {
            return $this->postService->getPostBySlug($slug);
        });
        return view('frontend.pages.home.post_details', compact('post'));
    }


    public function create()
    {
        $categories = $this->postService->categories();
        $tags = $this->postService->tags();
        return view('frontend.pages.user.posts.create',compact('categories','tags'));
    }

    public function store(UserPostStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $data['status'] = PostStatus::DRAFT->value;
            $post = $this->postService->create($data);
            return redirect()->route('frontend.posts.list')
                ->with('success', 'Post created successfully and sent for approval.');
        } catch (\Throwable $th) {
            return $th->getMessage();
            return redirect()->route('frontend.posts.create')
                ->with('error', 'Failed to create post: ' . $th->getMessage());
        }
    }


    public function myPosts()
    {
        $posts = $this->postService->myPosts();
        return view('frontend.pages.user.posts.index',compact('posts'));
    }


}
