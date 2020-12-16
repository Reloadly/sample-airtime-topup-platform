@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Topups')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/datatables.min.css">
    <style>
        .modal-content{
            overflow: scroll !important;
            overflow-x: hidden !important;
        }
    </style>
@endpush

@section('content')
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header align-items-center">
                        <h4 class="card-title"><i class="feather icon-star"></i> {{$operator['name']}} Active Promotions</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Country</th>
                                        <th>Operator</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Denominations</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($promotions as $promotion)
                                        <tr>
                                            <td>{{ $promotion['id'] }}</td>
                                            <td>{{ $promotion['operator']['country']['name'] }}</td>
                                            <td>{{ $promotion['operator']['name'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($promotion['start_date'])->format('Y-m-d H:m') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($promotion['end_date'])->format('Y-m-d H:m') }}</td>
                                            <td>{{ $promotion['denominations'] }}</td>
                                            <td><button type="button" class="btn btn-xs btn-icon btn-outline-primary mr-1 waves-effect waves-light" data-toggle="modal-feed" data-target="#modal_lg" data-feed="/topups/promotions/{{ $promotion['id'] }}"><i class="feather icon-eye"></i></button></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Country</th>
                                        <th>Operator</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Denominations</th>
                                        <th>Actions</th>
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
@endpush
