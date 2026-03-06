@php use App\Models\User; @endphp
@extends('layouts/staff-main')
@section('title', 'UPP SACCO')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Role Management</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-person-gear" viewBox="0 0 16 16">
                                        <path
                                            d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">Role Management </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">

                    <div class="card">

                        <div class="d-flex justify-content-end align-items-center">
                            {{-- Alerts for the home page --}}
                            @if (session('success'))
                                <div class="alert alert-light-success alert-dismissible fade show mx-auto col-md-4 m-3"
                                    role="alert">
                                    <p class="txt-info"> {{ session('success') }}</p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-light-secondary alert-dismissible fade show col-md-4 mx-auto m-3"
                                    role="alert">
                                    <p class="txt-info"> {{ session('error') }}</p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            {{-- Alerts for the home page --}}

                            <a class="btn btn-primary m-3" data-bs-toggle="collapse" href="#assignRoleTable" role="button"
                                aria-expanded="false" aria-controls="assignRoleTable"><i class="icon-plus"></i>
                                Assign Role</a>
                        </div>

                        <!-- Container-fluid starts-->
                        {{-- Assign Roles --}}
                        <div class="card-body">

                            <div class="col-sm-12 collapse multi-collapse dark-accordion" id="assignRoleTable">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="row g-3" method="POST" action="{{ route('roles.store') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mt-3  mb-3">
                                                <div class="col-md-2"></div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="user">Member</label>
                                                    <select class="form-select btn-pill" id="categorySelect" name="user_id"
                                                        required>
                                                        <option selected="" disabled="" value="">Choose...
                                                        </option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">
                                                                {{ $user->first_name . ' ' . $user->last_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="role">Role</label>
                                                    <select class="form-select btn-pill" id="categorySelect" name="role_id"
                                                        required>
                                                        <option selected="" disabled="" value="">Choose...
                                                        </option>
                                                        @foreach ($assign_roles as $role)
                                                            <option value="{{ $role->id }}">
                                                                {{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>

                                            <div class="col-12 d-flex justify-content-center">
                                                <button class="btn btn-primary" type="submit">Assign Role</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive custom-scrollbar">
                                <table class="display basic-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Member</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($all_roles as $user_roles)
                                            @php
                                                $cnt = $loop->iteration;
                                            @endphp
                                            <tr>
                                                <td>{{ $cnt }}</td>
                                                <td class="h6 text-primary">
                                                    <a class="text-primary "
                                                        href="{{ route('members.show', $user_roles->member->id) }}">{{ $user_roles->member->first_name . ' ' . $user_roles->member->last_name }}</a>
                                                </td>
                                                <td class="h6 txt-primary">{{ $user_roles->role->name }}</td>
                                                <td>
                                                    <form action="{{ route('roles.destroy', $user_roles->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-outline-danger btn-xs txt-info" type="submit"
                                                            title="btn btn-outline-primary btn-xs">Unassign</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
