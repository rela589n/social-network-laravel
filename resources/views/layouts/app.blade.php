<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <title>Социальная сеть | {{ config('app.name') }}</title>
  </head>
  <body>
    @include('layouts.partials.navigation')

    <div class="container content">
        @include('layouts.partials.alerts')
        @yield('content')
    </div>

    <footer class="mt-3">
        <!-- Copyright -->
        <div class="text-center py-3">©{{ date('Y') }}
          <a href="{{ route('home') }}"> Social</a>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>