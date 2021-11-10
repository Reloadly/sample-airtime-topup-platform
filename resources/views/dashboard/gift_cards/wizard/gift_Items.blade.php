@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Send Topup')

@push('css')
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="/css/app/app.css">
    <style>
        @keyframes slideInFromLeft {
            0% {
                transform: translateY(-100%);
            }
            100% {
                transform: translateY(0);
            }
        }

        #biller-form {
            animation: 1s ease-out 0s 1 slideInFromLeft;
            padding: 30px;
        }
    </style>
@endpush

@section('content')
    <div id="app">
        <gift-items _gift_card="{{ $gift_card }}" _customer_rate="{{$customerRate}}" _token="{{ $token }}"></gift-items>
    </div>
@endsection

@push('js')
    <script src="/js/app.js"></script>
@endpush
