@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Settings</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="#">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Settings</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="col-lg-12">
                <div class="page-content my-account__edit">
                    <div class="my-account__edit-form">
                    <div class="my-account__edit-form">
                        {{-- Global validation errors --}}
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <p class="alert alert-danger">{{ $error }}</p>
                            @endforeach
                        @endif

                        {{-- Session messages --}}
                        @if (Session::has('status'))
                            <p class="alert alert-success">{{ Session::get('status') }}</p>
                        @endif

                        {{-- Form 1: Update Profile Info --}}
                        <form name="account_info_form" action="{{ route('admin.update.details') }}" method="POST"
                            class="form-new-product form-style-1 needs-validation" novalidate="">
                            @csrf
                            @method('PUT')
                            <fieldset class="name">
                                <div class="body-title">Name <span class="tf-color-1">*</span></div>
                                <input class="flex-grow" type="text" placeholder="Full Name"
                                    name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            </fieldset>

                            <fieldset class="name">
                                <div class="body-title">Mobile Number <span class="tf-color-1">*</span></div>
                                <input class="flex-grow" type="text" placeholder="Mobile Number"
                                    name="mobile" value="{{ old('mobile', Auth::user()->mobile) }}" required>
                            </fieldset>

                            <fieldset class="name">
                                <div class="body-title">Email Address <span class="tf-color-1">*</span></div>
                                <input class="flex-grow" type="email" placeholder="Email Address"
                                    name="email" value="{{ old('email', Auth::user()->email) }}" required>
                            </fieldset>

                            <div class="my-3">
                                <button type="submit" class="btn btn-primary tf-button w208">Save Changes</button>
                            </div>
                        </form>

                        <hr class="my-5">

                        {{-- Form 2: Change Password --}}
                        <form name="password_change_form" action="{{ route('admin.update.password') }}" method="POST"
                            class="form-new-product form-style-1 needs-validation" novalidate="">
                            @csrf
                            @method('PUT')

                            <div class="my-3">
                                <h5 class="text-uppercase mb-0">Password Change</h5>
                            </div>

                            <fieldset class="name">
                                <div class="body-title pb-3">Old password <span class="tf-color-1">*</span></div>
                                <input class="flex-grow" type="password" placeholder="Old password"
                                    name="old_password" required>
                            </fieldset>

                            <fieldset class="name">
                                <div class="body-title pb-3">New password <span class="tf-color-1">*</span></div>
                                <input class="flex-grow" type="password" placeholder="New password"
                                    name="new_password" id="new_password" required>
                            </fieldset>

                            <fieldset class="name">
                                <div class="body-title pb-3">Confirm new password <span class="tf-color-1">*</span></div>
                                <input class="flex-grow" type="password" placeholder="Confirm new password"
                                    name="new_password_confirmation" data-cf-pwd="#new_password" required>
                                <div class="invalid-feedback">Passwords did not match!</div>
                            </fieldset>

                            <div class="my-3">
                                <button type="submit" class="btn btn-primary tf-button w208">Change Password</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection