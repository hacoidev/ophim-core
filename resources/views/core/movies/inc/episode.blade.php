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
        <div id="raw-episode-info" style="display: none" class="form-group">
            <label>Định dạng (Mỗi dòng 1 tập)</label>
            <div class="alert alert-info">
                <h6>Định dạng (<span class="badge badge-danger">Sửa</span>): <span class="text-warning">name|link|type|slug|id</span></h6>
                <h6>Định dạng (<span class="badge badge-success">Thêm</span>): <span class="text-warning">name|link|type|slug</span></h6>
                <h6>Định dạng (<span class="badge badge-success">Thêm</span>): <span class="text-warning">name|link|type</span></h6>
                <h6>Định dạng (<span class="badge badge-success">Thêm</span>): <span class="text-warning">name|link</span></h6>
                <h6>Định dạng (<span class="badge badge-success">Thêm</span>): <span class="text-warning">link</span></h6>
                <hr/>
                <h6><span class="text-warning">id</span>: ID row sql (<span class="badge badge-danger">Không được thêm sửa xóa field này</span>)</h6>
                <h6><span class="text-warning">type</span>: 1 trong 3 định dạng - <b>mp4,m3u8,embed</b></h6>
            </div>
            <textarea class="form-control" id="raw-episode-data" rows="5"></textarea>
        </div>
        <div class="input-group mb-3 col-md-6 px-0">
            <button type="button" class="btn btn-info raw-episode-btn">
                <i class="las la-pencil-ruler"></i>
                Sửa nhanh
            </button>
            <button style="display: none" type="button" class="btn btn-success ml-1 raw-episode-save-btn">
                <i class="las la-save"></i>
                Cập nhật
                <span class="text-warning"></span>
            </button>
            <button style="display: none" type="button" class="btn btn-default ml-1 raw-episode-cancel-btn">
                <i class="las la-remove-format"></i>
                Hủy
            </button>
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
                            <button type="button" class="btn btn-warning add-episode-btn" data-server="{{ $loop->index }}"
                                data-server-name="{{ $server }}">
                                <i class="las la-plus"></i>
                                Thêm tập mới
                            </button>
                            <button type="button" class="btn btn-danger ml-2 float-right delete-server">
                                <i class="las la-trash"></i>
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
                            <i class="las la-plus"></i>
                            Thêm tập mới
                        </button>
                        <button type="button" class="btn btn-danger ml-2 float-right delete-server">
                            <i class="las la-trash"></i>
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
    var editor;

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
                                <i class="las la-plus"></i>
                                Thêm tập mới
                            </button>
                            <button type="button" class="btn btn-danger float-right delete-server">
                                <i class="las la-trash"></i>
                                Xóa server
                            </button>
                        </div>
                    </div>`;
        }

        $('#episode-server-list').append(templateList(serverCount, serverName));
        $('#episode-server-data').append(templateData(serverCount, serverName));

        $('.episode-server[data-toggle="tab"]').last().click();
        getRawItems();
    });

    $(document).on('click', '.delete-server', function(e) {
        const tab = $(this).closest('.tab-pane');
        const tabLink = $(`.nav-link[href="#${$(tab).attr('id')}"]`);
        $(tab).remove();
        $(tabLink).closest('.nav-item').remove();
        updateNameAttr();
        $('.episode-server[data-toggle="tab"]').last().click();
    });

    const templateEpisode = (i, server, item = null, fake_name = 0) => {
        var [name, link, type, slug, id] = ['','','','',''];
        if (item) {
            let countItem = item.split('|').length;
            if(countItem === 1) {
                link = item;
            } else {
                [name, link, type, slug, id] = item.split('|');
            }

            if(!name) {
                name = fake_name;
            }
            if(!type) {
                if(link.indexOf('.m3u8') !== -1) type = 'm3u8'
                if(link.indexOf('.mp4') !== -1) type = 'mp4'
            }
            if(!slug) slug = `tap-${change_alias(name.toString())}`;
        }
        return `<tr class="episode">
                    <input type="hidden" name="episodes[${i}][id]" value="${id}" data-attr-name="id">
                    <input type="hidden" class="episode-server" value="${server}" data-attr-name="server">
                    <td><input type="text" placeholder="${name || '1'}" value="${name || '1'}"
                            class="ep_name form-control" data-attr-name="name">
                    </td>
                    <td><input type="text" placeholder="${slug || 'tap-1'}" value="${slug || 'tap-1'}"
                            class="form-control" data-attr-name="slug"></td>
                    <td>
                        <select data-attr-name="type" class="form-control">
                            @foreach (config('ophim.episodes.types', []) as $key => $name)
                                <option value="{{ $key }}" ${'{{$key}}' == type ? 'selected' : ''}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" placeholder="" value="${link || ''}"
                            class="form-control" data-attr-name="link"></td>
                    <td class="text-center"><span style="cursor:pointer"
                            class="badge outline-badge-danger delete-episode">Xóa</span></td>
                </tr>`
    }

    $(document).on('click', '.add-episode-btn', function(e) {
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

    function change_alias(string) {
        slug = string.toLowerCase();
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, "a");
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, "e");
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, "i");
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, "o");
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, "u");
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, "y");
        slug = slug.replace(/đ/gi, "d");
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|\–|_/gi, "");
        slug = slug.replace(/ /gi, "-");
        slug = slug.replace(/\-\-\-\-\-/gi, "-");
        slug = slug.replace(/\-\-\-\-/gi, "-");
        slug = slug.replace(/\-\-\-/gi, "-");
        slug = slug.replace(/\-\-/gi, "-");
        slug = slug.replace("à", "a");
        slug = "@" + slug + "@";
        slug = slug.replace(/\@\-|\-\@|\@/gi, "");
        return slug;
    }

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js" integrity="sha512-8RnEqURPUc5aqFEN04aQEiPlSAdE0jlFS/9iGgUyNtwFnSKCXhmB6ZTNl7LnDtDWKabJIASzXrzD0K+LYexU9g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css" integrity="sha512-uf06llspW44/LZpHzHT6qBOIVODjWtv4MxCricRxkzvopAlSWnTf6hpZTFxuuZcuNE9CBQhqE0Seu1CoRk84nQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script>

    function getRawItems(curserver) {
        if (!$('.raw-episode-save-btn').is(':visible')) return;
        let currentServerId = $("#episode-server-data .tab-pane.active").attr("id").split('episode-server-')[1];
        let currentServerName = curserver ?? $(".nav-link.episode-server.active").text();
        $('.raw-episode-save-btn span').html(currentServerName);

        let arrId = $("input[data-attr-name=id]");
        let arrServer = $("input[data-attr-name=server]");
        let arrName = $("input[data-attr-name=name]");
        let arrSlug = $("input[data-attr-name=slug]");
        let arrType = $("select[data-attr-name=type]");
        let arrLink = $("input[data-attr-name=link]");

        let itemsCurrentServer = [];
        for (let index = 0; index < arrServer.length; index++) {
            const server = arrServer[index].value;
            if (server === currentServerName) {
                let itemId = arrId[index].value;
                let itemServer = server;
                let itemName = arrName[index].value;
                let itemSlug = arrSlug[index].value;
                let itemType = arrType[index].value;
                let itemLink = arrLink[index].value;
                itemsCurrentServer.push(`${itemName}|${itemLink}|${itemType}|${itemSlug}|${itemId}`);
            }
        }

        editor = editor ?? CodeMirror.fromTextArea(document.getElementById('raw-episode-data'), {
            lineNumbers: true
        });
        editor.getDoc().setValue(itemsCurrentServer.join("\n"));
    }
    $(document).on('click', '.nav-link.episode-server', function(e) {
        e.preventDefault();
        if($(this).hasClass('active') === false) getRawItems(e.target.text);
    })
    $(document).on('click', '.raw-episode-cancel-btn', function(e) {
        updateNameAttr();
        $(this).hide(200);
        $('.raw-episode-save-btn').hide(200);
        $('#raw-episode-info').hide(200);
        $('.raw-episode-btn').show(200);
        $(".delete-episode").show();

        $(".add-episode-btn").removeAttr("disabled");
        $(".delete-server").removeAttr("disabled");
        $("button[type=submit]").removeAttr("disabled");
    })
    $(document).on('click', '.raw-episode-btn', function(e) {
        $(this).hide(200);
        $(".add-episode-btn").attr("disabled", true);
        $(".delete-server").attr("disabled", true);
        $("button[type=submit]").attr("disabled", true);
        $(".delete-episode").hide();

        $('.raw-episode-save-btn').show(200);
        $('.raw-episode-cancel-btn').show(200);
        $('#raw-episode-info').show(200);
        getRawItems();
    })

    $(document).on('click', '.raw-episode-save-btn', function(e) {
        let currentServerId = $("#episode-server-data .tab-pane.active").attr("id").split('episode-server-')[1];
        let currentServerName = $(".nav-link.episode-server.active").text();
        let rawItems = editor.getValue();
        rawItems = rawItems.split("\n");
        var fake_name = 1;
        $(`#episode-server-${currentServerId} table tbody`).empty();
        for (let index = 0; index < rawItems.length; index++) {
            const item = rawItems[index];
            if(item !== '') {
                $(`#episode-server-${currentServerId} table tbody`).append(templateEpisode($('.episode').length, currentServerName, item, fake_name))
                fake_name++;
            };
        }
        updateNameAttr();
        $(this).hide(200);
        $('.raw-episode-cancel-btn').hide(200);
        $('#raw-episode-info').hide(200);
        $('.raw-episode-btn').show(200);
        $(".delete-episode").show();

        $(".add-episode-btn").removeAttr("disabled");
        $(".delete-server").removeAttr("disabled");
        $("button[type=submit]").removeAttr("disabled");
    })
</script>
