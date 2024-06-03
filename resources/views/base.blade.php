<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2" defer></script>
    <title>@yield('title') | {{config('app.name')}}</title>
</head>
<body class="bg-gray-50">
   <div class="container my-6 ">
        @yield('content')
   </div>
</body>
</html>
