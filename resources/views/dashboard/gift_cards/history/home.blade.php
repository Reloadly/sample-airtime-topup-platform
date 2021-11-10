
@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','History')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@section('content')
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header justify-content-center align-items-center">
                        <h4 class="card-title"><i class="feather icon-box"></i> Transaction History</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>Gift Card</th>
                                        <th>Amount</th>
                                        <th>Bill Amount</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($transaction['created_at'])->format('Y-m-d H:i') }}</td>
                                            <td>{{ $transaction['product']['title'] }}</td>
                                            <td>{{ number_format($transaction['recipient_amount'],2).' '.$transaction['recipient_currency']['abbr'] }}</td>
                                            <td>{{ number_format($transaction['sender_amount'],2).' '.$transaction['sender_currency']['abbr'] }}</td>
                                            <td>
                                                @switch($transaction['status'])
                                                    @case('PENDING')
                                                        <div class="badge badge-pill badge-primary">Pending</div>
                                                    @break
                                                    @case('SUCCESS')
                                                        <button class="badge badge-pill badge-success" data-toggle="modal-feed" data-target="#modal_lg" data-feed="history/{{ $transaction['id'] }}/success">Success</button>
                                                    @break
                                                    @case('FAIL')
                                                        @if(\Illuminate\Support\Facades\Auth::user()['user_role']['id'] == 1)
                                                            <button class="btn btn-sm round btn-danger" data-toggle="modal-feed" data-target="#modal_lg" data-feed="history/{{ $transaction['id'] }}/failed">Failed</button>
                                                        @else
                                                            <div class="badge badge-pill badge-danger">Failed</div>
                                                        @endif
                                                    @break
                                                    @case('PENDING_PAYMENT')
                                                        <div class="badge badge-pill badge-secondary">Pending Payment</div>
                                                    @break
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>Gift Card</th>
                                        <th>Amount</th>
                                        <th>Bill Amount</th>
                                        <th>Status</th>
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
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $('.zero-configuration').DataTable();
    </script>
@endpush
