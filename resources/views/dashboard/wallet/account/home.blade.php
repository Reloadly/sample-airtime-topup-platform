@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Wallet')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/datatables.min.css">
@endpush

@section('content')
    <section>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header align-items-center">
                        <h4 class="card-title"><i class="fa fa-money"></i> Balance Activity</h4>
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal-feed" data-target="#modal_sm" data-feed="account/balance/add">Add Funds</button>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>TimeStamp</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Ending Balance</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($accountTransactions as $accountTransaction)
                                        <tr>
                                            <td>{{ $accountTransaction['created_at'] }}</td>
                                            <td>{{ $accountTransaction['type'] }}</td>
                                            <td>{{ number_format($accountTransaction['amount'],2).' '.strtoupper($accountTransaction['currency']) }}</td>
                                            <td>{{ $accountTransaction['description'] }}</td>
                                            <td>{{ number_format($accountTransaction['ending_balance'],2).' '.strtoupper($accountTransaction['currency']) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>TimeStamp</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Ending Balance</th>
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
    <script src="//js.stripe.com/v3/"></script>
@endpush
