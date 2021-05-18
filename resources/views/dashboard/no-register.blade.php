@extends('dashboard.layout.app')

@section('body-class','1-column bg-full-screen-image  blank-page blank-page')
@section('page-name','No Registration')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/authentication.min.css">
@endpush

@section('content')
    <section class="row flexbox-container">
        <div class="col-xl-8 col-11 d-flex justify-content-center">
            <div class="card bg-authentication rounded-0 mb-0 w-100">
                <div class="row m-0">
                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                        @if((@OTIFSolutions\Laravel\Settings\Models\Setting::get('custom_theme')==true) && (@OTIFSolutions\Laravel\Settings\Models\Setting::get('login_logo')))
                            <img src="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('login_logo') }}" class="w-100">
                        @else
                            <img src="/assets/images/logo.svg" class="w-100">
                        @endif
                    </div>
                    <div class="col-lg-6 col-12 p-0" style="border-left: 1px solid gray;">
                        <div class="card rounded-0 mb-0 px-2">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Registration Not Allowed</h4>
                                </div>
                            </div>
                            <p class="px-2">Hi,</p>
                            <p class="px-2">We are sorry! Registration not allowed right now.</p>
                            <p class="px-2">Thanks</p>
                            <a href="/login" class=" col-4 col-md-3 btn btn-outline-primary float-left btn-inline mb-50">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
@endpush
