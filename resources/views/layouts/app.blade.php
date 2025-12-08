<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #2F3E3C;
            --sidebar-text: #E7E9E3;
            --main-bg: #E8F0F1;
            --card-bg: #BDDBD1;
            --card-hover: #FBF9F1;
            --btn-bg: #C7E7EC;
        }
    </style>
</head>
<body class="flex h-screen bg-[var(--main-bg)] font-sans">

    <div class="flex flex-shrink-0">
    @yield('sidebar')
</div>

<div class="flex-1 overflow-auto">
    <main class="p-6">
        @yield('content')
    </main>
</div>

@stack('scripts')

</body>
</html>
