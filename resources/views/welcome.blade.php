<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patra - Product Master</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const progressBar = document.querySelector('#progress-bar');
            let width = 0;
            const duration = 300; // 0.3 วินาที
            const intervalTime = 30; // update ทุก 30ms
            const increment = intervalTime / duration * 100;

            const interval = setInterval(() => {
                width += increment;
                if (width >= 100) {
                    width = 100;
                    clearInterval(interval);
                    // Redirect ไปหน้า login
                    window.location.href = "{{ route('login') }}";
                }
                progressBar.style.width = width + '%';
            }, intervalTime);
        });
    </script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen font-sans">

    <div class="text-center">
        <!-- Logo แทนตัวอักษร -->
        <div class="mb-6">
            <img src="{{ asset('images/PatraLogo.png') }}" 
                alt="PATRA - We make good life possible" 
                class="mx-auto h-48 w-auto">
        </div>

        <!-- Progress Bar -->
        <div class="w-128 h-4 bg-gray-100 rounded-full mx-auto mt-8">
            <div id="progress-bar" class="h-4 bg-gray-500 rounded-full" style="width: 0%; transition: width 0.03s linear;"></div>
        </div>
    </div>

</body>
</html>
