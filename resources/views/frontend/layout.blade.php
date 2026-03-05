<!DOCTYPE html>
<html lang="en">
<head>
    @include('frontend.widget.header')
</head>
<body>
    @include('frontend.widget.topbar')
    @include('frontend.widget.navbar')
    @yield('main_contain')
    @include('frontend.widget.footer')
    @include('frontend.widget.js')
</body>
</html>
