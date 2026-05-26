<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900 antialiased font-sans text-zinc-900 dark:text-zinc-100">
    <main>
        {{ $slot }}
    </main>
    @fluxScripts
</body>

</html>