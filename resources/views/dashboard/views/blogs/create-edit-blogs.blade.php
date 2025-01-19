@extends('dashboard.layout.app')
@section('page-name')
    Mange Blog
@endsection

@section('after-styles')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">

    <style>
        .ck-editor__editable {
            min-height: 300px;
        }
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ isset($blog) ? 'Edit Blog' : 'Create Blog' }} </h5>
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
                                <form
                                    action="{{ isset($blog) ? route('blogs.update', encrypt($blog->id)) : route('blogs.store') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @method('PATCH')
                                    @if (isset($blog))
                                        @csrf
                                    @endif
                                    <div class="modal-body">
                                        <div class="row mb-3 mt-3">
                                            <label for="inputText" class="col-sm-12 col-form-label">Title*</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="title" required
                                                    value="{{ old('name', $blog->title ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3 mt-3">
                                            <label for="inputText" class="col-sm-12 col-form-label">Category Blog*</label>
                                            <div class="col-sm-12">
                                                <select class="form-select" aria-label="Default select example" required
                                                    name="blog_category_id">
                                                    @foreach ($blogCategories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ old('blog_category_id') ? 'selected' : '' }}>
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="image">Gambar *: </label>
                                            <div class="col-sm-12">
                                                <input type="file" name="image" id="image" class="form-control "
                                                    required>
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
                                        <div class="row mb-3 mt-3">
                                            <label for="inputText" class="col-sm-12 col-form-label">Content*</label>
                                            <div class="col-sm-12">
                                                {{-- <textarea class="form-control" name="content" id="editor" required>{{ old('name', $blog->title ?? '') }}</textarea> --}}
                                                <div id="editor">
                                                    {{ old('content', $blog->content ?? '') }}
                                                </div>
                                            </div>
                                        </div>
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
@endsection
@section('after-scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['undo', 'redo',
                    '|', 'heading',
                    '|', 'bold', 'italic',
                    '|', 'link', 'uploadImage', 'blockQuote', 'code',
                    '|', 'bulletedList', 'numberedList',
                    '|', 'outdent', 'indent',
                    '|', 'insertTable'
                ],
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        }
                    ]
                },
                image: {
                    toolbar: [
                        'imageStyle:inline',
                        'imageStyle:block',
                        'imageStyle:side',
                        '|',
                        'toggleImageCaption',
                        'imageTextAlternative'
                    ]
                },
                ckfinder: {
                    uploadUrl: "{{ route('blogs.upload-image', ['_token' => csrf_token()]) }}",
                },
            })
            .then(editor => {
                let previousData = editor.getData(); // Simpan data awal editor

                // Event listener saat data editor berubah
                editor.model.document.on('change:data', () => {
                    const updatedData = editor.getData();
                    console.log("Updated Editor Data:", updatedData);
                    detectDeletedImages(previousData, updatedData);
                    previousData = updatedData; // Perbarui data sebelumnya
                });

                // MutationObserver untuk memantau perubahan elemen di editor
                const editorElement = document.querySelector('.ck-editor__editable');
                const observer = new MutationObserver(() => {
                    const updatedData = editor.getData();
                    console.log("Observer Detected Change in Editor");
                    detectDeletedImages(previousData, updatedData);
                    previousData = updatedData; // Perbarui data sebelumnya
                });

                observer.observe(editorElement, {
                    childList: true,
                    subtree: true
                });

                // Listener untuk menangkap Backspace atau Delete
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' || e.key === 'Delete') {
                        const updatedData = editor.getData();
                        console.log("Data after Backspace/Delete:", updatedData);
                        detectDeletedImages(previousData, updatedData);
                        previousData = updatedData; // Perbarui data sebelumnya
                    }
                });

                // Fungsi untuk mendeteksi gambar yang dihapus
                function detectDeletedImages(oldData, newData) {
                    const oldImages = extractImageUrls(oldData);
                    const newImages = extractImageUrls(newData);

                    console.log("Old Images:", oldImages);
                    console.log("New Images:", newImages);

                    const deletedImages = oldImages.filter(image => !newImages.includes(image));
                    console.log("Deleted Images:", deletedImages);

                    // Kirim request delete ke server untuk setiap gambar yang dihapus
                    deletedImages.forEach(imageUrl => {
                        deleteImageOnServer(imageUrl);
                    });
                }

                // Fungsi untuk mengekstrak URL gambar dari HTML
                function extractImageUrls(data) {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = data;

                    console.log("Extracting images from data:", data);
                    const images = Array.from(tempDiv.querySelectorAll('img')).map(img => img.getAttribute('src'));
                    console.log("Extracted Images:", images);
                    return images;
                }

                // Fungsi untuk menghapus gambar di server
                function deleteImageOnServer(imageUrl) {
                    console.log("Deleting image on server:", imageUrl);

                    $.ajax({
                        url: "{{ route('blogs.delete-image') }}",
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            file_path: imageUrl
                        },
                        success: (response) => {
                            console.log("Image deleted successfully:", response.message);
                        },
                        error: (xhr) => {
                            console.error("Error deleting image:", xhr.responseJSON.message ||
                                'Error deleting image.');
                        }
                    });
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
