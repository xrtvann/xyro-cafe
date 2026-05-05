<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-secondary antialiased bg-background selection:bg-primary/30 selection:text-primary-fixed">
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 overflow-hidden">
            <!-- Ambient Glow -->
            <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full overflow-hidden -z-10 pointer-events-none">
                <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-primary/20 blur-[120px]"></div>
                <div class="absolute top-[60%] -right-[10%] w-[40%] h-[40%] rounded-full bg-surface-bright/40 blur-[100px]"></div>
            </div>

            <div class="z-10 mb-2 mt-8 sm:mt-0">
                <a href="/" class="flex flex-col items-center gap-2">
                    <!-- application-logo component defaults to black, let's just make it visually distinct or let the component handle it if it inherits text-color -->
                  
                </a>
            </div>

            <div class="z-10 w-full sm:max-w-md mt-6 px-8 py-10 bg-white/[0.06] backdrop-blur-[12px] border border-white/[0.12] shadow-[0px_20px_40px_rgba(0,0,0,0.3)] overflow-hidden sm:rounded-[24px]">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
