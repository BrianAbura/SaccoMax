@extends('layouts/staff-main')
@section('title', 'SaccoMax')
@section('page-body')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Edit Member</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-people" viewBox="0 0 16 16">
                                        <path
                                            d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                                    </svg></a></li>
                            <li class="breadcrumb-item">Edit Member </li>
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
                            <form class="row g-3" method="POST" action="{{ route('members.update', $member->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mt-3">
                                    <div class="col-md-2">
                                        <label class="form-label" for="membership-number">Membership Number</label>
                                        <input class="form-control btn-pill" id="membership-number" name="membership_number"
                                            value="{{ $member->membership_number }}" type="text" placeholder="xxxx/xx/xx"
                                            aria-label="Membership Number" required>
                                        @error('membership_number')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="first-name">First Name</label>
                                        <input class="form-control btn-pill" id="first-name" name="first_name"
                                            value="{{ $member->first_name }}" type="text" placeholder="First Name"
                                            pattern="[A-Za-z ]*"
                                            onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"
                                            oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '')"
                                            aria-label="First Name" required>
                                        @error('first_name')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="last-name">Last Name</label>
                                        <input class="form-control btn-pill" id="last-name" name="last_name" type="text"
                                            pattern="[A-Za-z ]*"
                                            onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"
                                            oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '')"
                                            value="{{ $member->last_name }}" placeholder="Last Name" aria-label="Last Name"
                                            required>
                                        @error('last_name')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="validationDefault04">Gender</label>
                                        <select class="form-select btn-pill" id="validationDefault04" name="gender">
                                            <option selected="" disabled="" value="">Choose...</option>
                                            <option value="Male" {{ $member->gender == 'Male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="Female" {{ $member->gender == 'Female' ? 'selected' : '' }}>
                                                Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="validationDefault04">Nationality</label>
                                        <select class="form-select btn-pill" id="validationDefault04" name="nationality">
                                            <option selected="" disabled="" value="">Choose...</option>
                                            @foreach ($countires as $country)
                                                <option value="{{ $country->country_name }}"
                                                    {{ $country->country_name == $member->nationality ? 'selected' : '' }}>
                                                    {{ $country->country_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-2">
                                        <label class="form-label" for="phone-number">Phone Number</label>
                                        <input class="form-control btn-pill" id="phone-number" name="phone_number"
                                            type="tel" pattern="[0-9]*" maxlength="12"
                                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            value="{{ $member->phone_number }}" placeholder="256xxxxxxxxx"
                                            aria-label="Phone Number" required>
                                        @error('phone_number')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="exampleFormControlInput1">Email Address</label>
                                        <input class="form-control btn-pill" id="exampleFormControlInput1"
                                            name="email_address" value="{{ $member->email }}" type="email"
                                            placeholder="abc@abc.com" required>
                                        @error('email_address')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="exampleFormControlTextarea1">Physical
                                            Address</label>
                                        <textarea class="form-control btn-pill" id="exampleFormControlTextarea1" name="physical_address" rows="2">{{ $member->physical_address }}</textarea>
                                        @error('physical_address')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="employer-name">Employer's Name</label>
                                        <input class="form-control btn-pill" id="employer-name" name="employers_name"
                                            pattern="[A-Za-z ]*"
                                            onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"
                                            oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '')"
                                            value="{{ $member->employer }}" type="text" placeholder="Employer Name"
                                            aria-label="Employer name">
                                        @error('employers_name')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="employer-number">Employer's Phone Number</label>
                                        <input class="form-control btn-pill" id="employer-number" name="employers_number"
                                            value="{{ $member->employer_phone_number }}" type="tel" pattern="[0-9]*"
                                            maxlength="12"
                                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            placeholder="256xxxxxxxxx" aria-label="Employer Number">
                                        @error('Employer')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label" for="profile-picture">Profile Picture</label>
                                        <input class="form-control btn-pill" id="profile_picture" name="profile_picture"
                                            type="file" value="{{ $member->profile_picture }}">
                                        <small class="txt-primary mt-2">Format: jpeg,png,jpg</small><br>

                                        @if (!empty($member->profile_picture))
                                            <div class="text-small mt-3">
                                                <a href="{{ asset($member->profile_picture) }}" target="_blank"
                                                    class="b-r-8 img-5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-card-image" viewBox="0 0 16 16">
                                                        <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                                        <path
                                                            d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54L1 12.5v-9a.5.5 0 0 1 .5-.5z" />
                                                    </svg></i> View Profile
                                                </a>
                                            </div>
                                        @endif
                                        @error('profile_picture')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Update</button>
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
