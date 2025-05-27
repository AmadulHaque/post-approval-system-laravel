@forelse ($posts as $post)
    <div class="flex items-center flex-col lg:flex-row gap-10 lg:gap-15">
        <div class="max-w-[570px] w-full overflow-hidden transition-all hover:scale-105 rounded-[10px]">
            <a href="{{ route('frontend.posts.show', $post->slug) }}" class="block">
                <img style="width: 100%"  src="{{ $post->thumbnail }}" alt="{{ $post->title }}" onerror="this.src='https://placehold.co/600x400?text=Thumbnail'">
            </a>
        </div>
        <div class="max-w-[540px] w-full">
            <a href="#" class="inline-flex text-blue bg-blue/[0.08] font-medium text-custom-sm py-1 px-3 rounded-full">{{ $post->created_at->diffForHumans() }}</a>
            <h4 class="mt-3.5 mb-4">
                <a href="{{ route('frontend.posts.show', $post->slug) }}" class="group text-dark font-bold text-xl sm:text-2xl xl:text-custom-4xl">
                    <span class="bg-linear-to-r from-primary/40 to-primary/30 bg-[length:0px_10px] bg-left-bottom bg-no-repeat transition-[background-size] duration-500 hover:bg-[length:100%_3px] group-hover:bg-[length:100%_10px]">
                        {{ $post->title }}
                    </span>
                </a>
            </h4>
            <p>
                {{ Str::limit($post->content, 150, '...') }}
            </p>
            <div class="flex items-center gap-2.5 mt-4.5">
                <p>By <span class="font-semibold text-dark"> {{ $post->user->name }} </span> </p>
            </div>
        </div>
    </div>
@empty
    <div class="text-center py-10">
        <h2 class="text-2xl font-bold text-gray-700">No posts available</h2>
        <p class="mt-2 text-gray-500">Please check back later or create a new post.</p>
    </div>
@endforelse
