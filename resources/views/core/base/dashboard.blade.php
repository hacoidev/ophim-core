@extends(backpack_view('blank'))

@php
    $widgets['before_content'] = [
        [
            'type' => 'alert',
            'class' => 'alert alert-dark mb-2 col-12',
            'heading' => 'OPhimCMS - Tạo website xem phim miễn phí vĩnh viễn',
            'content' =>
                '
                Phiên bản: <span class="text-danger text-break">' .
                config('ophim.version') .
                '</span><br/>
                Trang chủ: <a href="https://ophimcms.com">OPhimCMS.Com</a><br/>
                Dữ liệu phim miễn phí: <a href="https://ophim5.cc">Ổ Phim</a>
            ',
            'close_button' => true, // show close button or not
        ],
    ];
@endphp

@section('content')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"
        integrity="sha512-d8F1J2kyiRowBB/8/pAWsqUl0wSEOkG5KATkVV4slfblq9VRQ6MyDZVxWl2tWd+mPhuCbpTB4M7uU/x9FlgQ9Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        jQuery(document).ready(function($) {
            $('.counter').counterUp({
                delay: 10,
                time: 500
            });
        });
    </script>
    <style>
        .card-counter {
            box-shadow: 2px 2px 10px #DADADA;
            margin: 5px 0;
            padding: 20px 10px;
            background-color: #fff;
            height: 100px;
            border-radius: 5px;
            transition: .3s linear all;
        }

        .card-counter:hover {
            box-shadow: 4px 4px 20px #DADADA;
            transition: .3s linear all;
        }

        .card-counter.primary {
            background-color: #007bff;
            color: #FFF;
        }

        .card-counter.danger {
            background-color: #ef5350;
            color: #FFF;
        }

        .card-counter.success {
            background-color: #66bb6a;
            color: #FFF;
        }

        .card-counter.info {
            background-color: #26c6da;
            color: #FFF;
        }

        .card-counter i {
            font-size: 5em;
            opacity: 0.2;
        }

        .card-counter .count-numbers {
            position: absolute;
            right: 35px;
            top: 20px;
            font-size: 32px;
            display: block;
        }

        .card-counter .count-name {
            position: absolute;
            right: 35px;
            top: 65px;
            font-style: italic;
            text-transform: capitalize;
            opacity: 0.5;
            display: block;
            font-size: 18px;
        }
    </style>
    <div class="row">
        <div class="col-md-2">
            <div class="card-counter primary">
                <i class="la la-play-circle"></i>
                <span class="count-numbers counter">{{ $count_movies }}</span>
                <span class="count-name">Tổng số phim</span>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card-counter info">
                <i class="las la-server"></i>
                <span class="count-numbers counter">{{ $count_episodes }}</span>
                <span class="count-name">Tổng số tập</span>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card-counter danger">
                <i class="las la-bug"></i>
                <span class="count-numbers counter">{{ $count_episodes_error }}</span>
                <span class="count-name">Tập lỗi</span>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card-counter success">
                <i class="las la-user"></i>
                <span class="count-numbers counter">{{ $count_users }}</span>
                <span class="count-name">Users</span>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card-counter bg-primary">
                <i class="la la-paint-brush"></i>
                <span class="count-numbers counter">{{ $count_themes }}</span>
                <span class="count-name">Giao diện</span>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card-counter">
                <i class="las la-puzzle-piece"></i>
                <span class="count-numbers counter">{{ count(config('plugins', [])) }}</span>
                <span class="count-name">Plugins</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="p-3 col-md-4">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th colspan="2" scope="col">TOP NGÀY</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($top_view_day as $movie)
                        <tr>
                            <td><a href="{{ $movie->getUrl() }}">{{ $movie->name }}</a></td>
                            <td class="text-right"><span class="badge badge-success"><i class="las la-eye"></i> {{ $movie->view_day }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3 col-md-4">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th colspan="2" scope="col">TOP TUẦN</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($top_view_week as $movie)
                        <tr>
                            <td><a href="{{ $movie->getUrl() }}">{{ $movie->name }}</a></td>
                            <td class="text-right"><span class="badge badge-success"><i class="las la-eye"></i> {{ $movie->view_week }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3 col-md-4">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th colspan="2" scope="col">TOP THÁNG</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($top_view_month as $movie)
                        <tr>
                            <td><a href="{{ $movie->getUrl() }}">{{ $movie->name }}</a></td>
                            <td class="text-right"><span class="badge badge-success"><i class="las la-eye"></i> {{ $movie->view_month }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
