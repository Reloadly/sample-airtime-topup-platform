@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Invoices')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/datatables.min.css">
@endpush

@section('content')
    <section>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header align-items-center">
                        <h4 class="card-title"><i class="feather icon-file-text"></i> Invoices</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>ID</th>
                                        <th>Amount</th>
                                        <th>#Topups</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invoices as $invoice)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($invoice['created_at'])->format('Y-m-d H:m') }}</td>
                                            <td>{{ $invoice['id'] }}</td>
                                            <td>{{ number_format($invoice['amount'],2).' '.$invoice['currency_code'] }}</td>
                                            <td>
                                                @if($invoice['type'] === 'Topup')
                                                <button class="btn btn-sm round btn-primary" data-toggle="modal-feed" data-target="#modal_lg" data-feed="invoices/{{ $invoice['id'] }}/numbers">View Number</button>
                                                @endif
                                            </td>
                                            <td>
                                                @switch($invoice['status'])
                                                    @case('PENDING')
                                                        @if(Auth::user()['user_role']['name'] == 'ADMIN')
                                                            <button class="btn btn-sm round btn-primary" data-toggle="paid-feed" data-target="#modal_lg" data-feed="invoices/{{ $invoice['id'] }}/mark_paid">Pending</button>
                                                        @else
                                                            <div class="badge badge-pill badge-primary">Pending</div>
                                                        @endif
                                                    @break
                                                    @case('PAID')
                                                        <div class="badge badge-pill badge-success">Paid</div>
                                                    @break
                                                    @case('FAIL')
                                                        @if(Auth::user()['user_role']['name'] == 'ADMIN')
                                                            <button class="btn btn-sm round btn-danger" data-toggle="paid-feed" data-target="#modal_lg" data-feed="invoices/{{ $invoice['id'] }}/mark_paid">Failed</button>
                                                        @else
                                                            <div class="badge badge-pill badge-danger">Failed</div>
                                                        @endif
                                                    @break
                                                    @case('PROCESSING')
                                                        <div class="badge badge-pill badge-success">Processing</div>
                                                    @break
                                                    @case('CANCELLED')
                                                        <div class="badge badge-pill badge-secondary">Cancelled</div>
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <a class="btn btn-xs btn-icon btn-outline-primary mr-1 waves-effect waves-light" href="invoices/view/{{ $invoice['id'] }}"><i class="feather icon-eye"></i></a>
                                                <a class="btn btn-xs btn-icon btn-outline-primary mr-1 waves-effect waves-light" target="_blank" href="invoices/print/{{ $invoice['id'] }}"><i class="feather icon-printer"></i></a>
                                                @if(Auth::user()['user_role']['name'] === 'ADMIN')
                                                <button type="button" class="btn btn-xs btn-icon btn-outline-primary mr-1 waves-effect waves-light" data-toggle="modal-feed" data-target="#modal_sm" data-feed="invoices/{{ $invoice['id'] }}"><i class="feather icon-edit"></i></button>
                                                <button type="button" class="btn btn-xs btn-icon btn-outline-danger waves-effect waves-light" data-toggle="delete-feed" data-feed="invoices/{{ $invoice['id'] }}"><i class="feather icon-trash"></i></button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>ID</th>
                                        <th>Amount</th>
                                        <th># Topups</th>
                                        <th>Status</th>
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
    <script>
        $(document).on('click', '[data-toggle="paid-feed"]', function (e) {
            e.preventDefault();
            let url = $(this).attr('data-feed');
            let title = $(this).attr('data-title');
            let text = $(this).attr('data-text');
            swal.fire({
                title: title?title:'Are you sure?',
                html: text?text:'Do you want mark this invoice paid?',
                type: 'warning',
                showCancelButton: !0,
                confirmButtonText: 'Yes, Do it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: !0

            }).then(function (e) {
                if (e.value) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {},
                        error: function (response) {
                            response = $.parseJSON(response.responseText);
                            $.each(response, function (key, value) {
                                if ($.isPlainObject(value)) {
                                    $.each(value, function (key, value) {
                                        toastr.error(value, 'Error');
                                    });
                                }
                            });
                        },
                        success: function (response) {
                            if (response.message) {
                                toastr.success(response.message, 'Success');
                            } else {
                                toastr.success('All Done', 'Success');
                            }
                            if (response.location)
                                window.location = response.location;
                        }
                    });
                }
            });
        });
    </script>
@endpush
