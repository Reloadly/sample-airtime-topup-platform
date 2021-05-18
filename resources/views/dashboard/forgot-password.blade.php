@extends('dashboard.layout.app')

@section('body-class','1-column bg-full-screen-image  blank-page blank-page')
@section('page-name','Forgot Password')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/authentication.css">
{{--    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">--}}
@endpush

@section('content')
    <section class="row flexbox-container">
        <div class="col-xl-8 col-11 d-flex justify-content-center">
            <div class="card rounded-0 mb-0 bg-authentication w-100">
                <div class="row m-0">
                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center">
                        @if((@OTIFSolutions\Laravel\Settings\Models\Setting::get('custom_theme')==true) && (@OTIFSolutions\Laravel\Settings\Models\Setting::get('login_logo')))
                            <img src="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('login_logo') }}" class="w-100">
                        @else
                            <img src="/assets/images/logo.svg" class="w-100">
                        @endif
                    </div>
                    <div class="col-lg-6 col-12 p-0">
                        <div class="card rounded-0 mb-0 px-2 py-1">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Recover your password</h4>
                                </div>
                            </div>
                            <p class="px-2 mb-0">Please enter your email address and we'll send you instructions on how to reset your password.</p>
                            <div class="card-content">
                                <div class="card-body">
                                    <form action="/forgot/password" method="POST">
                                        @csrf
                                        <div class="form-label-group">
                                            <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email">
                                            <label for="inputEmail">Email</label>
                                        </div>

                                        <div class="float-md-left d-block mb-1">
                                            <a href="/login" class="btn btn-outline-primary btn-block px-75 waves-effect waves-light">Back to Login</a>
                                        </div>
                                        <div class="float-md-right d-block mb-1">
                                            <button type="submit" class="btn btn-primary btn-block px-75 waves-effect waves-light">Recover Password <i class="fa fa-spinner fa-spin d-none"></i></button>
                                        </div>
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
