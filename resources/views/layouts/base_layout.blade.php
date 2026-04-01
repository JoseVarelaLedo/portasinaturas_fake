<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title')
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header class="header_superior py-3">
        <div class="container-xl">
            <div class="row align-items-center g-3">
                <div class="col-12 col-md-1 text-center text-md-start">
                    <img class="header_logo_imagen" src="{{ asset('img/icons/xunta_icon.jpg') }}" alt="Icono Xunta" />
                </div>
                <div class="col-12 col-md-2 text-center">
                    <img class="header_logo_imagen" src="{{ asset('img/icons/inega_icon.png') }}" alt="Icono Inega" />
                </div>
                <div class="col-12 col-md-9">
                    @include('layouts._partials.menu_header')
                </div>
            </div>
        </div>
    </header>
    @yield('index_body_content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
