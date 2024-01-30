<meta charset="utf-8">

<title>{!! Meta::get('title') !!}</title>

<meta name="apple-mobile-web-app-status-bar-style" content="white-translucent">
<meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}" />
<meta name="application-name" content="{{ config('app.name') }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="mobile-web-app-capable" content="yes" />
<meta name="robots" content="none, noindex, nofollow, noarchive, nosnippet" />
<meta name="theme-color" content="#FFFFFF">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="apple-touch-icon" type="image/png" href="@asset('build/images/webapp/logo.png')" />
<link rel="apple-touch-startup-image" type="image/png" href="@asset('build/images/webapp/startup.png')" />
<link rel="icon" href="@asset('favicon.ico')" type="image/png">
<link rel="manifest" href="@asset('manifest.json')" defer="defer"/>
<link rel="shortcut icon" type="image/png" href="@asset('build/images/webapp/logo.png')" />
<link rel="stylesheet" href="@asset('build/css/main.min.css')" />

<script>
const WWW = '{{ rtrim(asset('/'), '/') }}';
</script>
