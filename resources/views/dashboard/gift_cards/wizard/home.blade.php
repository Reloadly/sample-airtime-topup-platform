@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Send Topup')

@push('css')
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="/css/app/app.css">
@endpush

@section('content')
    <div id="app">
        <gifts-wizard _countries="{{ @$countries }}" _customer_rate="{{$customerRate}}" _token="{{$token}}"></gifts-wizard>
    </div>
@endsection

@push('js')
    <script src="/js/app.js"></script>
@endpush
