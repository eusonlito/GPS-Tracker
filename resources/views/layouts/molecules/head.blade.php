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

<script>
const WWW = '{{ rtrim(asset('/'), '/') }}';
</script>

<link rel="manifest" href="@asset('manifest.json')" defer="defer"/>

<meta name="mobile-web-app-capable" content="yes" />
<meta name="application-name" content="{{ config('app.name') }}" />
<meta name="theme-color" content="white" />

<link rel="shortcut icon" type="image/png" href="@asset('build/images/webapp/logo.png')" />

<meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}" />
<meta name="apple-mobile-web-app-status-bar-style" content="white-translucent">

<link rel="apple-touch-icon" type="image/png" href="@asset('build/images/webapp/logo.png')" />
<link rel="apple-touch-startup-image" type="image/png" href="@asset('build/images/webapp/startup.png')" />
