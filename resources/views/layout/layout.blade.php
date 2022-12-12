<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TAPM</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-700 text-white">
    <header>
        <div class="navbar ">
            <div class="">
                <input type="search" name="search" placeholder="Search Something">
            </div>
            <div class="">
            <button class="btn">
                <strong>LOGIN</strong>
            </button>
            <button class="btn">
                <strong>SIGN UP</strong>
            </button>
        </div>
    </header>
    <main>
        @yield('page-content')
    </main>
    <footer>
        Footer
    </footer>
</body>
</html>