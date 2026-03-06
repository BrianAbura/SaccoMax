@php use App\Models\User; @endphp
@extends('layouts/staff-main')
@section('title', 'UPP SACCO')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Balance Sheet Entries</h4>
                        <small class="text-muted">Manage manual balance sheet entries, including assets, liabilities, and
                            equity.</small>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-graph-down-arrow" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M0 0h1v15h15v1H0zm10 11.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-1 0v2.6l-3.613-4.417a.5.5 0 0 0-.74-.037L7.06 8.233 3.404 3.206a.5.5 0 0 0-.808.588l4 5.5a.5.5 0 0 0 .758.06l2.609-2.61L13.445 11H10.5a.5.5 0 0 0-.5.5" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">Balance Sheet Entries </li>
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

                            <a href="{{ route('balance-sheet-entires.create') }}" class="btn btn-primary m-3"><i
                                    class="icon-plus"></i>
                                New Entry</a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar">
                                <table class="display basic-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th>Item Name</th>
                                            <th>Item Description</th>
                                            <th>Item Value</th>
                                            <th>Date Added</th>
                                            <th>Attachment</th>
                                            <th>Added By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($balanceSheetEntries as $record)
                                            @php
                                                $cnt = $loop->iteration;
                                            @endphp
                                            <tr>
                                                <td>{{ $cnt }}</td>
                                                <td>{{ $record->category }}</td>
                                                <td>{{ $record->sub_category->name }}</td>
                                                <td>{{ $record->item_name }}</td>
                                                <td>{{ $record->item_description }}</td>
                                                <td class="text-primary">{{ number_format($record->item_value) }}</td>
                                                <td> {{ date('d-m-Y', strtotime($record->date)) }} </td>
                                                <td>
                                                    @if (!empty($record->attachment))
                                                        <a href="#" class="open-modal" data-bs-toggle="modal"
                                                            data-bs-target="#imageModal"
                                                            data-image="{{ asset($record->attachment) }}">
                                                            <img class="b-r-10" src="{{ asset($record->attachment) }}"
                                                                width="60px">
                                                        </a>
                                                    @else
                                                        -
                                                        {{-- <i class="icofont icofont-close-squared-alt h4"
                                                            title="No file attached"></i> --}}
                                                    @endif
                                                </td>
                                                <td class="text-success">
                                                    @php
                                                        $user = User::find($record->user_id);
                                                    @endphp
                                                    {{ $user->first_name . ' ' . $user->last_name }}
                                                </td>
                                                <td>
                                                    <ul class="action">
                                                        <li class="edit"> <a
                                                                href="{{ route('balance-sheet-entires.edit', $record->id) }}"><i
                                                                    class="icon-pencil-alt"></i></a></li>
                                                        <li class="delete" data-bs-toggle="modal"
                                                            data-bs-target="#deleteTransaction{{ $record->id }}"><a
                                                                href="#"><i class="icon-trash"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            {{-- Delete transaction --}}
                                            <div class="modal fade" id="deleteTransaction{{ $record->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="modal-toggle-wrapper">
                                                                <ul class="modal-img">
                                                                    <li> <img
                                                                            src="{{ asset('assets/images/gif/danger.gif') }}"
                                                                            alt="error"></li>
                                                                </ul>
                                                                <h4 class="text-center pb-1 txt-danger">Delete Entry
                                                                </h4>
                                                                <p class="text-center">Are you sure you want to delete
                                                                    this transaction?
                                                                    Please note that this action cannot be reversed.
                                                                </p>
                                                                <form
                                                                    action="{{ route('balance-sheet-entires.destroy', $record->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-success d-flex m-auto"
                                                                        type="submit" data-bs-dismiss="modal">Yes,
                                                                        Proceed</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <!-- Bootstrap Modal (Single Modal for All Images) -->
                                        <div class="modal fade" id="imageModal" tabindex="-1"
                                            aria-labelledby="imageModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Attachment Preview</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img id="modalImage" src="" class="img-fluid b-r-10">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Bootstrap Modal (Single Modal for All Images) -->
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
@endsection
