@extends('themes::default.layout')

@php
use Ophim\Core\Models\Movie;
use Backpack\Settings\app\Models\Setting;

$recommendations = Cache::remember('site.movies.recommendations', Setting::get('site.cache.ttl', 60), function () {
    return Movie::where('is_recommended', true)
        ->limit(Setting::get('site.movies.recommendations.limit', 5))
        ->get()
        ->sortBy([
            function ($a, $b) {
                return $a['name'] <=> $b['name'];
            },
        ]);
});

$data = Cache::remember('site.movies.latest', Setting::get('site.cache.ttl', 60), function () {
    $lists = preg_split('/[\n\r]+/', get_theme_var('latest'));
    $data = [];
    foreach ($lists as $list) {
        if (trim($list)) {
            $list = explode('|', $list);
            [$label, $relation, $field, $val, $limit, $link] = array_merge($list, ['Phim  mới cập nhật', '', 'type', 'series', 8, '/']);
            try {
                $data[] = [
                    'label' => $label,
                    'data' => Movie::when($relation, function ($query) use ($relation, $field, $val) {
                        $query->whereHas($relation, function ($rel) use ($field, $val) {
                            $rel->where($field, $val);
                        });
                    })
                        ->when(!$relation, function ($query) use ($field, $val) {
                            $query->where($field, $val);
                        })
                        ->limit($limit)
                        ->orderBy('updated_at', 'desc')
                        ->get(),
                    'link' => $link ?: '#',
                ];
            } catch (\Throwable $th) {
            }
        }
    }
    return $data;
});
@endphp

@section('content')
    @if (count($recommendations))
        <div id="default-carousel" class="relative z-10" data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="overflow-hidden relative rounded-lg h-[12em] sm:h-[20em] md:h-[25em] xl:h-[30em]">
                @foreach ($recommendations as $item)
                    <a class="block object-contain hidden duration-700 ease-in-out" href="{{ $item->getUrl() }}"
                        data-carousel-item="{{ $loop->index }}">
                        <span
                            class="absolute top-1/2 left-1/2 text-2xl font-semibold text-white -translate-x-1/2 -translate-y-1/2 sm:text-3xl dark:text-gray-800"></span>
                        <img src="{{ $item->poster_url }}"
                            class="rounded object-contain absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2"
                            alt="...">
                    </a>
                @endforeach
            </div>
            <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
                @foreach ($recommendations as $item)
                    <button type="button" class="w-3 h-3 rounded-full bg-white dark:bg-gray-800" aria-current="true"
                        data-carousel-slide-to="{{ $loop->index }}"></button>
                @endforeach
            </div>
            <!-- Slider controls -->
            <button type="button"
                class="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                data-carousel-prev="">
                <span
                    class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                data-carousel-next="">
                <span
                    class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
        <div class="mb-5"></div>
    @endif

    @foreach ($data as $item)
        <div class="section-heading flex bg-[#1511116d] rounded-lg p-0 mb-3 justify-between content-between">
            <h2 class="inline p-2 bg-[red] rounded-l-lg">
                <span class="h-text font-bold text-white uppercase">{{ $item['label'] }}</span>
            </h2>
            <a class="inline uppercase self-center pr-3" href="{{ $item['link'] }}"><span
                    class="text-white hover:text-yellow-300">Xem
                    Thêm</span>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach ($item['data'] ?? [] as $movie)
                <a class="block " href="{{ $movie->getUrl() }}">
                    <div class="flex justify-center items-center">
                        <div
                            class="max-w-xs container bg-[#151111] rounded-lg shadow-lg transform transition duration-500 hover:scale-105 hover:shadow-2xl">
                            <img class="w-full cursor-pointer rounded-t-lg" style="aspect-ratio: 256/340"
                                src="{{ $movie->thumb_url }}" alt="" />
                            <div class="flex p-4 justify-between">
                                <div class="flex w-full justify-between space-x-2">
                                    <h2 class="text-gray-200 font-bold cursor-pointer truncate">{{ $movie->name ?? '' }}
                                    </h2>
                                    <h2
                                        class="text-gray-200 cursor-pointer uppercase badge badge-success float-right truncate">
                                        {{ $movie->quality ?? '' }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endforeach
@endsection
