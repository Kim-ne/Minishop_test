<!DOCTYPE html>
<html lang="en">
<head>
    @include('Backend.widget.head')
</head>
<body class="dark-only">
    @include('backend.widget.loader')
    @include('backend.widget.backontop')

    @yield('admin_contain')
    @yield('admin_social')

    @include('Backend.widget.footer')
    @include('Backend.widget.js')
</body>
</html>
