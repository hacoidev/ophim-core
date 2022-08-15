@php
use Backpack\Settings\app\Models\Setting;

$metaShortcutIcon = Setting::get('site.meta.shortcut.icon') ?: '';
@endphp

<meta charSet="utf-8" />
<meta name="viewport" content="initial-scale=1.0, width=device-width" />
<meta http-equiv="content-language" content="vi" />
<link rel="shortcut icon" href="{{ $metaShortcutIcon }}" type="image/png" />
<meta name="robots" content="index,follow" />
<meta name="revisit-after" content="1 days" />
<meta name="ROBOTS" content="index,follow" />
<meta name="googlebot" content="index,follow" />
<meta name="BingBOT" content="index,follow" />
<meta name="yahooBOT" content="index,follow" />
<meta name="slurp" content="index,follow" />
<meta name="msnbot" content="index,follow" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta property="fb:app_id" content="{{ setting('social.facebook.app_id') }}" />

{!! SEO::generate() !!}
