@extends('backend.layouts.app',['table' => 'posts'])
@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tag List
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="" style="display: block ruby;">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Posts') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">A list of all the {{ __('Posts') }}.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none" style="float: right;">
                            <a type="button" href="{{ route('posts.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add new</a>
                        </div>
                    </div>

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="block min-w-full py-2 align-middle">
                                <table class="w-full divide-y divide-gray-300">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="py-3 pl-4 pr-3 mr-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No </th>
                                        <th scope="col" class="py-3 pl-4 px-3 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">User</th>
									    <th scope="col" class="py-3 pl-4 px-3 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Thumbnail</th>
									    <th scope="col" class="py-3 pl-4 px-3 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Title</th>
									    <th scope="col" class="py-3 pl-4 px-3 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Actions</th>
									    <th scope="col" class="py-3 pl-4 px-3 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Category</th>
									    <th scope="col" class="py-3 pl-4 px-3 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tags</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @php
                                        $sl = ($posts->currentPage() - 1) * $posts->perPage();
                                    @endphp
                                    @foreach ($posts as $post)
                                        <tr class="even:bg-gray-50">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ $loop->iteration + $sl }}</td>
										    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $post->user->name }}</td>
										    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <img class="h-10 w-10 rounded-full" src="{{ $post->thumbnail }}" alt="{{ $post->title }}" onerror="this.src='https://placehold.co/600x400?text=Thumbnail'">
                                            </td>
										    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $post->title }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $post->status_name }}</td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                                    <a href="{{ route('posts.edit', $post->id) }}" class="text-indigo-600 font-bold hover:text-indigo-900  mr-2">{{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('posts.destroy', $post->id) }}" class="text-red-600 font-bold hover:text-red-900" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;">{{ __('Delete') }}</a>
                                                </form>
                                            </td>
										    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $post->categories->pluck('name')->implode(', ') }}</td>
										    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $post->tags->pluck('name')->implode(', ') }}</td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-4 px-4">
                                    {!! $posts->withQueryString()->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
