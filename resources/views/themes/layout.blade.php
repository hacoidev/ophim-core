<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charSet="utf-8" />
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <meta http-equiv="content-language" content="{{ config('app.locale') }}" />
    <meta name="robots" content="index,follow" />
    <meta name="revisit-after" content="1 days" />
    <meta name="ROBOTS" content="index,follow" />
    <meta name="googlebot" content="index,follow" />
    <meta name="BingBOT" content="index,follow" />
    <meta name="yahooBOT" content="index,follow" />
    <meta name="slurp" content="index,follow" />
    <meta name="msnbot" content="index,follow" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="fb:app_id" content="{{ setting('social_facebook_app_id') }}" />
    <link rel="shortcut icon" href="{{ setting('site_meta_shortcut_icon') }}" type="image/png" />
    {!! SEO::generate() !!}

    @stack('header')
    {!! get_theme_option('additional_css') !!}
    {!! get_theme_option('additional_header_js') !!}
</head>

<body {!! get_theme_option('body_attributes', '') !!}>
    @yield('body')
    {!! get_theme_option('additional_body_js') !!}

    @yield('footer')
    @stack('scripts')
    {!! get_theme_option('additional_footer_js') !!}
</body>

</html>
