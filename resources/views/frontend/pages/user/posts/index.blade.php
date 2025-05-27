
@extends('frontend.layouts.app' ,['title' => 'Post List'])
@section('content')

<section class="pt-31.5 pb-17.5">
    <div class="container mx-auto px-4 sm:px-8">

            <div class="py-8">
                <div>
                    <h2 class="text-2xl font-semibold leading-tight">Post List</h2>
                </div>
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <div class="inline-block w-full shadow-md rounded-lg overflow-hidden">
                        <table class="w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                         Title</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                         Thumbnail </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                         Created At </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                         Status </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($posts as $post)
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $post->title }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex-shrink-0 w-10 h-10">
                                            <img class="h-10 w-10 rounded-full" src="{{ $post->thumbnail }}" alt="{{ $post->title }}" onerror="this.src='https://placehold.co/600x400?text=Thumbnail'">
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $post->created_at->diffForHumans() }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span class="relative">{{ $post->status_name }}</span>
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                       <a class="text-indigo-600 font-bold hover:text-indigo-900" href="{{ route('frontend.posts.show', $post->slug) }}?type=author">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">No Post Found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="pm-4 py-3">
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>



    </div>
</section>

@endsection
