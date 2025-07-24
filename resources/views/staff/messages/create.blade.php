@extends('layouts/staff-main')
@section('title', 'SaccoMax')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>New Message</h4>
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
                            <li class="breadcrumb-item">Message </li>
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
                            <form class="row g-3" method="POST" id="messagesForm" action="{{ route('messages.store') }}"
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
                                    <label class="col-sm-1 col-form-label" for="composeFrom">Subject :</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" id="composeFrom" type="text" name="subject" required>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-3 col-md-12">
                                    <label class="col-sm-1 col-form-label" for="composeFrom">Message :</label>
                                    <div class="col-sm-6">
                                        <div class="toolbar-box">
                                            <div id="toolbar7"><span class="ql-formats">
                                                    <select class="ql-size">
                                                        <option value="small">Small</option>
                                                        <option selected="">Normal</option>
                                                        <option value="large">Large</option>
                                                        <option value="huge">Huge</option>
                                                    </select></span><span class="ql-formats">
                                                    <button class="ql-bold">Bold</button>
                                                    <button class="ql-italic">Italic</button>
                                                    <button class="ql-underline">Underline</button>
                                                    <button class="ql-list" value="ordered">List</button>
                                                    <button class="ql-list" value="bullet">Bullet</button>
                                            </div>
                                            <div class="quill-paragraph" id="editor7">
                                            </div>
                                            @error('message_body')
                                                <div class="form-text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <textarea name="message_body" id="message_body" style="display:none;"></textarea>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-3 col-md-12">
                                    <label class="col-sm-1 col-form-label" for="composeFrom">Attachment :</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" id="message_file" name="message_file" type="file">
                                        <small class="txt-primary mt-2">Format: jpeg, png, jpg, pdf, doc/x, xls/x (Max: 2MB)</small>
                                        @error('message_file')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-success" type="submit">Send</button>
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
