<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('appconstants.app.name')}}</title>
        <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/sweetalert2_min.css') }}">
        <script src="{{ asset('/js/sweetalert2.min.js') }}"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
        <link rel="icon" type="image/x-icon" href="{{ asset('/images/favicon.ico') }}">

        <script src="{{ asset('/js/js.js') }}"></script>

        @livewireStyles
    </head>
    <body>

        @include('components.layouts.navbar')
        {{ $slot }}
        @include('components.layouts.footer')

        @livewireScripts
    </body>
</html>
