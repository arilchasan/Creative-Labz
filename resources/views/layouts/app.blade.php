<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/assets/logo.png" />
    <script>
        var title = "Dashboard Creativ Labz ";
        var pos = 0;

        function animateTitle() {
            pos = (pos + 1) % title.length;
            document.title = title.substring(pos) + title.substring(0, pos);
            setTimeout(animateTitle, 150);
        }
        animateTitle();
    </script>
    @stack('tables')
</head>
<style>
    .grid-container {
        font-family: 'Popins', sans-serif;
    }

    .content-container {
        margin-left: 34vh;
        margin-top: 5vh;
        font-family: 'Inter', sans-serif;
    }
</style>

<body>
    <div class="grid-container">
        @include('partials.sidebar')
    </div>
    <div class="content-container">
        @yield('container')
    </div>
    </div>
</body>

</html>
