@extends('layouts/staff-main')
@section('title', 'UPP SACCO')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Add Balance Sheet Entry</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-graph-down-arrow" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M0 0h1v15h15v1H0zm10 11.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-1 0v2.6l-3.613-4.417a.5.5 0 0 0-.74-.037L7.06 8.233 3.404 3.206a.5.5 0 0 0-.808.588l4 5.5a.5.5 0 0 0 .758.06l2.609-2.61L13.445 11H10.5a.5.5 0 0 0-.5.5" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">Add Balance Sheet Entry </li>
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
                            <div class="col-10 mb-4">
                                <small class="text-danger">
                                    <b>NOTE:</b>
                                    This section is for manual balance sheet records only. Automated entries such as
                                    savings, shares, and loans are managed from their respective modules.
                                </small>
                            </div>
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
                            <form class="row g-3" method="POST" action="{{ route('balance-sheet-entires.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label class="form-label" for="membership-number">Category</label>
                                        <select class="form-select btn-pill" id="categorySelect" name="category" required>
                                            <option selected="" disabled="" value="">Choose...</option>
                                            <option value="Assets">Assets</option>
                                            <option value="Liabilities">Liabilities</option>
                                            <option value="Equity">Equity</option>
                                        </select>
                                        @error('category')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="membership-number">Sub Category</label>
                                        <select class="form-select btn-pill" id="subcategorySelect" name="sub_category_id"
                                            required>
                                            <option selected="" disabled="" value="">Choose...</option>
                                            @foreach ($sub_categories as $sub_category)
                                                <option value="{{ $sub_category->id }}">
                                                    {{ $sub_category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('sub_category_id')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="item_name">Item Name</label>
                                        <input class="form-control btn-pill" id="item_name" name="item_name" required
                                            value="{{ old('item_name') }}">
                                        @error('item_name')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="item_description">Description</label>
                                        <textarea class="form-control btn-pill" id="item_description" name="item_description" rows="2" required>{{ old('item_description') }}</textarea>
                                        @error('item_description')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-2">
                                        <label class="form-label" for="amount">Value</label>
                                        <input class="form-control btn-pill commaAmount" id="amount" name="amount"
                                            type="text" value="{{ old('amount') }}" placeholder="Amount"
                                            aria-label="Amount" required>
                                        @error('amount')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label" for="exampleFormControlInput1">Date Added</label>
                                        <input class="form-control digits" type="date" name="date_added"
                                            value="{{ old('date_added') }}" required>
                                        @error('date_added')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label" for="attachment">Attachment</label>
                                        <input class="form-control btn-pill" id="attachment" name="attachment"
                                            type="file">
                                        <small class="txt-primary mt-2">Format: jpeg,png,jpg</small><br>
                                        @error('attachment')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Add Entry</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends -->
    </div>
@endsection

@push('scripts')
    <script></script>
@endpush
