<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Vue</title>
    <!-- Scripts -->
    <script src="public/vendor/statement-analyzer/js/app.js?v={{ config('system.versioning') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="public/vendor/statement-analyzer/css/app.css?v={{ config('system.versioning') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <main class="py-3">
            <h3>Laravel Vue</h3>
            @yield('content')
        </main>
    </div>
</body>
</html>