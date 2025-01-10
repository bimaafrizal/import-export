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
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#disablebackdrop">
                                        Add Product
                                    </button>
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


                        @if (empty($products))
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-center">
                                        <p>Belum Ada Produk</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                @foreach ($products as $key => $product)
                                    <div class="col-lg-3 col-md-4 col-sm-12">
                                        <div class="card">
                                            <div id="product{{ $key }}" class="carousel slide"
                                                data-bs-ride="carousel">
                                                <div class="carousel-indicators">
                                                    <?php for($i = 0; $i < $product->count_image; $i++) {?>
                                                    <button type="button" data-bs-target="#product{{ $key }}"
                                                        data-bs-slide-to="{{ $i }}"
                                                        class="{{ $i == 0 ? 'active' : '' }}"
                                                        aria-label="Slide {{ $i + 1 }}"
                                                        {{ $i == 0 ? 'aria-current="true"' : '' }}></button>
                                                    <?php } ?>
                                                </div>
                                                <div class="carousel-inner">
                                                    @foreach ($product->images as $imageKey => $image)
                                                        <div
                                                            class="carousel-item {{ $imageKey == 0 ? 'active' : '' }} relative">
                                                            <img src="{{ asset($image->path) }}" class="d-block w-100"
                                                                alt="...">
                                                            <a href="{{ asset($image->path) }}"
                                                                title="{{ $image->description ?? '-' }}"
                                                                data-gallery="portfolio-gallery-app"
                                                                class="glightbox preview-link"><i
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
                                                <div class="row">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('landing-page-settings.product.edit', encrypt($product->id)) }}"
                                                            class="btn btn-primary">Edit</a>
                                                        <button type="button" class="btn btn-danger ms-2"
                                                            onclick="confirmDelete('{{ encrypt($product->id) }}')">Delete</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    {{ $products->links() }}
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
    </section>
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus produk ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="disablebackdrop" tabindex="-1" data-bs-backdrop="false" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('landing-page-settings.product.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3 mt-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Nama Product*</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="name" required
                                    value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Deskripsi*</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" style="height: 100px" name="description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="image">Gambar 1*: </label>
                            <div class="col-sm-12">
                                <input type="file" name="image" id="image" class="form-control " required>
                                <button type="button" class="btn btn-secondary mt-3" id="cancel-image"
                                    aria-label="Close" hidden>Cancel Image</button>
                            </div>
                        </div>
                        <div class="row mb-3" id="deskripsi1" hidden>
                            <label for="inputText" class="col-sm-12 col-form-label">Deskripsi Gambar 1</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" style="height: 100px" name="description_image1"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <img id="image-preview" src="#" alt="Preview Gambar" hidden>
                            <input type="hidden" name="crop_x" id="crop_x">
                            <input type="hidden" name="crop_y" id="crop_y">
                            <input type="hidden" name="crop_width" id="crop_width">
                            <input type="hidden" name="crop_height" id="crop_height">
                        </div>
                        <div class="row mb-3">
                            <label for="image">Gambar 2: </label>
                            <div class="col-sm-12">
                                <input type="file" name="image2" id="image2" class="form-control">
                                <button type="button" class="btn btn-secondary mt-3" id="cancel-image2"
                                    aria-label="Close" hidden>Cancel Image</button>
                            </div>
                        </div>
                        <div class="row mb-3" id="deskripsi2" hidden>
                            <label for="inputText" class="col-sm-12 col-form-label">Deskripsi Gambar 2</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" style="height: 100px" name="description_image2"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <img id="image-preview2" src="#" alt="Preview Gambar" hidden>
                            <input type="hidden" name="crop_x2" id="crop_x2">
                            <input type="hidden" name="crop_y2" id="crop_y2">
                            <input type="hidden" name="crop_width2" id="crop_width2">
                            <input type="hidden" name="crop_height2" id="crop_height2">
                        </div>
                        <div class="row mb-3">
                            <label for="image">Gambar 3: </label>
                            <div class="col-sm-12">
                                <input type="file" name="image3" id="image3" class="form-control">
                                <button type="button" class="btn btn-secondary mt-3" id="cancel-image3"
                                    aria-label="Close" hidden>Cancel Image</button>
                            </div>
                        </div>
                        <div class="row mb-3" id="deskripsi3" hidden>
                            <label for="inputText" class="col-sm-12 col-form-label">Deskripsi Gambar 3</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" style="height: 100px" name="description_image3"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <img id="image-preview3" src="#" alt="Preview Gambar" hidden>
                            <input type="hidden" name="crop_x3" id="crop_x3">
                            <input type="hidden" name="crop_y3" id="crop_y3">
                            <input type="hidden" name="crop_width3" id="crop_width3">
                            <input type="hidden" name="crop_height3" id="crop_height3">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('after-styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <link href="{{ asset('landing-page-asset/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <style>
        /* carausel */
        .carousel-item.relative {
            position: relative;
        }

        .preview-link {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            opacity: 0;
            /* Sembunyikan tombol secara default */
            transition: opacity 0.3s ease;
            /* Efek transisi */
        }

        .carousel-item:hover .preview-link {
            opacity: 1;
            /* Tampilkan tombol saat hover */
        }
    </style>
@endsection

@section('after-scripts')
    <script src="{{ asset('landing-page-asset/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script>
        const lightbox = GLightbox({
            selector: '.glightbox'
        });
    </script>
@endsection

@section('before-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <script>
        $(document).ready(function() {
            handleImageUpload('#image', '#image-preview', '#cancel-image', '#crop_x', '#crop_y', '#crop_width',
                '#crop_height', '#deskripsi1');
            handleImageUpload('#image2', '#image-preview2', '#cancel-image2', '#crop_x2', '#crop_y2',
                '#crop_width2', '#crop_height2', '#deskripsi2');
            handleImageUpload('#image3', '#image-preview3', '#cancel-image3', '#crop_x3', '#crop_y3',
                '#crop_width3', '#crop_height3', '#deskripsi3');
        });

        function handleImageUpload(imageInputId, imagePreviewId, cancelButtonId, cropXId, cropYId, cropWidthId,
            cropHeightId, descriptionId) {
            var $image = $(imagePreviewId);
            var $cancelImage = $(cancelButtonId);
            var $description = $(descriptionId);
            var cropper;

            $(imageInputId).change(function(event) {
                if (this.id === imageInputId.replace('#', '')) {

                    // Hapus instance CropperJS jika ada
                    if (cropper) {
                        cropper.destroy();
                        cropper = null;
                    }

                    $image.removeAttr('hidden');
                    $cancelImage.removeAttr('hidden');
                    $description.removeAttr('hidden');

                    var files = event.target.files;
                    var done = function(url) {
                        $image.attr('src', url);
                        $image.show();

                        if (files && files.length > 0) {
                            var reader = new FileReader();
                            reader.onload = function(event) {
                                // Inisialisasi CropperJS setelah gambar selesai dimuat
                                cropper = new Cropper($image[0], {
                                    aspectRatio: 3 / 2,
                                    viewMode: 1,
                                    crop(event) {
                                        $(cropXId).val(Math.round(event.detail.x));
                                        $(cropYId).val(Math.round(event.detail.y));
                                        $(cropWidthId).val(Math.round(event.detail.width));
                                        $(cropHeightId).val(Math.round(event.detail.height));
                                    }
                                });
                            };
                            reader.readAsDataURL(files[0]);
                        }
                    };

                    if (files && files.length > 0) {
                        var reader = new FileReader();
                        reader.onload = function(event) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(files[0]);
                    }
                }
            });

            $(cancelButtonId).click(function() {
                $(imageInputId).val('');
                $image.attr('src', '');
                $image.attr('hidden', 'hidden'); // Sembunyikan elemen gambar
                $cancelImage.attr('hidden', 'hidden'); // Sembunyikan tombol cancel
                $description.attr('hidden', 'hidden'); // Sembunyikan input description

                if (cropper) {
                    cropper.destroy();
                    cropper = null; // Hapus instance cropper saat tombol cancel ditekan
                }

                $(cropXId).val('');
                $(cropYId).val('');
                $(cropWidthId).val('');
                $(cropHeightId).val('');
            });
        }
    </script>
    <script>
        function confirmDelete(productId) {
            // Set action URL untuk form
            console.log('confirmDelete called with ID:', productId);

            try {
                var deleteUrl = "{{ route('landing-page-settings.product.delete', '') }}/" + productId;
                console.log('Delete URL:', deleteUrl);

                document.getElementById('deleteForm').action = deleteUrl;
                console.log('Form action set');

                var modalElement = document.getElementById('deleteModal');
                console.log('Modal element:', modalElement);

                var deleteModal = new bootstrap.Modal(modalElement);
                console.log('Modal instance created');

                deleteModal.show();
                console.log('Modal shown');
            } catch (error) {
                console.error('Error in confirmDelete:', error);
            }
        }

        // Pastikan modal bisa ditutup
        document.addEventListener('DOMContentLoaded', function() {
            var closeButtons = document.querySelectorAll('[data-bs-dismiss="modal"]');
            closeButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                    if (modal) {
                        modal.hide();
                    }
                });
            });
        });
    </script>
@endsection

@section('after-scripts')
@endsection
