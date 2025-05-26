
@extends('frontend.layouts.app' ,['title' => $post->title ?? 'Post Details'])
@section('content')

<section class="pt-31.5 pb-17.5">
    <div class="max-w-[1030px] mx-auto px-4 sm:px-8 xl:px-0">
        <div class="max-w-[770px] mx-auto text-center">
            <a href="category.html" class="inline-flex text-blue bg-blue/[0.08] font-medium text-custom-sm py-1 px-3 rounded-full mb-1">Technology</a>
            <h1 class="font-bold text-2xl sm:text-4xl lg:text-custom-2 text-dark mb-5">
                {{ $post->title ?? 'Post Title' }}
            </h1>

            <div class="flex items-center justify-center gap-4 mt-7.5">
                <div class="text-left">
                    <h4 class="font-medium text-custom-lg text-dark mb-1"> {{ $post->user->name }} </h4>
                    <div class="flex items-center gap-1.5">
                        <p>{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{ $post->thumbnail }}" style="width: 100%;" alt="{{ $post->title }}" onerror="this.src='https://placehold.co/600x400?text=Thumbnail'" alt="blog" class="mt-10 mb-11" />
        <div class="max-w-[770px] mx-auto">
            <p class="text-body">
                {{ $post->content }}
            </p>
        </div>
    </div>
</section>

@endsection
