<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Anton&family=Archivo+Black&family=Kanit:wght@400;500;600&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://kit.fontawesome.com/b90e9e4354.js" crossorigin="anonymous"></script>
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>
<body class="bg-gray-900">

    @yield('content')
</body>
</html>