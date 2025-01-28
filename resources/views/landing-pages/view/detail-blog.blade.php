@extends('landing-pages.layout.main')


@section('content')
    <section id="blog" class="blog">
        <div class="container mt-5" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-12 entries">
                    <article class="entry entry-single">

                        <h2 class="entry-title d-flex justify-content-center">
                            <a>{{$blog->title}}</a>
                        </h2>
                        <div class="entry-img">
                            <img src="{{ asset($blog->image) }}" alt="" class="img-fluid">
                        </div>

                        <div class="entry-meta mt-4">
                            <ul>
                                <div class="d-flex justify-content-between">
                                    <li class="d-flex align-items-center"><i class="bi bi-person me-2"></i> <a
                                            href="#">{{ $blog->user->name }}</a></li>
                                    <li class="d-flex align-items-center"><i class="bi bi-clock me-2"></i> <a href="#"><time
                                                datetime="2021-01-01">{{ $blog->created_at }}</time></a></li>
                                    <li class="d-flex align-items-center"><i class="bi bi-tag-fill me-2"></i> <a
                                            href="#">{{ $blog->blogCategory->name }}</a></li>
                                </div>
                            </ul>
                        </div>
                    </article>
                    {{-- show content --}}
                    <div class="entry-content">
                        <p>
                            {!! $blog->content !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
