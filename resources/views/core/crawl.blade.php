@extends(backpack_view('blank'))

@php
$defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    'Crawler' => backpack_url('movie/crawl'),
];

$breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">Movies</span>
            <small>Crawler</small>
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 steps">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @csrf
                        <div class="form-group col-12 mb-3">
                            <label for="">Link</label>
                            <input type="text" class="form-control" name="link"
                                value="https://ophim1.com/danh-sach/phim-moi-cap-nhat">
                        </div>
                        <div class="form-group col-6">
                            <label>Từ page</label>
                            <input type="number" class="form-control" name="from" min="0" value="1">
                        </div>
                        <div class="form-group col-6">
                            <label>Tới page</label>
                            <input type="number" class="form-control" name="to" min="0" value="1">
                        </div>
                        <div class="form-group col-6">
                            <button class="btn btn-primary btn-load">Tải</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 steps d-none">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-12">
                            <h4>Chọn phim</h4>
                            <p>Đã chọn <span class="selected-movie-count">0</span>/<span class="total-movie-count">0</span>
                                phim</p>
                            <div class="form-group row">
                                <div class="w-100 px-3 col-form-label overflow-auto" id="movie-list" style="height: 20rem">

                                </div>
                            </div>
                            <button class="btn btn-secondary btn-previous">Trước</button>
                            <button class="btn btn-primary btn-next">Tiếp</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 steps d-none">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-6">
                            <button class="btn btn-secondary btn-cancel">Trước</button>
                            <button class="btn btn-primary btn-next">Xong</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.btn-load').click(function(e) {
            const btn = $(this);
            const link = $('input[name="link"]').val();
            const from = $('input[name="from"]').val();
            const to = $('input[name="to"]').val();

            if (!link) {
                $('input[name="link"]').addClass('is-invalid');
                return;
            }
            $('input[name="link"]').removeClass('is-invalid');
            $('.btn-load').html('Đang tải...');

            const fetchApi = async (link, from, to) => {
                const response = await fetch("{{ backpack_url('movie/crawl/fetch') }}?" +
                    new URLSearchParams({
                        link,
                        from,
                        to
                    }));

                if (response.status >= 200 && response.status < 300) {
                    return {
                        response: response,
                        payload: await response.json()
                    }
                }

                throw {
                    response
                }
            }

            fetchApi(link, from, to).then(res => {
                if (res.payload.length > 0) {
                    const template = (data) => {
                        let html = '';
                        data.forEach((item, i) => {
                            html += `<div class="form-check checkbox">
                                        <input class="movie-checkbox" id="movie-${i}" type="checkbox" value="${encodeURI(JSON.stringify(item))}" checked>
                                        <label class="form-check-label" for="movie-${i}">${item.name}</label>
                                    </div>`;
                        })
                        return html;
                    }
                    $('.steps').addClass('d-none');
                    $(btn).closest('.steps').next().removeClass('d-none');
                    $('.total-movie-count').html(res.payload.length)
                    $('.selected-movie-count').html(res.payload.length)
                    $('#movie-list').html(template(res.payload))
                }
            }).catch(err => {
                $('input[name="link"]').addClass('is-invalid');
            }).finally(() => {
                $('.btn-load').html('Tải');
            })
        })

        $('.btn-next').click(function() {
            const values = $(".movie-checkbox:checked")
                .map(function() {
                    console.log(decodeURI($(this).val()));
                    return JSON.parse(decodeURI($(this).val()));
                }).get();
            console.log(values);
            $('.steps').addClass('d-none');
            $(this).closest('.steps').next().removeClass('d-none');
        })

        $('.btn-previous').click(function() {
            $('.steps').addClass('d-none');
            $(this).closest('.steps').prev().removeClass('d-none');
        })

        $(document).on('change', '.movie-checkbox', function() {
            $('.selected-movie-count').html($('.movie-checkbox:checked').length)
        })
    </script>
@endsection
