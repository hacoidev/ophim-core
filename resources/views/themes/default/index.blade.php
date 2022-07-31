@extends('themes::default.layout')

@php
use Ophim\Core\Models\Movie;
use Backpack\Settings\app\Models\Setting;

$recommendations = Cache::remember('site.movies.recommendations', Setting::get('site.cache.ttl', 5 * 60), function () {
    return Movie::where('is_recommended', true)
        ->limit(Setting::get('site.movies.recommendations.limit', 5))
        ->get()
        ->sortBy([
            function ($a, $b) {
                return $a['name'] <=> $b['name'];
            },
        ]);
});

$data = Cache::remember('site.movies.latest', Setting::get('site.cache.ttl', 5 * 60), function () {
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
        <div class="owl-carousel">
            @foreach ($recommendations as $movie)
                <div class="px-1">
                    @include('themes::default.inc.movie_card')
                </div>
            @endforeach
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
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
            @foreach ($item['data'] ?? [] as $movie)
                @include('themes::default.inc.movie_card')
            @endforeach
        </div>
    @endforeach
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                items: 2,
                center:true,
                loop:true,
                dots: false,
                responsive: {
                    1280: {
                        items: 5
                    },
                    1024: {
                        items: 4
                    },
                    768: {
                        items: 3
                    },
                },
                scrollPerPage: true,
                lazyLoad: true,
                slideSpeed: 800,
                paginationSpeed: 400,
                stopOnHover: true,
                autoPlay: 8000,
                navText: ['<i class="fa fa-angle-left text-white"></i>', '<i class="fa fa-angle-right text-white"></i>'],
            });
        });
    </script>
@endpush
