@php
$title = isset($title) ? $title : Backpack\Settings\app\Models\Setting::get('site.homepage.title') ?: '';
$metaSiteName = isset($metaSiteName) ? $metaSiteName : Backpack\Settings\app\Models\Setting::get('site.meta.siteName') ?: '';
$metaShortcutIcon = Backpack\Settings\app\Models\Setting::get('site.meta.shortcut.icon') ?: '';
$metaKeywords = isset($metaKeywords) ? $metaKeywords : Backpack\Settings\app\Models\Setting::get('site.meta.keywords') ?: '';
$metaDescription = isset($metaDescription) ? $metaDescription : Backpack\Settings\app\Models\Setting::get('site.meta.description') ?: '';
$metaImage = isset($metaImage) ? $metaImage : Backpack\Settings\app\Models\Setting::get('site.meta.image') ?: '';
$metaTitle = isset($metaTitle) ? $metaTitle : $title;
@endphp

<meta name="viewport" content="initial-scale=1.0, width=device-width" />
<meta http-equiv="content-language" content="vi" />
<link rel="shortcut icon" href="{{ $metaShortcutIcon }}" type="image/png" />
<meta charSet="utf-8" />
<meta name="robots" content="index,follow" />
<meta name="revisit-after" content="1 days" />
<meta name="ROBOTS" content="index,follow" />
<meta name="googlebot" content="index,follow" />
<meta name="BingBOT" content="index,follow" />
<meta name="yahooBOT" content="index,follow" />
<meta name="slurp" content="index,follow" />
<meta name="msnbot" content="index,follow" />
<meta name="author" content="{{ $metaSiteName }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="keywords" content="{{ $metaKeywords }}" />
<meta name="description" content="{{ $metaDescription }}" />
<meta itemProp="description" content="{{ $metaDescription }}" />
<meta property="og:description" content="{{ $metaDescription }}" />
<meta name="twitter:description" content="{{ $metaDescription }}" />

<meta name="image" content="{{ url($metaImage) }}" />
<meta name="twitter:image" content="{{ url($metaImage) }}" />
<meta property="og:image" content="{{ url($metaImage) }}" alt="{{ $metaTitle }}" />

<meta property="og:title" content="{{ $metaTitle }}" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content="{{ $metaSiteName }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:locale" content="vi_VN" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="{{ $metaTitle }}" />

<meta property="fb:admins" content="" />
<meta property="fb:app_id" content="244824714144384" />
<meta name="google-site-verification" content="1gjjSkXb6oeUY93m0OZ1o-M831hqA7DAnYzJqdqtuH0" />

<link rel="canonical" href="{{ url()->current() }}" />
<link rel="alternate" href="{{ url()->current() }}" hrefLang="vi-vn" />

<title>{{ $title }}</title>
