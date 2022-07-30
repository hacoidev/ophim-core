@php
$menu = \Ophim\Core\Models\Menu::getTree();
$tops = Cache::remember('site.movies.tops', \Backpack\Settings\app\Models\Setting::get('site.cache.ttl', 5 * 60), function () {
    $lists = preg_split('/[\n\r]+/', get_theme_var('hotest'));
    $data = [];
    foreach ($lists as $list) {
        if (trim($list)) {
            $list = explode('|', $list);
            [$label, $relation, $field, $val, $sortKey, $alg, $limit] = array_merge($list, ['Phim hot', '', 'type', 'series', 'view_total', 'desc', 4]);
            try {
                $data[] = [
                    'label' => $label,
                    'data' => \Ophim\Core\Models\Movie::when($relation, function ($query) use ($relation, $field, $val) {
                        $query->whereHas($relation, function ($rel) use ($field, $val) {
                            $rel->where($field, $val);
                        });
                    })
                        ->when(!$relation, function ($query) use ($field, $val) {
                            $query->where($field, $val);
                        })
                        ->orderBy($sortKey, $alg)
                        ->limit($limit)
                        ->get(),
                ];
            } catch (\Exception $th) {
                # code
            }
        }
    }

    return $data;
});
@endphp

<!DOCTYPE html>
<html lang="vi">

<head>
    @include('themes::default.inc.meta')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.20.0/dist/full.css" rel="stylesheet" type="text/css" />
</head>

<body class="bg-[#2f2f2f] font-sans leading-normal tracking-normal">
    @include('themes::default.inc.header')
    <div class="w-full pt-14">
        <div class="container mx-auto px-8 xl:px-40 md:mt-8 mb-16 text-gray-800 leading-normal">
            <div class="flex flex-row flex-wrap flex-grow mt-2">
                <div class="w-full lg:w-3/4 xl:w-3/4">
                    <div class="w-full">
                        @yield('content')
                    </div>
                </div>
                <div class="w-full lg:w-1/4 xl:w-1/4 pl-0 lg:pl-3 mt-3 lg:mt-0">
                    @foreach ($tops as $top)
                        <div class="rounded mb-3">
                            <a class="flex bg-[#1511116d] rounded-lg p-0 mb-0">
                                <div class="section-heading bg-[red] rounded-l-lg">
                                    <h3 class="px-2 py-1"><span
                                            class="h-text text-white uppercase ">{{ $top['label'] }}</span></h3>
                                </div>
                            </a>
                            <div class="mt-2">
                                <ul class="list-movies">
                                    @foreach ($top['data'] ?? [] as $movie)
                                        <a href="{{ $movie->getUrl() }}"
                                            class="flex bg-[#1511116d] rounded-lg w-15 h-20 my-2">
                                            <img class="object-cover rounded-l-lg" style="aspect-ratio: 256 / 340"
                                                src="{{ $movie->thumb_url }}" alt="">
                                            <div class="px-3 py-1 truncate">
                                                <p
                                                    class="capitalize block overflow-hidden overflow-ellipsis whitespace-nowrap text-[#44e2ff] hover:text-yellow-300">
                                                    {{ $movie->name }}</p>
                                                <p
                                                    class="text-gray-400 text-[12px] mt-[3px] italic block overflow-hidden overflow-ellipsis whitespace-nowrap">
                                                    {{ $movie->origin_name }} ({{ $movie->publish_year }})</p>
                                                <p class="text-gray-400 text-[12px] mt-[3px] italic"><svg
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        aria-hidden="true" class="w-4 h-4 inline">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg> {{ $movie->view_total ?? 0 }} lượt xem</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('themes::default.inc.footer')
    <div id="fb-root"></div>
    {!! \Backpack\Settings\app\Models\Setting::get('site.scripts.facebook.sdk') !!}
</body>

</html>
