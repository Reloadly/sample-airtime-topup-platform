@extends('dashboard.layout.app')

@section('body-class','1-column bg-full-screen-image  blank-page blank-page')
@section('page-name','Login')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/authentication.min.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css"/>
    <style>
        .iti{
            display: block !important;
        }
    </style>
    @if(@OTIFSolutions\Laravel\Settings\Models\Setting::get('reloadly_api_token') && sizeof($countries) > 0)
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link rel="stylesheet" type="text/css" href="/css/app/app.css">
    @endif
@endpush

@section('content')
    <section class="row flexbox-container ">
        <div class="col-xl-8 col-11 d-flex justify-content-center">
            <div class="row justify-content-center w-100">
                <div class="col-md-6 col-12">
                    <div id="app">
                        <div class="card">
                            <div class="card-header align-items-center">
                                <h4 class="card-title"><i class="feather icon-globe"></i> Send Topup</h4>
                            </div>
                            <send-topup int_input="{{ App\Models\Country::GetForInputField() }}" send="{{$send}}" v-bind:token="'{{$token}}'"></send-topup>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    @if(@OTIFSolutions\Laravel\Settings\Models\Setting::get('reloadly_api_token') && sizeof($countries) > 0)
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="/js/app.js"></script>

        <script>
            $(document).on('click','a[href="#tabs-amount"]',function(){
                $('#select_amount').attr('disabled',false);
            });
        </script>
    @endif
@endpush
