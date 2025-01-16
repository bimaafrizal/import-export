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
                        <h5 class="card-title">Edit Product</h5>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
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

                        <div class="row">
                            <div class="col-12">
                                <form action="{{ route('landing-page-settings.product.update', encrypt($product->id)) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @method('PATCH')
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row mb-3 mt-3">
                                            <label for="inputText" class="col-sm-12 col-form-label">Nama Product*</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="name" required
                                                    value="{{ old('name', $product->name) }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="inputText" class="col-sm-12 col-form-label">Deskripsi*</label>
                                            <div class="col-sm-12">
                                                <textarea class="form-control" style="height: 100px" name="description">{{ old('description', $product->description) }}</textarea>
                                            </div>
                                        </div>
                                        <?php $count = 0; ?>
                                        @foreach ($images as $key => $image)
                                            <?php $count++; ?>
                                            <div class="row mb-3">
                                                <label for="image">Gambar {{ $key + 1 }}: </label>
                                                <div class="col-sm-12">
                                                    <input type="file" name="image{{ $key + 1 }}"
                                                        id="image{{ $key + 1 }}" class="form-control">
                                                    <button type="button" class="btn btn-secondary mt-3"
                                                        id="cancel-image{{ $key + 1 }}" aria-label="Close"
                                                        hidden>Cancel Image</button>
                                                    @if ($key >= 1)
                                                        <button type="button" class="btn btn-secondary mt-3"
                                                            id="delete-image{{ $key + 1 }}" aria-label="Close">Delete
                                                            Image</button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mb-3" id="deskripsi{{ $key + 1 }}">
                                                <label for="inputText" class="col-sm-12 col-form-label">Deskripsi Gambar
                                                    {{ $key + 1 }}</label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control" style="height: 100px" name="description_image{{ $key + 1 }}"
                                                        id="description_image{{ $key + 1 }}">{{ $image->description }}</textarea>
                                                    <input type="text"
                                                        name="original_description_image{{ $key + 1 }}"
                                                        value="{{ $image->description }}" hidden>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <img id="image-preview{{ $key + 1 }}" src="{{ $image->path }}"
                                                    alt="Preview Gambar">
                                                <input type="hidden" name="crop_x{{ $key + 1 }}"
                                                    id="crop_x{{ $key + 1 }}">
                                                <input type="hidden" name="crop_y{{ $key + 1 }}"
                                                    id="crop_y{{ $key + 1 }}">
                                                <input type="hidden" name="crop_width{{ $key + 1 }}"
                                                    id="crop_width{{ $key + 1 }}">
                                                <input type="hidden" name="crop_height{{ $key + 1 }}"
                                                    id="crop_height{{ $key + 1 }}">
                                                <input type="hidden" name="imageId{{ $key + 1 }}"
                                                    id="imageId{{ $key + 1 }}" value="{{ $image->id }}">
                                                <input type="hidden" name="statusEdited{{ $key + 1 }}"
                                                    id="statusEdited{{ $key + 1 }}" value="no-edited">
                                                <input type="hidden" name="descriptionEdited{{ $key + 1 }}"
                                                    id="descriptionEdited{{ $key + 1 }}" value="no-edited">

                                            </div>
                                        @endforeach
                                        @if ($count != 3)
                                            <?php for ($i=$count; $i < 3; $i++) { ?>
                                            <div class="row mb-3">
                                                <label for="image">Gambar {{ $i + 1 }}: </label>
                                                <div class="col-sm-12">
                                                    <input type="file" name="image{{ $i + 1 }}"
                                                        id="image{{ $i + 1 }}" class="form-control">
                                                    <button type="button" class="btn btn-secondary mt-3"
                                                        id="cancel-image{{ $i + 1 }}" aria-label="Close"
                                                        hidden>Cancel Image</button>
                                                </div>
                                            </div>
                                            <div class="row mb-3" id="deskripsi{{ $i + 1 }}" hidden>
                                                <label for="inputText" class="col-sm-12 col-form-label">Deskripsi Gambar
                                                    {{ $i + 1 }}</label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control" style="height: 100px" name="description_image{{ $i + 1 }}"
                                                        id="description_image{{ $i + 1 }}"></textarea>
                                                    <input type="text"
                                                        name="original_description_image{{ $i + 1 }}"
                                                        value="" hidden>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <img id="image-preview{{ $i + 1 }}" src=""
                                                    alt="Preview Gambar" hidden>
                                                <input type="hidden" name="crop_x{{ $i + 1 }}"
                                                    id="crop_x{{ $i + 1 }}">
                                                <input type="hidden" name="crop_y{{ $i + 1 }}"
                                                    id="crop_y{{ $i + 1 }}">
                                                <input type="hidden" name="crop_width{{ $i + 1 }}"
                                                    id="crop_width{{ $i + 1 }}">
                                                <input type="hidden" name="crop_height{{ $i + 1 }}"
                                                    id="crop_height{{ $i + 1 }}">
                                                <input type="hidden" name="imageId{{ $i + 1 }}"
                                                    id="imageId{{ $i + 1 }}" value="">
                                                <input type="hidden" name="statusEdited{{ $i + 1 }}"
                                                    id="statusEdited{{ $i + 1 }}" value="no-isset">
                                                <input type="hidden" name="descriptionEdited{{ $i + 1 }}"
                                                    id="descriptionEdited{{ $i + 1 }}" value="no-edited">

                                            </div>
                                            <?php } ?>
                                        @endif
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
    </section>

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
            handleImageUpload('#image1', '#image-preview1', '#cancel-image1', '#crop_x1', '#crop_y1',
                '#crop_width1',
                '#crop_height1', '#deskripsi1', '#delete-image1', '#statusEdited1', '#descriptionEdited1',
                '#description_image1');
            handleImageUpload('#image2', '#image-preview2', '#cancel-image2', '#crop_x2', '#crop_y2',
                '#crop_width2', '#crop_height2', '#deskripsi2', '#delete-image2', '#statusEdited2',
                '#descriptionEdited2', '#description_image2');
            handleImageUpload('#image3', '#image-preview3', '#cancel-image3', '#crop_x3', '#crop_y3',
                '#crop_width3', '#crop_height3', '#deskripsi3', '#delete-image3', '#statusEdited3',
                '#descriptionEdited3', '#description_image3');
        });

        function handleImageUpload(imageInputId, imagePreviewId, cancelButtonId, cropXId, cropYId, cropWidthId,
            cropHeightId, descriptionId, deleteButtonId, statusEditedId, descriptionEditedId, descriptionImageId) {
            var $image = $(imagePreviewId);
            var $cancelImage = $(cancelButtonId);
            var $description = $(descriptionId);
            var $deleteImage = $(deleteButtonId);
            var $statusEdited = $(statusEditedId);
            var $descriptionEdited = $(descriptionEditedId);
            var $descriptionImage = $(descriptionImageId);
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
                    $statusEdited.val('edited');
                    $deleteImage.attr('hidden', 'hidden');

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
                $statusEdited.val('no-isset');

                //delete value description
                $description.val('');

                if (cropper) {
                    cropper.destroy();
                    cropper = null; // Hapus instance cropper saat tombol cancel ditekan
                }

                $(cropXId).val('');
                $(cropYId).val('');
                $(cropWidthId).val('');
                $(cropHeightId).val('');
            });
            $(deleteButtonId).click(function() {
                $(imageInputId).val('');
                $image.attr('src', '');
                $image.attr('hidden', 'hidden'); // Sembunyikan elemen gambar
                $cancelImage.attr('hidden', 'hidden'); // Sembunyikan tombol cancel
                $description.attr('hidden', 'hidden'); // Sembunyikan input description
                $deleteImage.attr('hidden', 'hidden'); // Sembunyikan tombol delete
                $statusEdited.val('deleted');

                //delete value description
                $description.val('');

                if (cropper) {
                    cropper.destroy();
                    cropper = null; // Hapus instance cropper saat tombol cancel ditekan
                }

                $(cropXId).val('');
                $(cropYId).val('');
                $(cropWidthId).val('');
                $(cropHeightId).val('');
            });

            $descriptionImage.on('blur', function() {
                if ($descriptionImage.val() != $descriptionImage.attr('original_description_image')) {
                    $descriptionEdited.val('edited');
                } else {
                    $descriptionEdited.val('no-edited');
                }
            });

        }
    </script>
@endsection
