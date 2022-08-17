@extends('themes::default.layout')

@section('content')
    <div class="breadcrumb w-full py-[5px] px-[10px] mb-2 list-none bg-[#151111] rounded" itemscope=""
        itemtype="https://schema.org/BreadcrumbList">
        <a href="/">
            <span class="text-xs font-bold text-white" itemprop="name">Trang Chủ ></span>
        </a>
        <span class="truncate">
            @foreach ($movie->categories as $category)
                <a href="{{ $category->getUrl() }}">
                    <span class="text-xs font-bold text-white" itemprop="name">{{ $category->name }} ></span>
                </a>
            @endforeach
        </span>
        <a href="{{ $movie->getUrl() }}">
            <span class="text-gray-400 text-xs font-bold italic whitespace-normal truncate">{{ $movie->name }}</span>
        </a>
    </div>

    <div class="h-content">
        <div class="flex iframe w-full" style="aspect-ratio: 16 / 9;" id="player-wrapper"></div>
    </div>

    <div class="flex justify-between mt-1">
        <div class="text-[#FDB813] mb-2 font-bold text-sm mt-2">Mẹo: Chọn phần của tập phim hoặc đổi nguồn phát
            dự phòng ở bên dưới nếu lỗi!</div>
        <div class="bg-[#151111] hover:bg-gray-900 font-bold text-sm text-white shadow text-center py-1 px-2 rounded cursor-pointer self-center"
            data-modal-toggle="report-modal">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" aria-hidden="true" class="w-5 h-5 inline">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg><span class="hidden md:inline">Báo Lỗi</span>
        </div>
    </div>
    <div id="report-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        Báo lỗi phim
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="report-modal" data>
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Đóng</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        <textarea id="report_message" class="w-full p-3" rows="5">Không tải được tập phim</textarea>
                    </p>
                </div>
                <div class="flex justify-end p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                    <button data-modal-toggle="report-modal" type="button" id="report_episode_btn"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Gửi</button>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-wrap justify-center gap-1 border-t-[1px] border-solid border-[#555] py-3 text-white"
        id="stream-servers">
        @foreach ($movie->episodes->where('slug', $episode->slug)->where('server', $episode->server) as $server)
            <a onclick="chooseStreamingServer(this)" data-type="{{ $server->type }}" data-id="{{ $server->id }}"
                data-link="{{ $server->link }}"
                class="streaming-server hover:cursor-pointer uppercase current bg-slate-600 px-3 py-2 mr-1 rounded text-sm">Dự
                phòng #{{ $loop->index }}
            </a>
        @endforeach
    </div>
    <div class="my-3 flex justify-center bg-slate-500 rounded-sm py-1">
        <div class="rating rating-md md:rating-lg">
            @for ($i = 1; $i <= 10; $i++)
                <input type="radio" name="rating" class="mask mask-star-2 bg-orange-500" value={{ $i }}
                    @if ($i == 9) checked @endif />
            @endfor
        </div>
    </div>
    @foreach ($movie->episodes->groupBy('server') as $server => $data)
        <div class="flex flex-col my-3 mt-6">
            <h2 id="heading-{{ $loop->index }}">
                <button
                    class="flex justify-between w-full px-4 py-2 text-sm font-medium text-left text-slate-200 bg-sky-800 rounded-sm"
                    data-accordion-target="#body-{{ $loop->index }}">
                    <span>{{ $server }}</span>
                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </h2>
            <div id="body-{{ $loop->index }}" class="mt-2">
                <div class="w-full grid grid-cols-3 md:grid-cols-6 lg:grid-cols-16 gap-2">
                    @foreach ($data->sortBy('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                        <a class="episode grow text-center hover:cursor-pointer shadow text-white py-2 bg-slate-600 rounded @if ($item->contains($episode)) bg-slate-900 @endif"
                            title="{{ $name }}" href="{{ $item->first()->getUrl() }}">
                            {{ $name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    <div class="fb-comments w-full rounded-lg bg-white" data-href="{{ $episode->getUrl() }}" data-width="100%"
        data-numposts="5" data-colorscheme="dark" data-lazy="true">
    </div>

    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.20.0/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="/js/jwplayer-8.9.3.js"></script>
    <script src="/js/hls.min.js"></script>
    <script src="/js/jwplayer.hlsjs.min.js"></script>
    <script>
        const wrapper = document.getElementById('player-wrapper');

        function chooseStreamingServer(el) {
            const type = el.dataset.type;
            const link = el.dataset.link;

            const newUrl =
                location.protocol +
                "//" +
                location.host +
                location.pathname +
                "?id=" + el.dataset.id;

            history.pushState({
                path: newUrl
            }, "", newUrl);

            Array.from(document.getElementsByClassName('streaming-server')).forEach(server => {
                server.classList.remove('bg-slate-900');
            })
            el.classList.add('bg-slate-900')

            renderPlayer(type, link);
        }

        function renderPlayer(type, link) {
            if (type == 'embed') {
                if (wrapper) {
                    wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                            allowfullscreen=""></iframe>;`
                }
                return;
            }

            if (type == 'm3u8' || type == 'mp4') {
                wrapper.innerHTML = `<div id="jwplayer"></div>`;
                const player = jwplayer("jwplayer");
                const objSetup = {
                    key: "{{ Setting::get('jwplayer_license') }}",
                    aspectratio: "16:9",
                    width: "100%",
                    file: link,
                    playbackRateControls: true,
                    playbackRates: [0.25, 0.75, 1, 1.25],
                    sharing: {
                        sites: [
                            "reddit",
                            "facebook",
                            "twitter",
                            "googleplus",
                            "email",
                            "linkedin",
                        ],
                    },
                    volume: 100,
                    mute: false,
                    logo: {
                        file: "{{ Setting::get('jwplayer_logo_file') }}",
                        link: "{{ Setting::get('jwplayer_logo_link') }}",
                        position: "{{ Setting::get('jwplayer_logo_position') }}",
                    },
                    advertising: {
                        tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                        client: "vast",
                        vpaidmode: "insecure",
                        skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                        skipmessage: "Bỏ qua sau xx giây",
                        skiptext: "Bỏ qua"
                    }
                };

                player.setup(objSetup);
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const episode = urlParams.get('id')
            let playing = document.querySelector(`[data-id="${episode}"]`);
            if (playing) {
                playing.click();
                return;
            }

            const servers = document.getElementsByClassName('streaming-server');
            if (servers[0]) {
                servers[0].click();
            }
        });
    </script>
    <script>
        document.getElementById('report_episode_btn').addEventListener('click', function() {
            fetch(location.href, {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    message: document.getElementById('report_message')
                        .innerHTML ??
                        ''
                })
            });
        })

        var rated = false;
        const radios = document.querySelectorAll('input[name="rating"]');
        radios.forEach(radio => {
            radio.addEventListener('click', function() {
                if (rated) return
                fetch("{{ route('movie.rating', ['movie' => $movie->slug, 'episode' => $episode->slug]) }}", {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute(
                                'content')
                    },
                    body: JSON.stringify({
                        rating: radio.value
                    })
                });
                rated = true;
            }, {
                once: true
            });
        });
    </script>
@endsection
