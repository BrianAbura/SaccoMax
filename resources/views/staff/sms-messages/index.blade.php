@extends('layouts/staff-main')
@section('title', 'SaccoMax')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>SMS Messages</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-envelope-at" viewBox="0 0 16 16">
                                        <path
                                            d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z" />
                                        <path
                                            d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648m-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">SMS Messages </li>
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
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <span class="text-primary me-3" id="sms_balance">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-envelope-at me-1" viewBox="0 0 16 16">
                                        <path
                                            d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z" />
                                        <path
                                            d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648m-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z" />
                                    </svg>
                                    <strong>SMS Balance:
                                        @if ($smsBalance['Status'] == 'SUCCESS')
                                            <span class="txt-success">{{ $smsBalance['Response'] }} credits</span>
                                        @else
                                            <span class="txt-danger">!Error!</span>
                                        @endif
                                    </strong>
                                </span>
                            </div>

                            <a href="{{ route('sms-messages.create') }}" class="btn btn-primary">New Message</a>
                        </div>
                        {{-- Alerts for the home page --}}
                        @if (session('success') || session('error'))
                            <div class="alert alert-light-success alert-dismissible fade show mx-auto col-md-4 m-3"
                                role="alert">
                                <p class="txt-info"> {{ session('success') ?? session('error') }}</p>
                                <button class="btn-close" type="button" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Message Details Modals --}}
                        @foreach ($messages as $message)
                            <div class="modal fade" id="viewMessageModal{{ $message->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="viewMessageModal{{ $message->id }}Label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Message Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p>Recipient: <strong
                                                            class="txt-primary">{{ $message->member->first_name }}
                                                            {{ $message->member->last_name }}</strong></p>
                                                    <p>Member No:
                                                        <strong>{{ $message->member->membership_number }}</strong>
                                                    </p>
                                                    <p>Date Sent:
                                                        <strong>{{ $message->created_at->format('M d, Y H:i') }}</strong>
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>Sent By: <strong>{{ $message->addedBy->first_name }}
                                                            {{ $message->addedBy->last_name }}</strong></p>
                                                    <p>Scheduled For:
                                                        <strong>
                                                            @if ($message->schedule_date && $message->schedule_time)
                                                                {{ \Carbon\Carbon::parse($message->schedule_date)->format('M d, Y') }}
                                                                {{ $message->schedule_time }}
                                                            @else
                                                                <span class="text-muted">Not Scheduled</span>
                                                            @endif
                                                        </strong>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <h6 class="mb-2">Message Content:</h6>
                                                    <div class="message-content p-3 border rounded txt-info">
                                                        {!! $message->message !!}
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Status Information --}}
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <h6 class="mb-3">SMS Status Information:</h6>
                                                    @php
                                                        $statusData = json_decode($message->status, true);
                                                    @endphp
                                                    @if ($statusData && isset($statusData['Status']))
                                                        <div class="card">
                                                            <div class="card-body">
                                                                @if ($statusData['Status'] === 'SUCCESS')
                                                                    <div class="d-flex align-items-center">
                                                                        <svg class="bi flex-shrink-0 me-2 text-success"
                                                                            width="24" height="24" role="img"
                                                                            aria-label="Success:">
                                                                            <use xlink:href="#check-circle-fill" />
                                                                        </svg>
                                                                        <div>
                                                                            <strong class="text-success">Success!</strong>
                                                                            @if (isset($statusData['Response']))
                                                                                @if (isset($statusData['Response']['SMS_Cost']))
                                                                                    <br>SMS Cost:
                                                                                    {{ $statusData['Response']['SMS_Cost'] }}
                                                                                    credits
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @elseif($statusData['Status'] === 'ERROR')
                                                                    <div class="d-flex align-items-center">
                                                                        <svg class="bi flex-shrink-0 me-2 text-danger"
                                                                            width="24" height="24" role="img"
                                                                            aria-label="Error:">
                                                                            <use xlink:href="#exclamation-triangle-fill" />
                                                                        </svg>
                                                                        <div>
                                                                            <strong class="text-danger">Failed!</strong>
                                                                            @if (isset($statusData['Response']))
                                                                                <br>Details:
                                                                                {{ htmlspecialchars($statusData['Response']) }}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div>
                                                                        <strong class="text-info">Status:</strong>
                                                                        {{ htmlspecialchars($statusData['Status']) }}
                                                                        @if (isset($statusData['Response']))
                                                                            <br><small>Response:
                                                                                {{ htmlspecialchars(is_string($statusData['Response']) ? $statusData['Response'] : json_encode($statusData['Response'])) }}</small>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div>
                                                            <strong class="text-warning">Status:</strong> Pending or
                                                            Unknown
                                                            <br><small>No status information available yet.</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar">
                                <table class="display basic-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Recipient</th>
                                            <th>Message</th>
                                            <th>Date Sent</th>
                                            <th>Status</th>
                                            <th>Sent By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($messages as $message)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="f-w-600 txt-primary">
                                                    {{ $message->member->first_name }}
                                                    {{ $message->member->last_name }}
                                                    <br>
                                                    <small class="text-muted">Member No:
                                                        {{ $message->member->membership_number }}</small>
                                                </td>
                                                <td class="text-primary f-w-500">
                                                    {{ $message->message }}
                                                </td>
                                                <td>{{ $message->created_at->format('M d, Y H:i') }}</td>
                                                <td>
                                                    @php
                                                        $statusData = json_decode($message->status, true);
                                                        if ($statusData && isset($statusData['Status'])) {
                                                            if ($statusData['Status'] === 'SUCCESS') {
                                                                echo '<span class="badge bg-success">Success</span>';
                                                            } elseif ($statusData['Status'] === 'ERROR') {
                                                                echo '<span class="badge bg-danger">Failed</span>';
                                                            } else {
                                                                echo '<span class="badge bg-secondary">' .
                                                                    htmlspecialchars($statusData['Status']) .
                                                                    '</span>';
                                                            }
                                                        } else {
                                                            echo '<span class="badge bg-warning">Pending</span>';
                                                        }
                                                    @endphp
                                                </td>
                                                <td> {{ $message->addedBy->first_name }}
                                                    {{ $message->addedBy->last_name }}
                                                    <br>
                                                </td>
                                                <td>
                                                    <small class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#viewMessageModal{{ $message->id }}">
                                                        View Details
                                                    </small>
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
@endsection
