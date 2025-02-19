<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Travelog') }}</title>

    {{-- Manifest Link --}}
    <link rel="manifest" href="/manifest.json">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="msapplication-starturl" content="/">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#e5e5e5">

    {{-- Google Place CDN --}}
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcNonuONLLYOujF_Di6-kYLDsCQB7A2Tg&libraries=places"></script>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet">

    {{-- Google Icons --}}
    <link rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Registrazione del service worker e gestione del prompt di installazione -->
    <script>
      let deferredInstallPrompt;

      if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
          navigator.serviceWorker.register('/service-worker.js')
            .then(function(registration) {
              console.log('ServiceWorker registration:', registration.scope);
            })
            .catch(function(error) {
              console.log('ServiceWorker registration failed:', error);
            });
        });
      }

      window.addEventListener('beforeinstallprompt', function(evt) {
        evt.preventDefault();
        deferredInstallPrompt = evt;
        deferredInstallPrompt.prompt();
      });
    </script>

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])

    <!-- Include global styles -->
    @vite('resources/scss/app.scss')

    <!-- Include page-specific styles -->
    @yield('styles')

    <!-- Include page-specific scripts -->
    @yield('scripts')
  </head>

  <body>
    <div id="app">
      <main class="">
        @yield('content')
      </main>
    </div>
  </body>

</html>
