@extends('landing-pages.layout.main')

@section('after-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.gallery-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 3000, // Delay antara transisi (dalam milidetik)
                    disableOnInteraction: false, // Tetap autoplay setelah user berinteraksi
                    pauseOnMouseEnter: true // Pause saat mouse hover
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                    },
                    768: {
                        slidesPerView: 3,
                    },
                    1024: {
                        slidesPerView: 4,
                    }
                }
            });
        });
    </script>
@endsection
@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

        @if (empty($landingPage['hero_image']))
            <img src="{{ asset('landing-page-asset/img/hero-bg.jpg') }}" alt="" data-aos="fade-in">
        @else
            <img src="{{ asset($landingPage['hero_image']) }}" alt="" data-aos="fade-in">
        @endif

        <div class="container">

            <div class="row justify-content-center text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="col-xl-6 col-lg-8">
                    <h2>{{ $landingPage['title'] ?? 'Powerful Digital Solutions With GP' }}<span>.</span></h2>
                    <p>{{ $landingPage['sub_title'] ?? 'We are team of talented digital marketers' }}</p>
                </div>
            </div>
        </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">
                <div class="col-lg-6 order-1 order-lg-2">
                    @if (!empty($aboutUs) && !empty($aboutUs['image']))
                        <img src="{{ asset($aboutUs['image']) }}" class="img-fluid" alt="">
                    @else
                        <img src="{{ asset('landing-page-asset/img/about.jpg') }}" class="img-fluid" alt="">
                    @endif
                </div>
                <div class="col-lg-6 order-2 order-lg-1 content">
                    @if (empty($aboutUs))
                        <h3>Voluptatem dignissimos provident</h3>
                        <p>
                            Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit
                            in
                            voluptate
                            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident
                        </p>
                    @else
                        <h3>{{ $aboutUs['title'] }}</h3>
                        <p>
                            {!! $aboutUs['content'] !!}
                        </p>
                    @endif
                </div>
            </div>

        </div>

    </section><!-- /About Section -->

    <!-- Services Section -->
    <section id="services" class="services section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Products</h2>
            <p>Check our Products</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">
                @foreach ($products as $key => $product)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="card product">
                            <div id="product{{ $key }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <?php for($i = 0; $i < count($product->productImages); $i++) {?>
                                    <button type="button"
                                        data-bs-target="#product{{ $key }}"data-bs-slide-to="{{ $i }}"
                                        class="{{ $i == 0 ? 'active' : '' }}" aria-label="Slide {{ $i + 1 }}"
                                        {{ $i == 0 ? 'aria-current="true"' : '' }}></button>
                                    <?php } ?>
                                </div>
                                <div class="carousel-inner">
                                    @foreach ($product->productImages as $imageKey => $imageValue)
                                        <div class="carousel-item {{ $imageKey == 0 ? 'active' : '' }}  relative">
                                            <img src="{{ asset($imageValue->image) }}" class="d-block w-100"
                                                alt="...">
                                            <a href="{{ asset($imageValue->image) }}"
                                                title="{{ !empty($imageValue->description) ? $imageValue->description : '' }}"
                                                data-gallery="product{{ $key }}" class="glightbox preview-link"><i
                                                    class="bi bi-zoom-in"></i></a>
                                        </div>
                                    @endforeach
                                </div>

                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#product{{ $key }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#product{{ $key }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->description }}</p>
                            </div>
                        </div>
                    </div><!-- End Service Item -->
                @endforeach
            </div>

        </div>

    </section><!-- /Services Section -->

    <!-- Portfolio Section -->
    <section id="gallery" class="gallery section">

        <div class="container section-title" data-aos="fade-up">
            <h2>Gallery</h2>
            <p>Check our Gallery</p>
        </div>

        <div class="container">
            <div class="swiper-container gallery-swiper">
                <div class="swiper-wrapper">

                    @foreach ($galleries as $gallery)
                        <div class="swiper-slide">
                            <div class="gallery-item">
                                <img src="{{ asset($gallery['path']) }}" alt="Gallery Image 1">
                                <div class="gallery-info">
                                    <p>{{ $gallery['description'] }}</p>
                                    <a href="{{ asset($gallery['path']) }}" title="{{ $gallery['description'] }}"
                                        data-gallery="gallery-gallery-app" class="glightbox preview-link-gallery">
                                        <i class="bi bi-zoom-in"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

    </section>

    <section id="blog" class="gallery section">

        <div class="container section-title" data-aos="fade-up">
            <h2>Blog</h2>
            <p>Check our Blog</p>
        </div>

        <div class="container">
            <div class="row gy-4">
                @foreach ($blogs as $blog)
                    <div class="card card-blog mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset($blog->image) }}" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $blog->title }}</h5>
                                    <p class="card-text">{{ $blog->blogCategory->name }} - {{ $blog->created_at }}</p>
                                    <div class="read-more-container">
                                        <a href="{{ route('blog-detail', $blog->slug) }}" class="btn btn-primary">Read
                                            More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if ($blogCount > 3)
                <div class="d-flex justify-content-center align-items-cente read-all">
                    <a href="{{ route('blog-detail', $blog->slug) }}" class="btn btn-primary">Show All</a>
                </div>
                @endif
            </div>
        </div>

    </section>


    <!-- Team Section -->
    <section id="team" class="team section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Team</h2>
            <p>our Team</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">

                @foreach ($teams as $team)
                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="{{ asset($team->image) }}" class="img-fluid" alt="">
                            </div>
                            <div class="member-info">
                                <h4>{{ $team->name }}</h4>
                                <span>{{ $team->job_title }}</span>
                            </div>
                        </div>
                    </div><!-- End Team Member -->
                @endforeach
            </div>

        </div>

    </section><!-- /Team Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Contact</h2>
            <p>Contact Us</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="mb-4" data-aos="fade-up" data-aos-delay="200">
                <iframe style="border:0; width: 100%; height: 270px;" src="{{ $requiredContacts['map']['link'] }}"
                    frameborder="0" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div><!-- End Google Maps -->

            <div class="row gy-4">

                <div class="col-lg-4">
                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                        <i class="bi bi-geo-alt flex-shrink-0"></i>
                        <div>
                            <h3>Address</h3>
                            <p>{{ $requiredContacts['alamat']['value'] }}</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                        <i class="bi bi-telephone flex-shrink-0"></i>
                        <div>
                            <h3>Call Us</h3>
                            <p>{{ $requiredContacts['telepon']['value'] }}</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                        <i class="bi bi-envelope flex-shrink-0"></i>
                        <div>
                            <h3>Email Us</h3>
                            <p>{{ $requiredContacts['email']['value'] }}</p>
                        </div>
                    </div><!-- End Info Item -->

                </div>

                <div class="col-lg-8">
                    <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up"
                        data-aos-delay="200">
                        <div class="row gy-4">

                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Your Name"
                                    required="">
                            </div>

                            <div class="col-md-6 ">
                                <input type="email" class="form-control" name="email" placeholder="Your Email"
                                    required="">
                            </div>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="subject" placeholder="Subject"
                                    required="">
                            </div>

                            <div class="col-md-12">
                                <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>

                                <button type="submit">Send Message</button>
                            </div>

                        </div>
                    </form>
                </div><!-- End Contact Form -->

            </div>

        </div>

    </section><!-- /Contact Section -->
@endsection
