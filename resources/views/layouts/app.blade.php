<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="upload-image" content="{{ route('upload-image') }}"/>
    <meta name="stripe-key" content="{{ config('services.stripe.key') }}"/>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css', 'assets') }}">

    <!-- Scripts -->
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ mix('js/app.js', 'assets') }}" defer></script>
    
    @livewireStyles
</head>
<body class="c-app">
<x-sidebar/>
<div class="c-wrapper c-fixed-components">
    <x-header/>
    <div class="c-body">
        <main class="c-main">
            <div class="container-fluid">
                <div class="fade-in">
                    <x-alert/>
                    {{ $slot }}
                </div>
            </div>
        </main>
        <footer class="c-footer">
            <div><a href="https://coreui.io">CoreUI</a> © 2020 creativeLabs.</div>
            <div class="ml-auto">Powered by&nbsp;<a href="https://coreui.io/">CoreUI</a></div>
        </footer>
    </div>
</div>
@livewireScripts
</body>
</html>
