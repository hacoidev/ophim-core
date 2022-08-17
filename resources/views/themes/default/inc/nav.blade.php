@php
$logo = setting('site_logo', '');
$brand = setting('site_brand', '');
$title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp

<nav class="w-full fixed top-0 py-2 bg-[#151111] border-gray-200 z-30">
    <div class="container mx-auto px-4 md:px-8 xl:px-40 flex flex-wrap justify-between items-center">
        <div class="w-2/5 md:w-1/5 py-2">
            <a class="text-gray-100 text-base xl:text-xl no-underline hover:no-underline font-bold" href="/">
                @if ($logo)
                    {!! $logo !!}
                @endif
                {!! $brand !!}
            </a>
            <h1 class="cursor-pointer w-max inline-flex" style="text-indent:-9999px">{{ $title }}</h1>
        </div>
        <button data-collapse-toggle="mobile-menu" type="button"
            class="inline-flex justify-center items-center ml-3 rounded-lg md:hidden text-gray-400 hover:text-white focus:ring-gray-500"
            aria-controls="mobile-menu-2" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
        <div class="hidden md:flex items-center w-full md:w-auto" id="mobile-menu">
            <div class="relative mt-2 md:mt-0 mr-0 md:mr-4">
                <form id="form-search" action="/">
                    <input type="search" name="search" placeholder="Tìm kiếm phim"
                        class="focus:bg-[#2b2821] w-full bg-[#212020] text-sm md:text-md text-white transition focus:border-gray-600 focus:outline-none rounded py-2 px-2 pl-10 appearance-none leading-normal"
                        value="{{ request('search') }}" />

                    <div class="absolute search-icon" style="top:0.75rem;left:1rem"><svg
                            class="fill-current pointer-events-none text-gray-400 w-4 h-4"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z">
                            </path>
                        </svg>
                    </div>
                </form>
            </div>
            <ul class="flex flex-col md:flex-row md:text-sm bg-[#151111]">
                @foreach ($menu as $item)
                    <li class="mr-6 my-2 md:my-0 dropdown relative group">
                        @if (count($item['children']))
                            <button data-dropdown-toggle="nav-dropdown-{{ $loop->index }}"
                                class="flex justify-between items-center py-2 pr-4 w-full font-medium text-slate-200 md:hover:text-blue-700 md:p-0 md:w-auto">
                                {{ $item->name }}
                                <svg class="ml-1 w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div id="nav-dropdown-{{ $loop->index }}"
                                class="hidden z-20 w-[80vw] md:w-[50vw] xl:w-[35vw] font-normal divide-x shadow">
                                <ul class="py-1 text-sm text-slate-300 bg-[#151111] grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5"
                                    aria-labelledby="dropdownLargeButton">
                                    @foreach ($item['children'] as $children)
                                        <li class="inline-block p-1 truncate text-center">
                                            <a href="{{ $children['link'] }}"
                                                class="block py-2 hover:bg-slate-800">{{ $children['name'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <a href="{{ $item['link'] }}" class="flex items-center">
                                <span class="text-white">{{ $item['name'] }}</span>
                            </a>
                        @endif
                    </li>
                @endforeach

            </ul>
        </div>

    </div>
</nav>
