@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Wallet Transfer')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/app/app.css">
@endpush

@section('content')
    <section>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header align-items-center">
                        <h4 class="card-title"><i class="fa fa-circle"></i> Wallet To Wallet Transfer</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard" id="app">
                            <wallet-transfer v-bind:currency="'{{$currency}}'"
                            ></wallet-transfer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('dashboard.layout.modals')
@endsection

@push('js')

    <script src="/js/app.js"></script>
@endpush
