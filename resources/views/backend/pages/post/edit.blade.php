@extends('backend.layouts.app',['table' => 'Post edit'])
@use('\App\Enum\PostStatus')
@section('content')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update') }} Post
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container mx-auto px-4 py-8 max-w-4xl">
            <div class="bg-white rounded-xl shadow-md overflow-hidden p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-edit mr-2 text-indigo-600"></i>
                        Edit Post
                    </h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('posts.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                        <button type="submit" form="editPostForm" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-save mr-1"></i> Update Post
                        </button>
                    </div>
                </div>

                <form id="editPostForm" class="space-y-6" method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Title Field -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                            Post Title <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old('title', $post->title) }}"
                            required
                            class="w-full px-4 py-2 border @error('title') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            placeholder="Enter your post title">
                        @error('title')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @else
                            <p class="mt-1 text-xs text-gray-500">Make sure your title is unique and descriptive</p>
                        @enderror
                    </div>
                    <div>
                        <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">
                            Thumbnail
                        </label>
                        <input
                            type="file"
                            id="thumbnail"
                            name="thumbnail"
                            class="w-full px-4 py-2 border @error('thumbnail') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            placeholder="Enter your post title">
                        @error('thumbnail')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        @if ($post->thumbnail)
                            <img src="{{ asset($post->thumbnail) }}" alt="" onerror="this.src='https://placehold.co/600x400?text=Thumbnail'">
                        @endif
                    </div>
                    <!-- Content Field -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                            Content <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="content"
                            name="content"
                            rows="8"
                            required
                            class="w-full px-4 py-2 border @error('content') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            placeholder="Write your post content here...">{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tags Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tags <span class="text-red-500">*</span>
                        </label>

                        <div class="space-y-3">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                @foreach ($tags as $tag)
                                <div class="flex items-center p-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <input id="tag-{{ $tag->id }}"
                                        type="checkbox"
                                        name="tag_ids[]"
                                        value="{{ $tag->id }}"
                                        {{ in_array($tag->id, old('tag_ids', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }}
                                        class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="tag-{{ $tag->id }}" class="ml-2 text-sm text-gray-700">{{ $tag->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        @error('tag_ids')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500">Select at least one tag (max 5)</p>
                        @enderror
                    </div>

                    <!-- Categories Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Categories <span class="text-red-500">*</span>
                        </label>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach ($categories as $category)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition border border-gray-200">
                                <input id="category-{{ $category->id }}"
                                    type="checkbox"
                                    name="category_ids[]"
                                    value="{{ $category->id }}"
                                    {{ in_array($category->id, old('category_ids', $post->categories->pluck('id')->toArray())) ? 'checked' : '' }}
                                    class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="category-{{ $category->id }}" class="ml-2 text-sm font-medium text-gray-700">{{ $category->name }}</label>
                            </div>
                            @endforeach
                        </div>

                        @error('category_ids')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500">Select at least one category</p>
                        @enderror
                    </div>

                    <!-- Status Field -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="status"
                            name="status"
                            required
                            class="w-full px-4 py-2 border @error('status') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="" disabled>Select a status</option>
                            @foreach (PostStatus::all() as $id=>$name)
                                <option value="{{ $id }}" {{ old('status', $post->status) == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 border-t border-gray-200 flex justify-end space-x-3">
                        <a href="{{ route('posts.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-save mr-1"></i> Update Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
