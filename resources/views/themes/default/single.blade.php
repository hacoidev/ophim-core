@extends('themes::default.layout')

@section('content')
    <div class="breadcrumb w-full py-[5px] px-[10px] mb-2 list-none bg-[#151111] rounded" itemscope=""
        itemtype="https://schema.org/BreadcrumbList">
        <a href="/">
            <span class="text-xs font-bold text-white" itemprop="name">Trang Chủ ></span>
        </a>
        @foreach ($movie->categories as $category)
            <a href="{{ $category->getUrl() }}">
                <span class="text-xs font-bold text-white" itemprop="name">{{ $category->name }} ></span>
            </a>
        @endforeach
        <a href="{{ $movie->getUrl() }}">
            <span class="text-gray-400 text-xs font-bold italic whitespace-normal">{{ $movie->name }}</span>
        </a>
    </div>
    <div class="flex flex-wrap flex-grow">
        <div class="w-full sm:w-1/2 md:w-[fit-content] flex justify-center pr-0 sm:pr-3">
            <div class="max-w-xs container bg-[#151111] rounded-lg h-[fit-content]">
                <img class="w-full cursor-pointer rounded-t-lg" style="aspect-ratio: 256/340" src="{{ $movie->thumb_url }}"
                    alt="" />
                <div class="flex py-3 justify-between">
                    <div class="flex w-full justify-center space-x-2">
                        @if ($movie->status == 'trailer' && $movie->trailer_url)
                            <a class="bg-[#d9534f] text-gray-50 inline-block px-2 py-1 rounded"
                                title="Thỏa Thuận Bán Thân - Dangerous Memorandum Signed By The Body (2021)"
                                href="{{ $movie->trailer_url }}" target="__blank">Xem trailer
                            </a>
                        @elseif($movie->status != 'trailer' && count($movie->episodes))
                            <a class="bg-[#d9534f] text-gray-50 inline-block px-2 py-1 rounded"
                                title="Thỏa Thuận Bán Thân - Dangerous Memorandum Signed By The Body (2021)"
                                href="{{ $movie->episodes->sortByDesc('name', SORT_NATURAL)->first()->getUrl() }}">Xem phim
                            </a>
                        @else
                            <p class="text-white">Đang cập nhật...</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full sm:w-1/2 md:grow mt-3 sm:mt-0">
            <div class="w-full rounded-lg p-3 text-[#bbb] bg-[#272727]">
                <h1>
                    <span class="uppercase text-sm xl:text-xl text-[#dacb46] block font-bold">
                        <a href="{{ $movie->getUrl() }}" title="{{ $movie->name }}">{{ $movie->name }}</a>
                    </span>
                    <span class="text-gray-300 text-base">{{ $movie->origin_name ?? '' }}</span>
                    <span class="text-gray-300 text-base"> ({{ $movie->publish_year ?? 'Đang cập nhật...' }})</span>
                </h1>
                <div class="my-1">
                    <div class="flex-none lg:flex items-center">
                        <p class="flex items-center">
                            @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10] as $star)
                                @if ($movie->rating_star >= $star)
                                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <title>light star</title>
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                @else
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-300 dark:text-gray-500"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <title>dark star</title>
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                @endif
                            @endforeach
                        </p>
                        <p class="text-xs text-white align-middle">
                            ({{ number_format($movie->rating_star ?? 0, 1) }}
                            sao
                            /
                            {{ $movie->rating_count ?? 0 }} đánh giá)</p>
                    </div>
                </div>
                <div class="w-auto h-[fit-content] rounded-lg text-[#bbb] bg-[#272727] text-lg">

                </div>
                <dl class="mt-1">
                    <dt class="inline font-bold text-sm">Trạng thái:</dt>
                    <dd class="movie-dd inline ml-1 text-sm status text-red-600">{{ $movie->getStatus() }}
                    </dd>
                    <br>
                    <dt class="inline font-bold text-sm">Thể loại:</dt>
                    <dd class="movie-dd inline ml-1 text-sm dd-cat">
                        {!! $movie->categories->map(function ($category) {
                                return '<a class="text-[#44e2ff] hover:text-yellow-400 mr-1" href="' .
                                    $category->getUrl() .
                                    '" title="' .
                                    $category->name .
                                    '">' .
                                    $category->name .
                                    '</a>';
                            })->implode(', ') !!}
                    </dd><br>
                    <dt class="inline font-bold text-sm">Quốc gia:</dt>
                    <dd class="movie-dd inline ml-1 text-sm">
                        {!! $movie->regions->map(function ($region) {
                                return '<a class="text-[#44e2ff] hover:text-yellow-400 mr-1" href="' .
                                    $region->getUrl() .
                                    '" title="' .
                                    $region->name .
                                    '">' .
                                    $region->name .
                                    '</a>';
                            })->implode(', ') !!}
                    </dd>
                    <br>
                    <dt class="inline font-bold text-sm">Năm:</dt>
                    <dd class="movie-dd inline ml-1 text-sm">
                        <a class="text-[#44e2ff] hover:text-yellow-400 mr-1" title="Phim mới {{ $movie->publish_year }}"
                            href="{{ '/?' . urlencode('filter[year]') . '=' . $movie->publish_year }}">{{ $movie->publish_year ?? 'Đang cập nhật...' }}</a>
                    </dd><br>
                    <dt class="inline font-bold text-sm">Đạo diễn:</dt>
                    <dd class="movie-dd inline ml-1 text-sm">
                        {!! $movie->directors->map(function ($director) {
                                return '<a class="text-[#44e2ff] hover:text-yellow-400 mr-1" href="' .
                                    $director->getUrl() .
                                    '" title="' .
                                    $director->name .
                                    '">' .
                                    $director->name .
                                    '</a>';
                            })->implode(', ') !!}
                    </dd><br>
                    <dt class="inline font-bold text-sm">Diễn viên:</dt>
                    <dd class="movie-dd inline ml-1 text-sm dd-actor">
                        {!! $movie->actors->map(function ($actor) {
                                return '<a class="text-[#44e2ff] hover:text-yellow-400 mr-1" href="' .
                                    $actor->getUrl() .
                                    '" title="' .
                                    $actor->name .
                                    '">' .
                                    $actor->name .
                                    '</a>';
                            })->implode(', ') !!}
                    </dd><br>
                    <dt class="inline font-bold text-sm">Thời lượng:</dt>
                    <dd class="movie-dd inline ml-1 text-sm">{{ $movie->episode_time ?? 'Đang cập nhật...' }}
                    </dd><br>
                    <dt class="inline font-bold text-sm">Chất lượng:</dt>
                    <dd class="movie-dd inline ml-1 text-sm">{{ $movie->quality ?? 'Đang cập nhật...' }}</dd>
                    <br>
                    <dt class="inline font-bold text-sm">Ngôn ngữ:</dt>
                    <dd class="movie-dd inline ml-1 text-sm">{{ $movie->language ?? 'Đang cập nhật...' }}</dd>
                    <br>
                    <dt class="inline font-bold text-sm">Ngày cập nhật:</dt>
                    <dd class="movie-dd inline ml-1 text-sm">{{ $movie->updated_at->format('d/m/Y') }}</dd>
                    <br>
                    <dt class="inline font-bold text-sm">Lượt xem:</dt>
                    <dd class="movie-dd inline ml-1 text-sm">
                        {{ number_format($movie->view_total ?? 0) }} lượt</dd>
                </dl>
            </div>


        </div>

        <article class="mt-2.5 p-3 bg-[#272727] mb-3 mr-2 rounded-lg">
            <h2 class="text-sm font-bold text-[#dacb46] uppercase mt-1.5 mb-3">Nội dung phim</h2>
            <div class="content text-white">
                @if ($movie->content)
                    <div class="whitespace-pre-wrap">{!! $movie->content !!}</div>
                @else
                    <p>Đang cập nhật ...</p>
                @endif
            </div>

            <br>
            <span class="text-sm text-[#dacb46] mt-1.5">Từ Khóa: {!! $movie->tags->map(function ($tag) {
                    return '<a class="text-[#44e2ff] hover:text-yellow-400 mr-1" href="' .
                        $tag->getUrl() .
                        '" title="' .
                        $tag->name .
                        '">' .
                        $tag->name .
                        '</a>';
                })->implode(', ') !!}</span>

        </article>

        <div class="fb-comments w-full rounded-lg" data-href="{{ $movie->getUrl() }}" data-width="100%" data-numposts="5">
        </div>
    </div>
@endsection
