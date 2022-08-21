<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}</a></li>
<li class="nav-title">Phim</li>
<li class='nav-item'>
    <a class='nav-link' href='{{ backpack_url('movie') }}'><i class='nav-icon la la-play-circle'></i>
        Danh sách phim</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('crawl-schedule') }}">
        <i class="nav-icon la la-calendar-check-o"></i> Tự động cập nhật
    </a>
</li>

<li class="nav-item nav-dropdown"><a class="nav-link nav-dropdown-toggle" href="#"><i
            class="nav-icon la la-list"></i> Phân loại</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('category') }}'><i class='nav-icon la la-at'></i>
                Thể loại</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('tag') }}'><i class='nav-icon la la-link'></i>
                Tags</a>
        </li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('region') }}'><i
                    class='nav-icon la la-globe'></i> Khu
                vực</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('actor') }}'><i
                    class='nav-icon la la-gratipay'></i>
                Diễn viên</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('director') }}'><i
                    class='nav-icon la la-odnoklassniki'></i> Đạo diễn</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('studio') }}'><i
                    class='nav-icon la la-connectdevelop'></i> Studio</a></li>
    </ul>
</li>

<li class='nav-item'>
    <a class='nav-link' href='{{ backpack_url('episode') }}'><i class='nav-icon la la-info-circle'></i>
        Phim lỗi</a>
</li>

<li class="nav-title">Tuỳ chỉnh</li>
<li class="nav-item nav-dropdown"><a class="nav-link nav-dropdown-toggle" href="#"><i
            class="nav-icon la la-paint-brush"></i> Giao diện</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('theme') }}"><i
                    class="nav-icon la la-photo"></i>Chủ đề</a>
        </li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('menu') }}'><i class='nav-icon la la-list'></i>
                Menu</a>
        </li>
    </ul>
</li>
<li class="nav-item nav-dropdown"><a class="nav-link nav-dropdown-toggle" href="#"><i
            class="nav-icon la la-cog"></i> Cài đặt</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting/group/generals/edit') }}'><i
                    class='nav-icon la la-wrench'></i>
                <span>General</span></a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting/group/metas/edit') }}'><i
                    class='nav-icon la la-chevron-circle-up'></i>
                <span>SEO</span></a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting/group/jwplayer/edit') }}'><i
                    class='nav-icon la la-play'></i>
                <span>Jwplayer</span></a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting/group/others/edit') }}'><i
                    class='nav-icon la la-slack'></i>
                <span>Khác</span></a></li>
    </ul>
</li>

<li class="nav-title">Mở rộng</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('plugin') }}">
        <i class="nav-icon la la-plug"></i> Tiện ích
    </a>
</li>

@if (backpack_user()->hasRole('Admin'))
    <li class="nav-title">{{ trans('backpack::base.administration') }}</li>
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i>
            Authentication</a>
        <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i
                        class="nav-icon la la-user"></i>
                    <span>Users</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i
                        class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        </ul>
    </li>

    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('log') }}'><i
                class='nav-icon la la-terminal'></i>
            Logs</a></li>
@endif
