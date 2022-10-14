<?php
$index = 0;
$episodes = collect(old('episodes', isset($entry) ? $entry->episodes : []));
?>
<div class="mb-4">
    <div class="p-0">
        <div class="input-group mb-3 col-md-6 px-0">
            <input id="new-server-name" type="text" value="Thuyết minh #1" placeholder="Tên server" class="form-control">
            <span class="input-group-append">
                <button type="button" id="add-server-btn" class="btn btn-success">
                    Thêm
                    <i class="la la-plus"></i>
                </button>
            </span>
        </div>

        <ul class="nav nav-tabs" role="tablist" id="episode-server-list">
            @if (count($episodes))
                @foreach ($episodes->groupBy('server') as $server => $data)
                    <li class="nav-item"><a
                            class="nav-link episode-server @if ($loop->first) active @endif"
                            data-toggle="tab" href="#episode-server-{{ $loop->index }}" role="tab"
                            aria-controls="home" aria-selected="true" contenteditable
                            onblur="updateEpisodeServer(this)">{{ $server }}</a>
                    </li>
                @endforeach
            @else
                <li class="nav-item"><a class="nav-link episode-server active" data-toggle="tab"
                        href="#episode-server-0" role="tab" aria-controls="home" aria-selected="true"
                        contenteditable onblur="updateEpisodeServer(this)">Vietsub
                        #1</a>
                </li>
            @endif
        </ul>
        <div class="tab-content" id="episode-server-data">
            @if (count($episodes))
                @foreach ($episodes->groupBy('server') as $server => $data)
                    <div class="tab-pane @if ($loop->first) active @endif"
                        id="episode-server-{{ $loop->index }}" role="tabpanel">
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="min-width: 100px;">Tên</th>
                                        <th style="min-width: 100px;">Slug</th>
                                        <th style="min-width: 100px;">Type</th>
                                        <th style="min-width: 300px;">Link</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->sortBy('name', SORT_NATURAL)->groupBy('name') as $sortedEpisodes)
                                    @foreach ($sortedEpisodes as $episode)
                                    <tr class="episode">
                                        <input type="hidden" name="episodes[{{ $index }}][id]"
                                            value="{{ $episode['id'] ?? $episode->id ?? '' }}" data-attr-name="id">
                                        <input type="hidden" class="episode-server"
                                            name="episodes[{{ $index }}][server]" value="{{ $server }}"
                                            data-attr-name="server">
                                        <td><input type="text" name="episodes[{{ $index }}][name]"
                                                placeholder="Tập 1"
                                                value="{{ $episode['name'] ?? $episode->name }}"
                                                class="ep_name form-control" data-attr-name="name">
                                        </td>
                                        <td><input type="text" name="episodes[{{ $index }}][slug]"
                                                placeholder="tap-1"
                                                value="{{ $episode['slug'] ?? $episode->slug }}"
                                                class="form-control" data-attr-name="slug"></td>
                                        <td>
                                            <select name="episodes[{{ $index }}][type]"
                                                data-attr-name="type" class="form-control">
                                                @foreach (config('ophim.episodes.types', []) as $key => $name)
                                                    <option value="{{ $key }}"
                                                        @if (($episode['type'] ?? $episode->type) == $key) selected @endif>
                                                        {{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" name="episodes[{{ $index }}][link]"
                                                placeholder="" class="form-control" data-attr-name="link"
                                                value="{{ $episode['link'] ?? ($episode->link ?? '') }}">
                                        </td>
                                        <td class="text-center"><span style="cursor:pointer"
                                                class="badge outline-badge-danger delete-episode">Xóa</span></td>
                                    </tr>
                                    @php $index++; @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="5"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="form-inline justify-content-left mb-3 px-0">
                            <button type="button" class="btn btn-warning add-episode-btn" data-server="0"
                                data-server-name="Vietsub #1">
                                Thêm tập mới
                            </button>
                            <button type="button" class="btn btn-danger ml-2 float-right delete-server">
                                Xóa server
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="tab-pane active" id="episode-server-0" role="tabpanel">
                    <div class="form-inline justify-content-left mb-3 px-0">
                        <button type="button" class="btn btn-warning add-episode-btn" data-server="0"
                            data-server-name="Vietsub #1">
                            Thêm tập mới
                        </button>
                        <button type="button" class="btn btn-danger ml-2 float-right delete-server">
                            Xóa server
                        </button>
                    </div>
                    <div class="table-responsive" style="max-height: 400px; overflow:auto;">
                        <table class="table table-bordered mb-4">
                            <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th>Slug</th>
                                    <th>Type</th>
                                    <th>Link</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="episode">
                                    <input type="hidden" class="episode-server" name="episodes[0][server]"
                                        value="Vietsub #1" data-attr-name="server">
                                    <td><input type="text" name="episodes[0][name]" placeholder="1" value="1"
                                            class="ep_name form-control" data-attr-name="name">
                                    </td>
                                    <td><input type="text" name="episodes[0][slug]" placeholder="tap-1"
                                            value="tap-1" class="form-control" data-attr-name="slug"></td>
                                    <td>
                                        <select name="episodes[0][type]" data-attr-name="type" class="form-control">
                                            @foreach (config('ophim.episodes.types', []) as $key => $name)
                                                <option value="{{ $key }}">
                                                    {{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="episodes[0][link]" placeholder=""
                                            class="form-control" data-attr-name="link"></td>
                                    <td class="text-center"><span style="cursor:pointer"
                                            class="badge outline-badge-danger delete-episode">Xóa</span></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $("#add-server-btn").click(function(e) {
        const serverCount = $('#episode-server-list').children('.nav-item').length;
        const serverName = $('#new-server-name').val();

        const templateList = (i, name) => {
            return `<li class="nav-item"><a class="nav-link episode-server" data-toggle="tab" href="#episode-server-${i}"
                            role="tab" aria-controls="episode-server-${i}" aria-selected="true" contenteditable>${name}</a>
                    </li>`;
        }
        const templateData = (i, name) => {
            return `<div class="tab-pane" id="episode-server-${i}" role="tabpanel">
                        <div class="table-responsive mb-3" style="max-height: 400px; overflow:auto;">
                            <table class="table table-bordered mb-4">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Type</th>
                                        <th>Link</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="form-inline justify-content-left mb-3 px-0">
                            <button type="button" class="btn btn-warning mr-2 add-episode-btn" data-server="${i}" data-server-name="${name}">
                                Thêm tập mới
                            </button>
                            <button type="button" class="btn btn-danger float-right delete-server">
                                Xóa server
                            </button>
                        </div>
                    </div>`;
        }

        $('#episode-server-list').append(templateList(serverCount, serverName));
        $('#episode-server-data').append(templateData(serverCount, serverName));

        $('.episode-server[data-toggle="tab"]').last().click();
    });

    $(document).on('click', '.delete-server', function(e) {
        const tab = $(this).closest('.tab-pane');
        const tabLink = $(`.nav-link[href="#${$(tab).attr('id')}"]`);
        $(tab).remove();
        $(tabLink).closest('.nav-item').remove();
        updateNameAttr();
        $('.episode-server[data-toggle="tab"]').last().click();
    });

    $(document).on('click', '.add-episode-btn', function(e) {
        const templateEpisode = (i, server) => {
            return `<tr class="episode">
                        <input type="hidden" class="episode-server" value="${server}" data-attr-name="server">
                        <td><input type="text" placeholder="Tập 1" value="1"
                                class="ep_name form-control" data-attr-name="name">
                        </td>
                        <td><input type="text" placeholder="tap-1" value="tap-1"
                                class="form-control" data-attr-name="slug"></td>
                        <td>
                            <select data-attr-name="type" class="form-control">
                                @foreach (config('ophim.episodes.types', []) as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="text" placeholder="" value=""
                                class="form-control" data-attr-name="link"></td>
                        <td class="text-center"><span style="cursor:pointer"
                                class="badge outline-badge-danger delete-episode">Xóa</span></td>
                    </tr>`
        }
        $(`#episode-server-${$(this).data('server')} table tbody`).append(templateEpisode($('.episode')
            .length, $(this).data('server-name')));
        updateNameAttr();
    })


    $(document).on('click', '.delete-episode', function(e) {
        $(this).closest('tr').remove();
        updateNameAttr();
    })

    function updateEpisodeServer(el) {
        $($(el).attr('href')).find('.episode-server').val($(el).html().trim());
        $($(el).attr('href')).find('.add-episode-btn').data('server-name', $(el).html().trim());
    }

    function updateNameAttr() {
        $('.episode').each((index, episode) => {
            $(episode).find('[data-attr-name]').each((i, attr) => {
                const attrName = $(attr).attr('data-attr-name').split('.').reduce((a, b) =>
                    `${a}[${b}]`, '')
                $(attr).attr('name', `episodes[${index}]${attrName}`)
            })
        })
    }
</script>
