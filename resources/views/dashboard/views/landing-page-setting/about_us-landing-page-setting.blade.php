@extends('dashboard.layout.app')
@section('page-name')
    Setting Landing Page
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Setting Landing Page About Us</h5>
                        <div class="row">
                            <div class="col-12">
                                <div class="responsive-iframe">
                                    <iframe src="{{ env('APP_URL') }}#about" frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        {{-- show errror --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                @foreach ($errors->all() as $error)
                                    <ul class="mb-0">
                                        <li>{{ $error }}</li>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </ul>
                                @endforeach
                            </div>
                        @endif
                        <form action="{{ route('landing-page-settings.update-about') }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <div class="row mb-3 mt-3">
                                <label for="inputText" class="col-sm-12 col-form-label">Title</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="title" required
                                        value="{{ old('title', $aboutUs ? $aboutUs->title : '') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-12 col-form-label">Body</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" style="height: 100px" name="content">{{ old('content', $aboutUs ? $aboutUs->content : '') }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="image">Gambar: </label>
                                <div class="col-sm-12">
                                    <input type="file" name="image" id="image" class="form-control">
                                    <button type="button" class="btn btn-secondary mt-3" id="cancel-image"
                                        aria-label="Close" hidden>Cancel Image</button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <img id="image-preview" src="#" alt="Preview Gambar" hidden>
                                <input type="hidden" name="crop_x" id="crop_x">
                                <input type="hidden" name="crop_y" id="crop_y">
                                <input type="hidden" name="crop_width" id="crop_width">
                                <input type="hidden" name="crop_height" id="crop_height">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('after-styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
@endsection

@section('before-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <script>
        $(document).ready(function() {
            var $image = $('#image-preview');
            var $cancelImage = $('#cancel-image');
            var cropper;

            $('#image').change(function(event) {
                //remove hidden image preview
                $image.removeAttr('hidden');
                $cancelImage.removeAttr('hidden');
                var files = event.target.files;
                var done = function(url) {
                    if (cropper) {
                        cropper.destroy(); // Hancurkan instance CropperJS lama
                        $image.attr('src', ''); // Hapus src gambar lama
                        $image.hide(); // Sembunyikan preview gambar
                    }


                    $image.attr('src', url);
                    $image.show();
                    cropper = new Cropper($image[0], {
                        aspectRatio: 4 / 3,
                        viewMode: 1,
                        crop(event) {
                            $('#crop_x').val(Math.round(event.detail.x));
                            $('#crop_y').val(Math.round(event.detail.y));
                            $('#crop_width').val(Math.round(event.detail.width));
                            $('#crop_height').val(Math.round(event.detail.height));
                        }
                    });
                };

                if (files && files.length > 0) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            $('#cancel-image').click(function() {
                // Reset input file
                $('#image').val('');

                // Sembunyikan dan reset image preview (jika ada)
                $image.attr('src', '');
                $image.hide();
                $cancelImage.hide();

                // Hancurkan CropperJS jika ada
                if (cropper) {
                    cropper.destroy();
                }

                // Reset nilai input hidden crop
                $('#crop_x').val('');
                $('#crop_y').val('');
                $('#crop_width').val('');
                $('#crop_height').val('');
            });
        });
    </script>
@endsection
