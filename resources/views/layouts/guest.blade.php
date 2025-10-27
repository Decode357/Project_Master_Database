
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Patra - Product Master</title>

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;700;900&family=Public+Sans:wght@400;500;700;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    
    <style>
        /* Fade-in animation */
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 1s ease forwards;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="overflow-hidden font-sans text-gray-900 antialiased relative min-h-screen">

    <!-- Static Background -->
    <div class="fixed inset-0 w-full h-full z-0 overflow-hidden">
        <img src="{{ asset('images/Background.gif') }}" 
            alt="Background" 
            class="w-full h-full object-cover" loading="lazy">
        <div class="absolute inset-0 bg-black/40"></div>
    </div>


    <!-- Content -->
    <div class="relative z-10 min-h-screen flex items-center justify-center p-6 fade-in">
        <div class="w-full sm:max-w-md px-6 py-8 bg-gray-100 shadow-2xl rounded-lg text-center">
            <!-- Logo แทนตัวอักษร -->
            <div class="mb-6">
                <img src="{{ asset('images/PatraLogo.png') }}" 
                    alt="PATRA - We make good life possible" 
                    class="mx-auto h-16 w-auto">
            </div>
            <div>
                {{ $slot }}
            </div>
        </div>
    </div>

</body>
</html>
