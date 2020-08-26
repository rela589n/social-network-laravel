<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <title>{{ config('app.name') }}</title>
  </head>
  <body>
    @include('layouts.partials.navigation')

    <div class="container content">
        @include('layouts.partials.alerts')
        @yield('content')
    </div>

    <hr @if (Route::currentRouteNamed('home')) class="mt-0" @endif>

    <footer class="my-3">
        <!-- Copyright -->
        <div class="text-center py-3">©{{ date('Y') }}
          <a href="{{ route('home') }}"> {{ config('app.name') }}</a>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    </script>

    @stack('scripts')
  </body>
</html>