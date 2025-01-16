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
                        <h5 class="card-title">Manage Gallery</h5>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#disablebackdrop">
                                        Add Image
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


                        @if ($images->isEmpty())
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-center">
                                        <p>Belum Ada team</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                @foreach ($images as $key => $image)
                                    <div class="col-lg-3 col-md-4 col-sm-12">
                                        <div class="card">
                                            <img src="{{ asset($image->path) }}" class="card-img-top"
                                                alt="{{ $image->name }}">
                                            <div class="card-body">
                                                <textarea name="" id="" class="form-control mt-2 mb-2" style="height: 100px" readonly>{{ !empty($image->description) ? $image->description : '-' }}</textarea>
                                                <div class="row">
                                                    <div class="d-flex justify-content-end">
                                                        @if ($image->type == 'gallery')
                                                            <a href="{{ route('landing-page-settings.gallery.edit', encrypt($image->id)) }}"
                                                                class="btn btn-primary">Edit</a>
                                                        @endif
                                                        <form
                                                            action="{{ route('landing-page-settings.gallery.update-status', encrypt($image->id)) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            @if ($image->show_gallery == 1)
                                                                <button class="btn btn-warning ms-2"
                                                                    type="submit">Hide</button>
                                                            @else
                                                                <button class="btn btn-info ms-2"
                                                                    type="submit">Show</button>
                                                            @endif
                                                        </form>
                                                        @if ($image->type == 'gallery')
                                                            <button type="button" class="btn btn-danger ms-2"
                                                                onclick="confirmDelete('{{ encrypt($image->id) }}')">Delete</button>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    {{ $images->links() }}
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
                    Apakah Anda yakin ingin menghapus team ini?
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
                    <h5 class="modal-title">Add Team</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('landing-page-settings.gallery.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3 mt-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Deskripsi*</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" style="height: 100px" name="description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="image">Gambar *: </label>
                            <div class="col-sm-12">
                                <input type="file" name="image" id="image" class="form-control " required>
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
@endsection

@section('before-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <script>
        $(document).ready(function() {
            handleImageUpload('#image', '#image-preview', '#cancel-image', '#crop_x', '#crop_y', '#crop_width',
                '#crop_height', '#deskripsi1');
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
                                    aspectRatio: 4 / 3,
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
        function confirmDelete(imageId) {
            // Set action URL untuk form
            console.log('confirmDelete called with ID:', imageId);

            try {
                var deleteUrl = "{{ route('landing-page-settings.gallery.delete', '') }}/" + imageId;
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
