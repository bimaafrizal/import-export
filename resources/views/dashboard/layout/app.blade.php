<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('page-name')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    @if (file_exists(public_path('/images/logo/logo.png')))
        <link href="{{ asset('/images/logo/logo.png') }}" rel="icon">
        <link href="{{ asset('/images/logo/logo.png') }}" rel="apple-touch-icon">
    @else
        <link href="{{ asset('dashboard-assets/img/favicon.png') }}" rel="icon">
        <link href="{{ asset('dashboard-assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    @endif

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    @yield('before-styles')
    <link rel="stylesheet" href="{{ asset('dashboard-assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-assets/vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-assets/vendor/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-assets/vendor/quill/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-assets/vendor/quill/quill.bubble.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-assets/vendor/remixicon/remixicon.css') }}">\
    <link rel="stylesheet" href="{{ asset('dashboard-assets/vendor/simple-datatables/style.css') }}">

    <!-- Template Main CSS File -->
    <link rel="stylesheet" href="{{ asset('dashboard-assets/css/style.css') }}">
    @yield('after-styles')
</head>

<body>
    @include('dashboard.components.header')

    @include('dashboard.components.sidebar')


    <main id="main" class="main">

        <div class="pagetitle">
            @if (!empty($page_name) && !empty($breadcrumbs))
                <h1>{{ $page_name }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        @foreach ($breadcrumbs as $key => $item)
                            @if (count($breadcrumbs) == 1)
                                <li class="breadcrumb-item active">{{ $item['value'] }}</li>
                            @else
                                @if ($key == count($breadcrumbs) - 1)
                                    <li class="breadcrumb-item active">{{ $item['value'] }}</li>
                                @else
                                    <li class="breadcrumb-item"><a
                                            href="{{ route($item['url']) }}">{{ $item['value'] }}</a>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    </ol>
                </nav>
            @else
                <h1>Dashboard</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            @endif
        </div><!-- End Page Title -->

        @yield('content')

    </main><!-- End #main -->

    {{-- @include('dashboard.components.footer') --}}

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    @yield('before-scripts')
    <!-- Vendor JS Files -->
    <script src="{{ asset('dashboard-assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('dashboard-assets/js/main.js') }}"></script>

    @yield('after-scripts')

</body>

</html>
