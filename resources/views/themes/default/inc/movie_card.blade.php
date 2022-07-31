<a class="block " href="{{ $movie->getUrl() }}">
    <div class="flex justify-center items-stretch h-full" title="{{ $movie->name ?? '' }}">
        <div
            class=" max-w-xs container bg-[#151111] rounded-lg shadow-lg transform transition duration-500 hover:scale-105 hover:shadow-2xl">
            <div class="relative">
                <img class="w-full cursor-pointer rounded-t-lg" style="aspect-ratio: 256/340" src="{{ $movie->thumb_url }}"
                    alt="" />
                <div class="absolute top-1 left-1 ">
                    <p class="block badge bg-red-500 mb-1 border-0 text-white">{{ $movie->quality }} - {{ $movie->language }}</p>
                </div>
                <div class="absolute bottom-1 right-1 text-white">
                    <p class="block badge badge-success mb-1 border-0 text-white">{{ $movie->episode_current }}</p>
                </div>
            </div>
            <div class="flex p-4 justify-between grow">
                <div class="w-full ">
                    <p class="text-gray-200 cursor-pointer text-sm truncate">{{ $movie->name ?? '' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</a>
