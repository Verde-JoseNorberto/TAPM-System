<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TAPM</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-gray-700 text-white">
    <header>
        <div id="navbar">
            <div class="">
                <input type="search" name="search" placeholder="Search Something">
            </div>
            <div class="right">
            <button class="button">
                <strong>LOGIN</strong>
            </button>
            <button class="button">
                <strong>SIGN UP</strong>
            </button>
            </div>
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