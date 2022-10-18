<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="robots" content="none, noindex, nofollow, noarchive, nosnippet" />

<title>{!! Meta::get('title') !!}</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="mobile-web-app-capable" content="yes">
<meta name="theme-color" content="#FFFFFF">

<link rel="canonical" href="{{ config('app.url') }}">

<link rel="stylesheet" href="@asset('build/css/main.min.css')" />

<link rel="icon" href="@asset('favicon.ico')" type="image/png">

<script>const WWW = '{{ rtrim(asset('/'), '/') }}';</script>