<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Welcome!!!</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    @yield('before-style')
    <!-- Favicons -->
    @if (!empty($landingPage) && !empty($landingPage['logo']))
        <link href="{{ asset($landingPage['logo']) }}" rel="icon">
        <link href="{{ asset($landingPage['logo']) }}" rel="apple-touch-icon">
    @else
        <link href="{{ asset('landing-page-asset/img/favicon.png') }}" rel="icon">
        <link href="{{ asset('landing-page-asset/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    @endif

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('landing-page-asset/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing-page-asset/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('landing-page-asset/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('landing-page-asset/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing-page-asset/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{ asset('landing-page-asset/css/main.css') }}" rel="stylesheet">
    @yield('after-style')
</head>

<body class="index-page">

    @include('landing-pages.components.header')

    <main class="main">

        @yield('content')

    </main>

    @include('landing-pages.components.footer')

    @yield('before-script')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('landing-page-asset/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('landing-page-asset/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('landing-page-asset/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('landing-page-asset/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('landing-page-asset/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('landing-page-asset/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('landing-page-asset/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('landing-page-asset/vendor/purecounter/purecounter_vanilla.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('landing-page-asset/js/main.js') }}"></script>

    @yield('after-script')

</body>

</html>
