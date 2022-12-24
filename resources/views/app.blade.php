<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cubik3') }}</title>

    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link href="https://rsms.me/inter/inter.css" rel="preload" as="style" />
    <link href="https://rsms.me/inter/inter.css" rel="stylesheet" media="print" onload="this.media='all'">
</head>
<body class="dark:bg-zinc-900 dark:text-zinc-200">
    <div id="app">
        <app-nav logo="{{ config('app.logo') }}"></app-nav>
        <router-view></router-view>
    </div>
    @if ($user)
        <script type="application/json" id="userData">
            @json($user)
        </script>
    @endif
</body>
</html>
