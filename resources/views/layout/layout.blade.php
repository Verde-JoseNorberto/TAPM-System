<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TAPM</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-gray-700 text-white">
    <header class="top">
        <div id="navbar">
            <div>
                <input type="search" name="search" placeholder="Search Something">
            </div>
            <div class="right">
                <a href="{{ route('login') }}">
                <button class="button">
                    <strong>LOGIN</strong>
                </button>
                </a>
                <a href="{{ route('signup') }}">
                <button class="button">
                    <strong>SIGN UP</strong>
                </button>
                </a>
            </div>
        </div>
    </header>
    <main>
        @yield('page-content')
    </main>
    <footer class="bottom">
        Footer
    </footer>
</body>
</html>