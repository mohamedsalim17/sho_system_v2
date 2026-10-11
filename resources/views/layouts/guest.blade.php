<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sho_system_v2 - نظام المبيعات المتكامل</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
    <style> body{font-family:'Cairo',sans-serif} </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">sho_system_v2 🌿</h1>
            <p class="text-gray-500 text-sm mt-1">نظام المبيعات المتكامل</p>
        </div>
        <div class="bg-white p-8 rounded-xl shadow-lg">
            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </div>
</body>
</html>
