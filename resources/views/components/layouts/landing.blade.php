<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MuscleXpert - Premium Fitness</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

    <div class="parallax-bg"></div>

    <div x-data="{ isChatOpen: false }">

        <x-navbar-landing />

        <main>
            {{ $slot }}
        </main>

        <x-footer-landing />

        <x-chat-bot />

    </div> </body>
</html>
