<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Artsell</title>

    <!-- Fonts -->

</head>

<body>
    <x-frontendComponent.partials.navbar />
    {{ $slot }}




    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu-content');
            menu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
