@extends('layouts/staff-main')
@section('title', 'SaccoMax')

@section('css')
    <style>
        .custom-accordion .accordion-button {
            font-size: 12px;
            background-color: #f8f9fa;
            color: #1e88e5;
        }

        .custom-accordion .accordion-button:not(.collapsed) {
            background-color: #e3f2fd;
        }

        .custom-accordion .accordion-button::after {
            width: 0.8rem;
            height: 0.8rem;
            background-size: 0.8rem;
        }

        .custom-accordion .table {
            font-size: 12px;
        }

        .custom-accordion .accordion-body {
            background-color: #fff;
        }
    </style>
@endsection
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Audit Logs</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-list-stars" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5" />
                                        <path
                                            d="M2.242 2.194a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.28.28 0 0 0-.094.3l.173.569c.078.256-.213.462-.423.3l-.417-.324a.27.27 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.28.28 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.27.27 0 0 0 .259-.194zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.28.28 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.27.27 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.28.28 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.27.27 0 0 0 .259-.194zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.28.28 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.27.27 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.28.28 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.27.27 0 0 0 .259-.194z" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">Audit Logs </li>
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
                            <div class="table-responsive custom-scrollbar">
                                <table class="display basic-1 small" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Action</th>
                                            <th>Record ID</th>
                                            <th>Old Data</th>
                                            <th>New Data</th>
                                            <th class="text-center">IP Address</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($auditLogs as $log)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-primary">{{ $log->user->first_name }}
                                                    {{ $log->user->last_name }}</td>
                                                <td class="txt-primary">{{ $log->action }}</td>
                                                <td>{{ $log->record_id }}</td>
                                                <td>
                                                    @if (!empty($log->old_data))
                                                        <div class="accordion">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header">
                                                                    <button
                                                                        class="accordion-button collapsed btn btn-primary"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#oldData{{ $log->id }}">
                                                                        View Previous Data
                                                                    </button>
                                                                </h2>
                                                                <div id="oldData{{ $log->id }}"
                                                                    class="accordion-collapse collapse">
                                                                    <div class="accordion-body">
                                                                        <pre class="small">{{ json_encode($log->old_data, JSON_PRETTY_PRINT) }}</pre>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="badge badge-light text-black">No previous data</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($log->new_data))
                                                        <div class="accordion">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header">
                                                                    <button class="accordion-button collapsed btn btn-info"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#newData{{ $log->id }}">
                                                                        View New Data
                                                                    </button>
                                                                </h2>
                                                                <div id="newData{{ $log->id }}"
                                                                    class="accordion-collapse collapse">
                                                                    <div class="accordion-body">
                                                                        <pre class="small">{{ json_encode($log->new_data, JSON_PRETTY_PRINT) }}</pre>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="badge badge-light text-black">No new data</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $log->ip_address }}</td>
                                                <td>{{ date('d-m-Y H:i', strtotime($log->created_at)) }}</td>
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
@endsection
