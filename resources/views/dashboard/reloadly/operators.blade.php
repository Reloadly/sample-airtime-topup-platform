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
                        <h4 class="card-title"><i class="feather icon-star"></i> Operators</h4>
                        @if(Auth::user()['user_role']['name'] == 'ADMIN')
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="change-status" data-msg="Are you sure you want to Sync Operators ?" data-feed="operators/sync">Sync Now</button>
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
                                        <th>Sender Currency</th>
                                        <th>Destination Currency</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($operators as $operator)
                                        <tr>
                                            <td>{{ $operator['id'] }}</td>
                                            <td>{{ $operator['country']['name'] }}</td>
                                            <td>{{ $operator['name'] }}</td>
                                            <td>{{ $operator['sender_currency_symbol'] }}</td>
                                            <td>{{ $operator['destination_currency_symbol'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Country</th>
                                        <th>Name</th>
                                        <th>Sender Currency</th>
                                        <th>Destination Currency</th>
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
