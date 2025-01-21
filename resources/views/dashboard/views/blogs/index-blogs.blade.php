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
                        <h5 class="card-title">Manage Blog</h5>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="{{route('blogs.create')}}" class="btn btn-primary" >
                                        Add Blogs
                                    </a>
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
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Number</th>
                                    <th>
                                        Title
                                    </th>
                                    <th>
                                        Category Blog
                                    </th>
                                    <th>
                                        Create By
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $key => $blog)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $blog->title }}</td>
                                        <td>{{ $blog->blogCategory->name }}</td>
                                        <td>{{ $blog->user->name }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('blogs.edit', encrypt($blog->id)) }}">Edit</a>
                                                    </li>
                                                    <li><a class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal"
                                                            data-bs-dismiss="modal"
                                                            onclick="confirmDelete('{{ encrypt($blog->id) }}')">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
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
                    Apakah anda yakin ingin menghapus artikel blog ini?
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

@endsection


@section('before-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function confirmDelete(blogId) {
            // Set action URL untuk form
            console.log('confirmDelete called with ID:', blogId);

            try {
                var deleteUrl = "{{ route('blogs.delete', '') }}/" + blogId;
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
