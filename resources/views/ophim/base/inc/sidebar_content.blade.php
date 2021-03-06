<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}</a></li>
<li class="nav-title">Phim</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('movie') }}'><i class='nav-icon la la-play-circle'></i>
        Danh sách phim</a></li>
<li class="nav-title">Phân loại</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('category') }}'><i class='nav-icon la la-at'></i> Thể
        loại</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('tag') }}'><i class='nav-icon la la-link'></i> Tags</a>
</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('region') }}'><i class='nav-icon la la-globe'></i> Khu
        vực</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('actor') }}'><i class='nav-icon la la-gratipay'></i>
        Diễn viên</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('director') }}'><i
            class='nav-icon la la-odnoklassniki'></i> Đạo diễn</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('studio') }}'><i
            class='nav-icon la la-connectdevelop'></i> Studio</a></li>

<li class="nav-title">Cài đặt</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('menu') }}'><i class='nav-icon la la-list'></i>
        Menus</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting') }}'><i class='nav-icon la la-cog'></i>
        <span>Settings</span></a></li>
