@extends('layouts/staff-main')
@section('title', 'SaccoMax')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>New SMS Message</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-envelope-at" viewBox="0 0 16 16">
                                        <path
                                            d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z" />
                                        <path
                                            d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648m-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">SMS Message </li>
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
                            <form class="row g-3" method="POST" id="smsMessagesForm" action="{{ route('sms-messages.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-3 mb-3 col-md-12">
                                    <label class="col-sm-1 col-form-label" for="composeFrom">To :</label>
                                    <div class="col-sm-6">
                                        <select name="members[]" class="form-select select2" multiple="multiple"
                                            data-placeholder="Select Members" required>
                                            <option value="ALL">All Members</option>
                                            @foreach ($members as $member)
                                                <option value="{{ $member->id }}">
                                                    {{ $member->first_name . ' ' . $member->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-3 mb-3 col-md-12">
                                    <label class="col-sm-1 col-form-label" for="composeFrom">Message :</label>
                                    <div class="col-sm-6">
                                        <textarea name="message_body" id="message_body" class="form-control" rows="5" onkeyup="countChar(this)" required></textarea>
                                        <small id="charNum" class="text-primary"></small>
                                        <small class="txt-primary mt-2" style="float: right;">1 message = 160 characters</small><br>

                                        @error('message_body')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="row mt-3 mb-3 col-md-12">
                                    <label class="col-sm-1 col-form-label" for="composeFrom">Schedule :</label>
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="scheduleToggle"
                                                name="schedule_toggle" style=" width: 25px; height: 25px;">
                                        </div>
                                        <div id="scheduleFields" class="row mt-3" style="display: none;">
                                            <div class="col-sm-6">
                                                <input type="date" name="schedule_date" id="schedule_date"
                                                    class="form-control">
                                                @error('schedule_date')
                                                    <div class="form-text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="input-group">
                                                    <input type="time" name="schedule_time" id="schedule_time"
                                                        class="form-control">
                                                    <span class="input-group-text">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-clock"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                                            <path
                                                                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                @error('schedule_time')
                                                    <div class="form-text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <button class="btn btn-success" type="submit">Send Message</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scheduleToggle = document.getElementById('scheduleToggle');
            const scheduleFields = document.getElementById('scheduleFields');
            const scheduleDate = document.getElementById('schedule_date');

            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            scheduleDate.setAttribute('min', today);

            // Toggle schedule fields
            scheduleToggle.addEventListener('change', function() {
                if (this.checked) {
                    scheduleFields.style.display = 'block';
                } else {
                    scheduleFields.style.display = 'none';
                    scheduleDate.value = '';
                    document.getElementById('schedule_time').value = '';
                }
            });
        });
    </script>

    <script src="http://code.jquery.com/jquery-1.5.js"></script>
    <script>
        function countChar(val) {
            var len = val.value.length;
            $('#charNum').text("Characters: " + len);
        };
    </script>


@endsection
