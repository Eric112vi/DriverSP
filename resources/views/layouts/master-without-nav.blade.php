<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <base href="{{ url('/') }}/">
        <title> @yield('title') </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
        <style>
        .page-auth-bg {
            /* overlay plus image, keeps text readable */
            background: linear-gradient(rgba(0,0,0,0.35), rgba(0,0,0,0.35)),
                        url('{{ asset('build/images/6080984.jpg') }}') center/cover no-repeat fixed;
            background-size: cover;
            min-height: 100vh;
        }
        </style>
        @include('layouts.head-css')
  </head>

    @yield('body')
    
    @yield('content')

    @include('layouts.vendor-scripts')
    </body>
</html>