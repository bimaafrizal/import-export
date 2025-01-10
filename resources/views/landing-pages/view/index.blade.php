@extends('landing-pages.layout.main')

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

    <!-- Clients Section -->
    <section id="clients" class="clients section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="swiper init-swiper">
                <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "spaceBetween": 40
                },
                "480": {
                  "slidesPerView": 3,
                  "spaceBetween": 60
                },
                "640": {
                  "slidesPerView": 4,
                  "spaceBetween": 80
                },
                "992": {
                  "slidesPerView": 6,
                  "spaceBetween": 120
                }
              }
            }
          </script>
                <div class="swiper-wrapper align-items-center">
                    <div class="swiper-slide"><img src="{{ asset('landing-page-asset/img/clients/client-1.png') }}"
                            class="img-fluid" alt=""></div>
                    <div class="swiper-slide"><img src="{{ asset('landing-page-asset/img/clients/client-2.png') }}"
                            class="img-fluid" alt=""></div>
                    <div class="swiper-slide"><img src="{{ asset('landing-page-asset/img/clients/client-3.png') }}"
                            class="img-fluid" alt=""></div>
                    <div class="swiper-slide"><img src="{{ asset('landing-page-asset/img/clients/client-4.png') }}"
                            class="img-fluid" alt=""></div>
                    <div class="swiper-slide"><img src="{{ asset('landing-page-asset/img/clients/client-5.png') }}"
                            class="img-fluid" alt=""></div>
                    <div class="swiper-slide"><img src="{{ asset('landing-page-asset/img/clients/client-6.png') }}"
                            class="img-fluid" alt=""></div>
                    <div class="swiper-slide"><img src="{{ asset('landing-page-asset/img/clients/client-7.png') }}"
                            class="img-fluid" alt=""></div>
                    <div class="swiper-slide"><img src="{{ asset('landing-page-asset/img/clients/client-8.png') }}"
                            class="img-fluid" alt=""></div>
                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>

    </section><!-- /Clients Section -->

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
                                    @foreach ($product->productImages as $imageKey => $image)
                                    <div class="carousel-item {{ $imageKey == 0 ? 'active' : '' }}  relative">
                                        <img src="{{ asset($image->image) }}"
                                            class="d-block w-100" alt="...">
                                        <a href="{{ asset($image->image) }}"
                                            title="{{ !empty($image->description) ? $image->description:  "" }}" data-gallery="product{{ $key }}"
                                            class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
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
                                <h5 class="card-title">{{$product->name}}</h5>
                                <p class="card-text">{{$product->description}}</p>
                            </div>
                        </div>
                    </div><!-- End Service Item -->
                @endforeach
            </div>

        </div>

    </section><!-- /Services Section -->

    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section dark-background">

        <img src="{{ asset('landing-page-asset/img/cta-bg.jpg') }}" alt="">

        <div class="container">
            <div class="row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-xl-10">
                    <div class="text-center">
                        <h3>Call To Action</h3>
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                            pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                            mollit anim id est laborum.</p>
                        <a class="cta-btn" href="#">Call To Action</a>
                    </div>
                </div>
            </div>
        </div>

    </section><!-- /Call To Action Section -->

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Portfolio</h2>
            <p>Check our Portfolio</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

                <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                    <li data-filter="*" class="filter-active">All</li>
                    <li data-filter=".filter-app">App</li>
                    <li data-filter=".filter-product">Card</li>
                    <li data-filter=".filter-branding">Web</li>
                </ul><!-- End Portfolio Filters -->

                <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                        <img src="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-1.jpg') }}"
                            class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>App 1</h4>
                            <p>Lorem ipsum, dolor sit</p>
                            <a href="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-1.jpg') }}"
                                title="App 1" data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i
                                    class="bi bi-zoom-in"></i></a>
                            <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                        <img src="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-2.jpg') }}"
                            class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Product 1</h4>
                            <p>Lorem ipsum, dolor sit</p>
                            <a href="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-2.jpg') }}"
                                title="Product 1" data-gallery="portfolio-gallery-product"
                                class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                            <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                        <img src="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-3.jpg') }}"
                            class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Branding 1</h4>
                            <p>Lorem ipsum, dolor sit</p>
                            <a href="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-3.jpg') }}"
                                title="Branding 1" data-gallery="portfolio-gallery-branding"
                                class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                            <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                        <img src="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-4.jpg') }}"
                            class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>App 2</h4>
                            <p>Lorem ipsum, dolor sit</p>
                            <a href="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-4.jpg') }}"
                                title="App 2" data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i
                                    class="bi bi-zoom-in"></i></a>
                            <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                        <img src="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-5.jpg') }}"
                            class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Product 2</h4>
                            <p>Lorem ipsum, dolor sit</p>
                            <a href="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-5.jpg') }}"
                                title="Product 2" data-gallery="portfolio-gallery-product"
                                class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                            <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                        <img src="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-6.jpg') }}"
                            class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Branding 2</h4>
                            <p>Lorem ipsum, dolor sit</p>
                            <a href="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-6.jpg') }}"
                                title="Branding 2" data-gallery="portfolio-gallery-branding"
                                class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                            <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
                        <img src="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-7.jpg') }}"
                            class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>App 3</h4>
                            <p>Lorem ipsum, dolor sit</p>
                            <a href="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-7.jpg') }}"
                                title="App 3" data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i
                                    class="bi bi-zoom-in"></i></a>
                            <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-product">
                        <img src="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-8.jpg') }}"
                            class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Product 3</h4>
                            <p>Lorem ipsum, dolor sit</p>
                            <a href="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-8.jpg') }}"
                                title="Product 3" data-gallery="portfolio-gallery-product"
                                class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                            <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-branding">
                        <img src="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-9.jpg') }}"
                            class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Branding 3</h4>
                            <p>Lorem ipsum, dolor sit</p>
                            <a href="{{ asset('landing-page-asset/img/masonry-portfolio/masonry-portfolio-9.jpg') }}"
                                title="Branding 2" data-gallery="portfolio-gallery-branding"
                                class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                            <a href="portfolio-details.html" title="More Details" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div><!-- End Portfolio Item -->

                </div><!-- End Portfolio Container -->

            </div>

        </div>

    </section><!-- /Portfolio Section -->


    <!-- Team Section -->
    <section id="team" class="team section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Team</h2>
            <p>our Team</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="{{ asset('landing-page-asset/img/team/team-1.jpg') }}" class="img-fluid"
                                alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>Walter White</h4>
                            <span>Chief Executive Officer</span>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="{{ asset('landing-page-asset/img/team/team-2.jpg') }}" class="img-fluid"
                                alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>Sarah Jhonson</h4>
                            <span>Product Manager</span>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="{{ asset('landing-page-asset/img/team/team-3.jpg') }}" class="img-fluid"
                                alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>William Anderson</h4>
                            <span>CTO</span>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="{{ asset('landing-page-asset/img/team/team-4.jpg') }}" class="img-fluid"
                                alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>Amanda Jepson</h4>
                            <span>Accountant</span>
                        </div>
                    </div>
                </div><!-- End Team Member -->

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
                <iframe style="border:0; width: 100%; height: 270px;"
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus"
                    frameborder="0" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div><!-- End Google Maps -->

            <div class="row gy-4">

                <div class="col-lg-4">
                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                        <i class="bi bi-geo-alt flex-shrink-0"></i>
                        <div>
                            <h3>Address</h3>
                            <p>A108 Adam Street, New York, NY 535022</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                        <i class="bi bi-telephone flex-shrink-0"></i>
                        <div>
                            <h3>Call Us</h3>
                            <p>+1 5589 55488 55</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                        <i class="bi bi-envelope flex-shrink-0"></i>
                        <div>
                            <h3>Email Us</h3>
                            <p>info@example.com</p>
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
