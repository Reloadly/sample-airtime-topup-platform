@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Topups')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/datatables.min.css">
@endpush

@section('content')
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header align-items-center">
                        <h4 class="card-title"><i class="feather icon-star"></i> {{$country['name']}} Operators</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Logo</th>
                                        <th>Name</th>
                                        <th>Sender Currency</th>
                                        <th>Destination Currency</th>
                                        <th>Promotions </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($operators as $operator)
                                        <tr>
                                            <td>{{ $operator['id'] }}</td>
                                            <td><img src="{{ @$operator['logo_urls'][0] }}" alt="Logo" class="users-avatar-shadow" width="100" height="45"></td>
                                            <td>{{ $operator['name'] }}</td>
                                            <td>{{ $operator['sender_currency_symbol'] }}</td>
                                            <td>{{ $operator['destination_currency_symbol'] }}</td>
                                            @if(count($operator['promotions']))
                                                <td>
                                                    <a class="btn btn-xs btn-icon btn-outline-primary mr-1 waves-effect waves-light" href="/topups/operators/{{ $operator['id'] }}/promotions"><i class="feather icon-list"></i></a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Logo</th>
                                        <th>Name</th>
                                        <th>Sender Currency</th>
                                        <th>Destination Currency</th>
                                        <th>Promotions </th>
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
