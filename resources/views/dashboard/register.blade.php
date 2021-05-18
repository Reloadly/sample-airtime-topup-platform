@extends('dashboard.layout.app')

@section('body-class','1-column bg-full-screen-image  blank-page blank-page')
@section('page-name','Register')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/authentication.min.css">
@endpush

@section('content')
    <section class="row flexbox-container">
        <div class="col-xl-8 col-11 d-flex justify-content-center">
            <div class="card bg-authentication rounded-0 mb-0 w-100">
                <div class="row m-0">
                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center">
                        @if((@OTIFSolutions\Laravel\Settings\Models\Setting::get('custom_theme')==true) && (@OTIFSolutions\Laravel\Settings\Models\Setting::get('login_logo')))
                            <img src="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('login_logo') }}" class="w-100">
                        @else
                            <img src="/assets/images/logo.svg" class="w-100">
                        @endif
                    </div>
                    <div class="col-lg-6 col-12 p-0">
                        <div class="card rounded-0 mb-0 p-2">
                            <div class="card-header pt-50 pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Create Account</h4>
                                </div>
                            </div>
                            <p class="px-2">Fill the below form to create a new account.</p>
                            <div class="card-content">
                                <div class="card-body pt-0">
                                    <form action="/register" method="POST">
                                        @csrf
                                        <div class="form-label-group">
                                            <input type="text" id="inputName" class="form-control" placeholder="Name" name="name" required>
                                            <label for="inputName">Name</label>
                                        </div>
                                        <div class="form-label-group">
                                            <input type="text" id="inputUsername" class="form-control" placeholder="Username" name="username" required>
                                            <label for="inputUsername">Username</label>
                                        </div>
                                        <div class="form-label-group">
                                            <input type="email" id="inputEmail" class="form-control" placeholder="Email" name="email" required>
                                            <label for="inputEmail">Email</label>
                                        </div>
                                        <div class="form-label-group">
                                            <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="form-label-group">
                                            <input type="password" id="inputConfPassword" class="form-control" placeholder="Confirm Password" name="confirm_password" required>
                                            <label for="inputConfPassword">Confirm Password</label>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="accept_terms" checked>
                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                        <span class=""> I accept the terms & conditions.</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <a href="/login" class="btn btn-outline-primary float-left btn-inline mb-50">Login</a>
                                        <button type="submit" class="btn btn-primary float-right btn-inline mb-50">Register</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
@endpush
