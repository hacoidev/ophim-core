<header class="{{ config('backpack.base.header_class') }}">
  <!-- Logo -->
  <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto ml-3" type="button" data-toggle="sidebar-show" aria-label="{{ trans('backpack::base.toggle_navigation')}}">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="{{ url(config('backpack.base.home_link')) }}" title="{{ config('backpack.base.project_name') }}">
    {!! setting('site_logo') ?? config('backpack.base.project_logo') !!}
    <h6><span class="badge badge-danger">v{{ config('ophim.version') }}</span></h6>
  </a>
  <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show" aria-label="{{ trans('backpack::base.toggle_navigation')}}">
    <span class="navbar-toggler-icon"></span>
  </button>

  @include(backpack_view('inc.menu'))
</header>
