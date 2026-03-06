@extends('layouts/staff-main')
@section('title', 'UPP SACCO')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Balance Sheet Sub Categories</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-tools" viewBox="0 0 16 16">
                                        <path
                                            d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3q0-.405-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708M3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">Balance Sheet Sub Categories </li>
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
                                <div class="alert alert-light-success alert-dismissible fade show mx-auto col-md-4 m-3"
                                    role="alert">
                                    <p class="txt-info"> {{ session('success') }}</p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            {{-- Alerts for the home page --}}

                            <a class="btn btn-primary m-3" data-bs-toggle="collapse" href="#addSubCategoryDiv"
                                role="button" aria-expanded="false" aria-controls="addSubCategoryDiv"><i
                                    class="icon-plus"></i>
                                New Sub Category</a>
                        </div>

                        <div class="card-body">
                            <div class="col-sm-12 collapse multi-collapse dark-accordion" id="addSubCategoryDiv">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="row g-3" method="POST" action="{{ route('staff.balance-sheet-sub-categories.store') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mt-3  mb-3">
                                                <div class="col-md-2"></div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="user">Category</label>
                                                    <select class="form-select btn-pill" id="categorySelect" name="category"
                                                        required>
                                                        <option selected="" disabled="" value="">Choose...
                                                        </option>
                                                        <option value="Assets">Assets</option>
                                                        <option value="Liabilities">Liabilities</option>
                                                        <option value="Equity">Equity</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="role">Sub Category</label>
                                                    <input class="form-control btn-pill" id="description" name="description"
                                                        type="text" value="{{ old('name') }}" required>
                                                    @error('description')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>

                                            <div class="col-12 d-flex justify-content-center">
                                                <button class="btn btn-primary" type="submit">Add Sub Category</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive custom-scrollbar">
                                <table class="display basic-1 small" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sub_categories as $sub_category)
                                            <tr>
                                                <td class="text-wrap f-w-600 text-primary">{{ $sub_category->category }}
                                                </td>
                                                <td>{{ $sub_category->name }}</td>
                                                <td>
                                                    <ul class="action">
                                                        <li class="edit">
                                                            <a href="#" data-bs-toggle="modal"
                                                               data-bs-target="#editSubCategoryModal"
                                                               data-id="{{ $sub_category->id }}"
                                                               data-category="{{ $sub_category->category }}"
                                                               data-description="{{ $sub_category->name }}">
                                                                <i class="icon-pencil-alt"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
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
        <!-- Container-fluid Ends -->
    </div>

    <!-- Edit Sub Category Modal -->
    <div class="modal fade" id="editSubCategoryModal" tabindex="-1" aria-labelledby="editSubCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubCategoryModalLabel">Edit Sub Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editSubCategoryForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="edit_category">Category</label>
                            <select class="form-select btn-pill" id="edit_category" name="category" required>
                                <option value="Assets">Assets</option>
                                <option value="Liabilities">Liabilities</option>
                                <option value="Equity">Equity</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="edit_description">Sub Category</label>
                            <input class="form-control btn-pill" id="edit_description" name="description" type="text" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Sub Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editSubCategoryModal');

            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const category = button.getAttribute('data-category');
                const description = button.getAttribute('data-description');

                const form = document.getElementById('editSubCategoryForm');
                form.action = `/staff/balance-sheet-sub-categories/${id}`;

                document.getElementById('edit_category').value = category;
                document.getElementById('edit_description').value = description;
            });
        });
    </script>
    @endpush
@endsection
