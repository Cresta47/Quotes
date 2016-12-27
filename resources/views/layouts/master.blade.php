<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ URL::to('src/css/main.css') }}">
    @yield('styles')
</head>
<body>


<div class="main">
    @yield('content')
</div>


@yield('scripts')
</body>
</html>