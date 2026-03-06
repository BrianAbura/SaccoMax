@extends('layouts/staff-main')
@section('title', 'UPP SACCO')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Edit Expense</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-graph-down-arrow" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M0 0h1v15h15v1H0zm10 11.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-1 0v2.6l-3.613-4.417a.5.5 0 0 0-.74-.037L7.06 8.233 3.404 3.206a.5.5 0 0 0-.808.588l4 5.5a.5.5 0 0 0 .758.06l2.609-2.61L13.445 11H10.5a.5.5 0 0 0-.5.5" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">Edit Expense </li>
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
                        <div class="card-body">
                            {{-- Alerts for the home page --}}
                            @if (session('success'))
                                <div class="alert alert-light-success alert-dismissible fade show col-md-4 mx-auto mb-3"
                                    role="alert">
                                    <p class="txt-info"> {{ session('success') }}</p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-light-secondary alert-dismissible fade show col-md-4 mx-auto mb-3"
                                    role="alert">
                                    <p class="txt-info"> {{ session('error') }}</p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            {{-- Alerts for the home page --}}
                            <form class="row g-3" method="POST" action="{{ route('expenses.update', $expense->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label class="form-label" for="membership-number">Category</label>
                                        <select class="form-select btn-pill" id="categorySelect" name="category_id">
                                            <option selected="" disabled="" value="">Choose...</option>
                                            <option value="Others">Others</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $expense->category_id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <div id="otherCategoryInput" class="mt-2 mb-2" style="display: none;">
                                            <input class="form-control btn-pill" name="new_category" type="text"
                                                placeholder="Enter category name">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="amount">Amount</label>
                                        <input class="form-control btn-pill commaAmount" id="amount" name="amount"
                                            type="text" value="{{ number_format($expense->amount) }}" placeholder="Amount"
                                            aria-label="Amount" required>
                                        @error('amount')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="description">Description</label>
                                        <textarea class="form-control btn-pill" id="description" name="description" placeholder="e.g. Taxes for the month of July" rows="2"
                                            required>{{ $expense->description }}</textarea>
                                        @error('description')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label" for="exampleFormControlInput1">Payment Date</label>
                                        <input class="form-control digits" type="date" name="date_paid"
                                            value="{{ $expense->date_paid }}">
                                        @error('date_paid')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label" for="attachment">Attachment</label>
                                        <input class="form-control btn-pill" id="attachment" name="attachment"
                                            type="file">
                                        <small class="txt-primary mt-2">Format: jpeg,png,jpg</small><br>

                                        {{-- uploaded file --}}
                                        @if (!empty($expense->attachment))
                                            <a href="#" class="open-modal" data-bs-toggle="modal"
                                                data-bs-target="#imageModal"
                                                data-image="{{ asset($expense->attachment) }}">
                                                <img class="b-r-10" src="{{ asset($expense->attachment) }}"
                                                    width="60px">
                                            </a>
                                        @else
                                            <i class="icofont icofont-close-squared-alt h4" title="No file attached"></i>
                                        @endif
                                        {{-- end uploaded file --}}

                                        @error('attachment')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Update Record</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap Modal (Single Modal for All Images) -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Attachment Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" class="img-fluid b-r-10">
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap Modal (Single Modal for All Images) -->
        <!-- Container-fluid Ends -->
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('categorySelect');
            const otherCategoryInput = document.getElementById('otherCategoryInput');

            categorySelect.addEventListener('change', function() {
                if (this.value === 'Others') {
                    otherCategoryInput.style.display = 'block';
                } else {
                    otherCategoryInput.style.display = 'none';
                }
            });

            // Check initial value in case of form resubmission
            if (categorySelect.value === 'Others') {
                otherCategoryInput.style.display = 'block';
            }
        });
    </script>
@endpush
