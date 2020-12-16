@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Send Topup')

@push('css')
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
    @if( @OTIFSolutions\Laravel\Settings\Models\Setting::get('reloadly_api_token') && sizeof($countries) > 0)
        <div id="app">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header align-items-center">
                            <h4 class="card-title"><i class="feather icon-globe"></i> Send Topup</h4>
                        </div>
                        <send-topup int_input="{{ App\Models\Country::GetForInputField() }}" v-bind:token="'{{$token}}'"></send-topup>
                    </div>
                </div>
            </div>
        </div>
        @include('dashboard.layout.modals')
    @else
        <div class="card">
            <div class="card-header justify-content-center">
                <h4 class="card-title"><i class="feather icon-codepen"></i> Bulk Topup Sender</h4>
            </div>
            <div class="card-content pt-2">
                <div class="card-body">
                    <div class="row justify-content-center align-items-center">
                        <p class="col-auto">Please add API keys in settings to enable this module.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
