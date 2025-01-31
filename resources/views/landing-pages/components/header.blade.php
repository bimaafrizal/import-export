<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="/" class="logo d-flex align-items-center me-auto me-lg-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        @if (!empty($landingPage['logo']))
        <img src="{{asset($landingPage['logo'])}}" alt="">
        @endif
        {{-- <h1 class="sitename">GP</h1> --}}
        {{-- <span>.</span> --}}
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{route('index')}}#hero" class="active">Home<br></a></li>
          <li><a href="{{route('index')}}#about">About</a></li>
          <li><a href="{{route('index')}}#services">Product</a></li>
          <li><a href="{{route('index')}}#gallery">Gallery</a></li>
          <li><a href="{{route('index')}}#blog">Blog</a></li>
          <li><a href="{{route('index')}}#team">Team</a></li>
          <li><a href="{{route('index')}}#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="/#about">Get Started</a>

    </div>
  </header>
