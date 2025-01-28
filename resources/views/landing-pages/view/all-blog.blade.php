@extends('landing-pages.layout.main')


@section('content')
    <section id="blog" class="gallery section">

        <div class="container mt-5 section-title d-flex justify-content-center" data-aos="fade-up">
            <p>All Blog</p>
        </div>
        <div class="container mt-5 d-flex justify-content-center align-items-center flex-column">
            <section id="search" class="search-section w-100 d-flex justify-content-center">
                <div class="search-box">
                    <form action="" method="GET" class="d-flex search-form">
                        <input type="text" name="search" class="form-control search-input" placeholder="Search blogs..."
                            >
                        <button type="submit" class="btn btn-search ms-2">Search</button>
                    </form>
                </div>
            </section>
        </div>

        <div class="container">
            <div class="row gy-4">
                @foreach ($blogs as $blog)
                    <div class="card card-blog mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset($blog->image->path) }}" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $blog->title }}</h5>
                                    <p class="card-text">
                                    <ul>
                                        <li class="d-flex align-items-center"><i class="bi bi-person me-2"></i> <a
                                                href="#">{{ $blog->user->name }}</a></li>
                                        <li class="d-flex align-items-center"><i class="bi bi-clock me-2"></i> <a
                                                href="#"><time
                                                    datetime="2021-01-01">{{ $blog->created_at }}</time></a></li>
                                        <li class="d-flex align-items-center"><i class="bi bi-tag-fill me-2"></i> <a
                                                href="#">{{ $blog->blogCategory->name }}</a></li>
                                    </ul>
                                    </p>
                                    <div class="read-more-container">
                                        <a href="{{ route('blog-detail', $blog->slug) }}" class="btn btn-primary">Read
                                            More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-center align-items-cente read-all">
                    {{ $blogs->links() }}
                </div>
            </div>
        </div>

    </section>
@endsection
