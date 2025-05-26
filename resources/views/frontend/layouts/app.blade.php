<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'LaraBlog' }}</title>
        <link rel="icon" href="favicon.ico">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    </head>
    <body x-data="{ page: 'personal-blog', 'loaded': true, 'modalNewsletter': false, 'modalSearch': false, 'stickyMenu': false, 'navigationOpen': false, 'scrollTop': false }">
        <!-- ===== Preloader Start ===== -->
        <div x-show="loaded" x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})" class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white">
            <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-primary border-t-transparent"></div>
        </div>
        <!-- ===== Preloader End ===== -->
        <!-- ===== Header Start ===== -->
        <header class="fixed left-0 top-0 w-full z-9999 bg-white py-7 lg:py-0 transition-all ease-in-out duration-300" :class="{ 'shadow-sm py-4! lg:py-0!' : stickyMenu }" @scroll.window="stickyMenu = (window.scrollY > 0) ? true : false">
            <div class="max-w-[1170px] mx-auto px-4 sm:px-8 xl:px-0 lg:flex items-center justify-between relative">
                <div class="w-full lg:w-3/12 flex items-center justify-between">
                    <a href="/" style="font-size: 34px;font-weight: bold;background: linear-gradient(90deg, #ff6a00, #ee0979);-webkit-background-clip: text;-webkit-text-fill-color: transparent;background-clip: text;color: transparent;">
                        {{-- <img src="images/logo.svg" alt="Logo" /> --}}
                        LaraBlog
                    </a>
                    <!-- Hamburger Toggle BTN -->
                    <button id="menuToggler" aria-label="button for menu toggle" class="lg:hidden block" @click="navigationOpen = !navigationOpen">
                        <span class="block relative cursor-pointer w-5.5 h-5.5">
                            <span class="du-block absolute right-0 w-full h-full">
                                <span class="block relative top-0 left-0 bg-dark rounded-xs w-0 h-0.5 my-1 ease-in-out duration-200 delay-0" :class="{ 'w-full! delay-300': !navigationOpen }"></span>
                                <span class="block relative top-0 left-0 bg-dark rounded-xs w-0 h-0.5 my-1 ease-in-out duration-200 delay-150" :class="{ 'w-full! delay-400': !navigationOpen }"></span>
                                <span class="block relative top-0 left-0 bg-dark rounded-xs w-0 h-0.5 my-1 ease-in-out duration-200 delay-200" :class="{ 'w-full! delay-500': !navigationOpen }"></span>
                            </span>
                            <span class="du-block absolute right-0 w-full h-full rotate-45">
                                <span class="block bg-dark rounded-xs ease-in-out duration-200 delay-300 absolute left-2.5 top-0 w-0.5 h-full" :class="{ 'h-0! delay-0': !navigationOpen }"></span>
                                <span class="block bg-dark rounded-xs ease-in-out duration-200 delay-400 absolute left-0 top-2.5 w-full h-0.5" :class="{ 'h-0! dealy-200': !navigationOpen }"></span>
                            </span>
                        </span>
                    </button>
                    <!-- Hamburger Toggle BTN -->
                </div>
                <div style="padding: 10px; " class="w-full lg:w-9/12 h-0 lg:h-auto invisible lg:visible lg:flex items-center justify-between" :class="{ 'visible! bg-white shadow-lgrelative h-auto! max-h-[400px] overflow-y-scroll rounded-md mt-4 p-7.5': navigationOpen }">
                    <!-- Main Nav Start -->
                    <nav>
                        <ul class="flex lg:items-center flex-col lg:flex-row gap-5 lg:gap-10">
                        </ul>
                    </nav>
                    <!-- Main Nav End -->
                    <!--=== Nav Right Start ===-->
                    <div class="flex flex-wrap items-center gap-8.5 mt-7 lg:mt-0">
                        @if (Auth::check())
                            <div class="flex items-center gap-4">

                                <a href="{{ route('post.create') }}"  class="rounded-md text-white font-medium flex py-2.5 px-5.5 bg-dark hover:opacity-90 lg:transition-all lg:ease-linear lg:duration-200">
                                    <svg style="fill: rgb(255, 255, 255)" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 50 50">
                                        <path d="M 25 2 C 12.264481 2 2 12.264481 2 25 C 2 37.735519 12.264481 48 25 48 C 37.735519 48 48 37.735519 48 25 C 48 12.264481 37.735519 2 25 2 z M 25 4 C 36.664481 4 46 13.335519 46 25 C 46 36.664481 36.664481 46 25 46 C 13.335519 46 4 36.664481 4 25 C 4 13.335519 13.335519 4 25 4 z M 24 13 L 24 24 L 13 24 L 13 26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z"></path>
                                    </svg> Create Post
                                </a>
                                <a href="/" class="text-dark font-medium hover:text-primary transition-all ease-linear duration-200" >My Post</a>
                                <a href="{{ route('logout') }}" class="text-dark font-medium hover:text-primary transition-all ease-linear duration-200" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        @else
                        <div class="flex items-center gap-4.5">
                            <a href="/login"  class="rounded-md text-white font-medium flex py-2.5 px-5.5 bg-dark hover:opacity-90 lg:transition-all lg:ease-linear lg:duration-200"> Login </a>
                            <a href="/register"  class="rounded-md text-white font-medium flex py-2.5 px-5.5 bg-dark hover:opacity-90 lg:transition-all lg:ease-linear lg:duration-200"> Register </a>
                        </div>
                        @endif
                    </div>
                    <!--=== Nav Right End ===-->
                </div>
            </div>
        </header>
        <!-- ===== Header End ===== -->
        <main>
           @yield('content')
        </main>

        <!-- ====== Back To Top Start ===== -->
        <button class="hidden items-center justify-center w-10 h-10 rounded-[4px] shadow-solid-5 bg-dark hover:opacity-95 fixed bottom-8 right-8 z-999" @click="window.scrollTo({top: 0, behavior: 'smooth'})" @scroll.window="scrollTop = (window.pageYOffset > 50) ? true : false" :class="{ 'flex!' : scrollTop }">
            <svg class="fill-white w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M233.4 105.4c12.5-12.5 32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L256 173.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l192-192z" />
            </svg>
        </button>
        <!-- ====== Back To Top End ===== -->
        <script defer src="{{ asset('js/bundle.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        @stack('scripts')
    </body>
</html>
