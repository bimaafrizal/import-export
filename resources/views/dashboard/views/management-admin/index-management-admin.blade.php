@extends('dashboard.layout.app')
@section('page-name')
    Management Admin
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Admin</h5>
                        <a href="{{ route('management-admin.create') }}" class="btn btn-primary mb-2">Tambah Admin</a>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone_num ?? '-' }}</td>
                                        <td>{{ $user->role->name }}</td>
                                        <td>active</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('management-admin.edit', $user->id) }}">Edit</a>
                                                    </li>
                                                    {{-- <li><a class="dropdown-item" href="{{route('management-admin.destroy', $user->id)}}">Delete</a></li> --}}
                                                    <li><a class="dropdown-item" href="">Delete</a></li>
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
        </div>
    </section>
@endsection
