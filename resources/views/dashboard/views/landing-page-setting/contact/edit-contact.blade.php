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
                        <h5 class="card-title">Edit Contact</h5>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
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

                        <div class="row">
                            <div class="col-12">
                                <form action="{{ route('landing-page-settings.contact.update', encrypt($contact->id)) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @method('PATCH')
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row mb-3 mt-3">
                                            <label for="inputText" class="col-sm-12 col-form-label">Title*</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="title" required
                                                    value="{{ old('title', $contact->title) }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3 mt-3">
                                            <label for="inputText" class="col-sm-12 col-form-label">Value*</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="value" required
                                                    value="{{ old('value', $contact->value) }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3 mt-3">
                                            <label for="inputText" class="col-sm-12 col-form-label">Icons*</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="icon" required
                                                    value="{{ old('icon', $contact->icon) }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3 mt-3">
                                            <label for="inputText" class="col-sm-12 col-form-label">Link</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="link"
                                                    value="{{ old('link', $contact->link) }}">
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
