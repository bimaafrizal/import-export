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
                        <h5 class="card-title">Manage Team</h5>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#disablebackdrop">
                                        Add contact
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <ul>
                                    <li>Icon : <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icon</a>
                                    </li>
                                </ul>
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
                                    <th>
                                        Title
                                    </th>
                                    <th>Value</th>
                                    <th>Icon</th>
                                    <th>Type</th>
                                    <th>Link</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $contact)
                                    <tr>
                                        <td>{{ $contact->title }}</td>
                                        <td>{{ $contact->value }}</td>
                                        <td> <i class="{!! $contact->icon !!} flex-shrink-0"></i></td>
                                        <td>{{ $contact->type }}</td>
                                        <td class="text-truncate" style="max-width: 150px;">{{ $contact->link ?? '-' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('landing-page-settings.contact.edit', encrypt($contact->id)) }}">Edit</a>
                                                    </li>
                                                    @if ($contact->status_delete)

                                                    <li><a class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal"
                                                            data-bs-dismiss="modal"
                                                            onclick="confirmDelete('{{ encrypt($contact->id) }}')">Delete</a>
                                                    </li>
                                                    @endif

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
                <form action="{{ route('landing-page-settings.contact.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3 mt-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Title*</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="title" required
                                    value="{{ old('title') }}">
                            </div>
                        </div>
                        <div class="row mb-3 mt-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Value*</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="value" required
                                    value="{{ old('value') }}">
                            </div>
                        </div>
                        <div class="row mb-3 mt-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Icons*</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="icon" required
                                    value="{{ old('icon') }}">
                            </div>
                        </div>
                        <div class="row mb-3 mt-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Link</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="link"
                                    value="{{ old('link') }}">
                            </div>
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


@section('before-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function confirmDelete(contactId) {
            // Set action URL untuk form
            console.log('confirmDelete called with ID:', contactId);

            try {
                var deleteUrl = "{{ route('landing-page-settings.contact.delete', '') }}/" + contactId;
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
