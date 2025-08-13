@php use App\Models\User; @endphp
@extends('layouts/staff-main')
@section('title', 'UPP SACCO')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Incomes</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">Incomes </li>
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

                            <a href="{{ route('incomes.create') }}" class="btn btn-primary m-3"><i class="icon-plus"></i>
                                New Income</a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar">
                                <table class="display basic-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Source</th>
                                            <th>Source Id</th>
                                            <th>Category</th>
                                            <th>Amount</th>
                                            <th>Description</th>
                                            <th>Date Received</th>
                                            <th>Attachment</th>
                                            <th>Added By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($incomes as $income)
                                            @php
                                                $cnt = $loop->iteration;
                                            @endphp
                                            <tr>
                                                <td>{{ $cnt }}</td>
                                                <td>{{ $income->source_type }}</td>
                                                <td>
                                                    @if ($income->source_id == '')
                                                        --
                                                    @else
                                                        {{ $income->source_id }}
                                                    @endif
                                                </td>
                                                <td>{{ $income->category->name }}</td>
                                                <td class="text-primary">UGX {{ number_format($income->amount) }}</td>
                                                <td>{{ $income->description }}</td>
                                                <td> {{ date('d-m-Y', strtotime($income->date_received)) }} </td>
                                                <td>
                                                    @if (!empty($income->attachment))
                                                        <a href="#" class="open-modal" data-bs-toggle="modal"
                                                            data-bs-target="#imageModal"
                                                            data-image="{{ asset($income->attachment) }}">
                                                            <img class="b-r-10" src="{{ asset($income->attachment) }}"
                                                                width="60px">
                                                        </a>
                                                    @else
                                                        -
                                                        {{-- <i class="icofont icofont-close-squared-alt h4"
                                                            title="No file attached"></i> --}}
                                                    @endif
                                                </td>
                                                <td class="text-success">
                                                    @if (filter_var($income->added_by, FILTER_VALIDATE_INT))
                                                        @php
                                                            $user = User::find($income->added_by);
                                                        @endphp
                                                        {{ $user->first_name . ' ' . $user->last_name }}
                                                    @else
                                                        {{ $income->added_by }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <ul class="action">
                                                        <li class="edit"> <a
                                                                href="{{ route('incomes.edit', $income->id) }}"><i
                                                                    class="icon-pencil-alt"></i></a></li>
                                                        <li class="delete"><a href="#"><i class="icon-trash"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
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
