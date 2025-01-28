<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'PMADI')</title>

    {{-- Favicons --}}
    <link rel="icon" href="{{asset('img/favicon.ico')}}">
    <link rel="apple-touch-icon" href="{{asset('img/apple-touch-icon.png')}}">

    {{-- Fuentes --}}
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">


    {{-- Archivos css vendor --}}
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/aos/aos.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/swiper/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/glightbox/css/glightbox.min.css')}}">

    {{-- Archivos css propios --}}
    <link rel="stylesheet" href="{{ asset('css/main.css')}}">

    @livewireStyles

</head>

<body class="index-page">
    {{-- Encabezado --}}
    @include('partials.header')

    {{-- Contenido --}}
    <main class="main">
        @yield('content')
    </main>
    <livewire:modales.asignar-tutor-modal />


    {{-- Pie de página --}}
    @include('partials.footer')

    {{-- desplazamiento hacia arriba --}}
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    {{-- PreCarga --}}
    <div id="preloader">
        <img src="{{ asset('img/logo_elalto.png')}}" alt="PMADI Logo" class="preloader-logo">
    </div>

    {{-- Archivos js vendor --}}
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('vendor/php-email-form/validate.js')}}"></script>
    <script src="{{ asset('vendor/aos/aos.js')}}"></script>
    <script src="{{ asset('vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{ asset('vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{ asset('vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{ asset('vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>

    {{-- Archivos js propios --}}
    <script src="{{ asset('js/main.js')}}"></script>
    {{--
    <script src="{{ asset('js/verification.js') }}"></script> --}}

    @livewireScripts
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x" crossorigin="anonymous"></script>
    

</html>