@extends('frontend.layouts.app', ['title' => 'LaraBlog || Home'])

@section('content')
<!-- ====== Blog Section Start -->
<section class="pb-20" style="margin-top: 80px">
    <div class="max-w-[1170px] mx-auto px-4 sm:px-8 xl:px-0">
        <div id="posts" class="flex flex-col gap-y-7.5 lg:gap-y-12.5">
            @include('frontend.pages.home.post_items', ['posts' => $posts])
        </div>

        @if($posts->hasMorePages())
        <!-- Load More Button -->
        <button id="load-more-btn"
                class="flex justify-center font-medium text-dark border border-dark rounded-md py-3 px-7.5 hover:bg-dark hover:text-white ease-in duration-200 mx-auto mt-10 lg:mt-15"
                data-next-page="{{ $posts->currentPage() + 1 }}"
                data-last-page="{{ $posts->lastPage() }}">
            Show more...
        </button>
        @endif
    </div>
</section>
<!-- ====== Blog Section End -->
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreBtn = document.getElementById('load-more-btn');
        if (!loadMoreBtn) return;

        loadMoreBtn.addEventListener('click', function() {
            const nextPage = this.getAttribute('data-next-page');
            const lastPage = parseInt(this.getAttribute('data-last-page'));

            // Show loading state
            this.disabled = true;
            this.innerHTML = '<span class="animate-spin">⏳</span> Loading...';

            fetchPosts(nextPage)
                .then(html => {
                    document.getElementById('posts').insertAdjacentHTML('beforeend', html);

                    // Update button attributes
                    const newPage = parseInt(nextPage) + 1;
                    this.setAttribute('data-next-page', newPage);

                    // Hide button if no more pages
                    if (newPage > lastPage) {
                        this.remove();
                    } else {
                        this.innerHTML = 'Show more...';
                        this.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.innerHTML = 'Error! Try again';
                    setTimeout(() => {
                        this.innerHTML = 'Show more...';
                        this.disabled = false;
                    }, 2000);
                });
        });
    });

    async function fetchPosts(page) {
        try {
            const response = await fetch('{{ route("posts.load-more") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ page })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return await response.text();
        } catch (error) {
            console.error('Fetch error:', error);
            throw error;
        }
    }
</script>
@endpush
