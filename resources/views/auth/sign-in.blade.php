<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    @if (file_exists(public_path('/images/logo/logo.png')))
        <link href="{{ asset('/images/logo/logo.png') }}" rel="icon">
        <link href="{{ asset('/images/logo/logo.png') }}" rel="apple-touch-icon">
    @endif
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link id="pagestyle" href="{{ asset('auth-assets/css/argon-dashboard.css') }}" rel="stylesheet" />
    <style>
        .alert-danger {
            --bs-alert-bg: #dc3545;
            --bs-alert-color: #fff;
        }

        .alert-danger .btn-close {
            --bs-btn-close-color: #000 !important;
            opacity: 1 !important;
            z-index: 999 !important;
        }

        .background-image {
            background: url('{{ asset('auth-assets/img/bg.jpg') }}') no-repeat center center;
            background-size: cover;
            border-radius: 1rem;
            height: 100%;
            width: 100%;
        }
    </style>
</head>

<body>
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Sign In</h4>
                                    <p class="mb-0">Enter your email and password to sign in</p>
                                </div>
                                <div class="card-body">
                                    @if (Session::has('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <div>{{ session('error') }}</div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <form role="form" method="POST" action="{{ route('post-login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <input type="email" class="form-control form-control-lg"
                                                placeholder="Email" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <input type="password" class="form-control form-control-lg"
                                                placeholder="Password" name="password" required>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="background-image m-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
</body>

</html>
