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

    <div class="text-center space-y-8">
        <!-- ชื่อ PATRA -->
        <h1 class="text-6xl font-extrabold text-blue-600 tracking-wider">PATRA</h1>

        <!-- Product Master -->
        <p class="text-xl text-gray-700">Product Master</p>

        <!-- Progress Bar -->
        <div class="w-64 h-4 bg-gray-200 rounded-full mx-auto mt-8">
            <div id="progress-bar" class="h-4 bg-blue-600 rounded-full" style="width: 0%; transition: width 0.03s linear;"></div>
        </div>
    </div>

</body>
</html>
