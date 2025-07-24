@extends('layouts/staff-main')
@section('title', 'SaccoMax')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>My Profile</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-people" viewBox="0 0 16 16">
                                        <path
                                            d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">My Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="user-profile">
                <div class="row">
                    <!-- user profile first-style start-->
                    <div class="col-sm-12">
                        <div class="card hovercard text-center mt-3">
                            <div class="user-image mt-5">
                                <div class="avatar">
                                    @if (!empty($member->profile_picture))
                                        <img alt="" src="{{ asset($member->profile_picture) }}">
                                    @else
                                        <img alt="" src="{{ asset('assets/images/logo/upplogo-nobg.png') }}">
                                    @endif
                                </div>
                            </div>
                            <div class="info">
                                <div class="row">
                                    <div class="col-sm-6 col-lg-4 order-sm-1 order-xl-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="ttl-info text-start">
                                                    <h6 class="mb-2"><i class="fa fa-envelope"></i>   Email</h6>
                                                    <span class="txt-info"> {{ $member->email }} </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="ttl-info text-start">
                                                    <h6 class="mb-2"><i class="fa fa-user"></i>   Gender</h6><span
                                                        class="txt-info">{{ $member->gender }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 order-sm-0 order-xl-1">
                                        <div class="user-designation">
                                            <div class="title"><a target="_blank" href=""
                                                    class="txt-info">{{ $member->first_name . ' ' . $member->last_name }}</a>
                                            </div>
                                            <div class="desc txt-primary">{{ $member->membership_number }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4 order-sm-2 order-xl-2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="ttl-info text-start">
                                                    <h6 class="mb-2"><i class="fa fa-phone"></i>   Phone Number</h6><span
                                                        class="txt-info">{{ $member->phone_number }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="ttl-info text-start">
                                                    <h6 class="mb-2"><i class="fa fa-location-arrow"></i>   Physical
                                                        Address</h6><span
                                                        class="txt-info">{{ $member->physical_address }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="ttl-info text-start">
                                            <h6 class="mb-2"><i class="fa fa-flag"></i>   Nationality</h6>
                                            <span class="txt-info"> {{ $member->nationality }} </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="ttl-info text-start">
                                            <h6 class="mb-2"><i class="fa fa-user"></i>   Employer</h6><span
                                                class="txt-info">{{ $member->employer }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="ttl-info text-start">
                                            <h6 class="mb-2"><i class="fa fa-phone"></i>   Employer Number</h6>
                                            <span class="txt-info">{{ $member->employer_phone_number }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="ttl-info text-start">
                                            <h6 class="mb-2"><i class="fa fa-gears"></i>   Actions</h6>
                                            <ul class="d-flex list-unstyled gap-2">
                                                <li>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#changePassword">Change Password</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- De-activate Account start --}}
                        <div class="modal fade" id="changePassword" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenter1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    {{-- Alerts for the home page --}}
                                    @if (session('success'))
                                        <div class="alert alert-light-success alert-dismissible fade show mx-auto mt-2"
                                            role="alert">
                                            <p class="txt-info"> {{ session('success') }}</p>
                                            <button class="btn-close" type="button" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                var changePasswordModal = new bootstrap.Modal(document.getElementById('changePassword'));
                                                changePasswordModal.show();
                                            });
                                        </script>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-light-secondary alert-dismissible fade show mx-auto mt-2"
                                            role="alert">
                                            <p class="txt-info"> {{ session('error') }}</p>
                                            <button class="btn-close" type="button" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                var changePasswordModal = new bootstrap.Modal(document.getElementById('changePassword'));
                                                changePasswordModal.show();
                                            });
                                        </script>
                                    @endif
                                    {{-- Alerts for the home page --}}
                                    <div class="modal-body">
                                        <form class="theme-form" method="POST" action="{{ route('change_password') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label class="col-form-label">New Password</label>
                                                <div class="form-input position-relative">
                                                    <input class="form-control" type="password" name="password"
                                                        required="" placeholder="Enter your password"
                                                        autocomplete="off">
                                                    @error('password')
                                                        <div class="form-text text-warning">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="form-group mt-2">
                                                <label class="col-form-label">Confirm Password</label>
                                                <div class="form-input position-relative">
                                                    <input class="form-control" type="password"
                                                        name="password_confirmation" required=""
                                                        placeholder="Retype your password" autocomplete="off">
                                                    @error('password_confirmation')
                                                        <div class="form-text text-warning">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group mt-4">
                                                <button class="btn btn-primary btn-md btn-block w-100"
                                                    type="submit">Change
                                                    Password</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Deactivate Account end --}}
                        {{-- Activate Account start --}}
                        <div class="modal fade" id="activateAccount" tabindex="-1" role="dialog"
                            aria-labelledby="activateAccount" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="modal-toggle-wrapper">
                                            <ul class="modal-img">
                                                <li> <img src="../assets/images/gif/dashboard-8/successful.gif"
                                                        alt="error"></li>
                                            </ul>
                                            <h4 class="text-center pb-1 txt-success">Account Activation</h4>
                                            <p class="text-center">Activating
                                                <strong>{{ $member->first_name . ' ' . $member->last_name }}'s</strong>
                                                account will grant the member access to their profile, data, and
                                                any
                                                associated
                                                services.
                                            </p>
                                            <form action="{{ route('members.change_status', $member->id) }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="1">
                                                <button class="btn btn-success d-flex m-auto" type="submit"
                                                    data-bs-dismiss="modal">Proceed</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Activate Account end --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends -->
    </div>
@endsection
