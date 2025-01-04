@extends('dashboard.layout.app')
@section('page-name')
    Create Management Admin
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Admin</h5>
                        {{-- show errror --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <ul class="mb-0">
                                        <li>{{ $error }}</li>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </ul>
                                @endforeach
                            </div>
                        @endif
                        <form method="POST" action="{{ route('management-admin.update', encrypt($user->id)) }}">
                            @method('PATCH')
                            @csrf
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-12 col-form-label">Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="name" required
                                        value="{{ old('name', $user->name) }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail" class="col-sm-12 col-form-label">Email</label>
                                <div class="col-sm-12">
                                    <input type="email" class="form-control" name="email" required
                                        value="{{ old('email', $user->email) }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputNumber" class="col-sm-12 col-form-label">Phone Number</label>
                                <div class="col-sm-12">
                                    <input type="number" class="form-control" name="phone_number"
                                        value="{{ old('phone_number', $user->phone_number) }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputPassword" class="col-sm-12 col-form-label">Password</label>
                                <div class="col-sm-12">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="confirmPassword" class="col-sm-12 col-form-label">Confirm Password</label>
                                <div class="col-sm-12">
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Submit Form</button>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6" style="background-color: #f8f9fa; padding: 10px;">
                                    <h5 class="card-title">Password requirements</h5>
                                    <p>Please follow this guide for a strong password:</p>
                                    <ul class="text-muted ps-4 mb-0">
                                        <li>Must have capital and normal letter</li>
                                        <li>One special characters</li>
                                        <li>Min 6 characters</li>
                                        <li>One number (2 are recommended)</li>
                                    </ul>
                                </div>
                            </div>

                        </form><!-- End General Form Elements -->
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
