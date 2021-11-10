@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Gift Cards')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/datatables.min.css">
    <style>
        .round-image{
            height: 60px;
            border-radius: 50%;
            width: 60px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header align-items-center">
                        <h4 class="card-title"><i class="feather icon-circle"></i> Gift Cards</h4>
                        @if(Auth::user()['user_role']['name'] == 'ADMIN')
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="change-status" data-msg="Are you sure you want to Sync Countries ?" data-feed="gift_cards/sync">Sync Now</button>
                        @endif
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Country</th>
                                        <th>Name</th>
                                        <th>Fee</th>
                                        <th>Discount %</th>
                                        <th>Is Global</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(Auth::user()->hasPermission('READ'))
                                        @foreach($products as $product)
                                            <tr>
                                                <td>{{ $product['id'] }}</td>
                                                <td>{{ $product['country']['name'] }}</td>
                                                <td><img class="round-image" src="{{$product['logo_urls'][0]}}"> {{ $product['title'] }}</td>
                                                <td>{{ $product['sender_fee']." ".$product['sender_currency_code'] }}</td>
                                                <td>{{ $product['discount_percentage']."%" }}</td>
                                                <td>{{ $product['is_global']?"YES":"NO" }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Country</th>
                                        <th>Name</th>
                                        <th>Fee</th>
                                        <th>Discount %</th>
                                        <th>Is Global</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('dashboard.layout.modals')
@endsection

@push('js')
    <script src="/js/datatable/pdfmake.min.js"></script>
    <script src="/js/datatable/vfs_fonts.js"></script>
    <script src="/js/datatable/datatables.min.js"></script>
    <script src="/js/datatable/datatables.buttons.min.js"></script>
    <script src="/js/datatable/buttons.html5.min.js"></script>
    <script src="/js/datatable/buttons.print.min.js"></script>
    <script src="/js/datatable/buttons.bootstrap.min.js"></script>
    <script src="/js/datatable/datatables.bootstrap4.min.js"></script>
    <script>
        $('.zero-configuration').DataTable();
    </script>
    <script src="/js/generic_change.js"></script>
@endpush
