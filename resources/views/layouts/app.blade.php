<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TechHaven')</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    @yield('windowSpecificStylesheets')
</head>
<body>

<header>
    <x-header />
</header>

<main>
    @yield('content')
</main>

<footer>
    @include('partials.footer')
</footer>

@yield('scripts')

</body>
</html>
