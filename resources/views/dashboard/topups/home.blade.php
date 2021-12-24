@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Topups')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@section('content')
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header justify-content-between align-items-center">
                        <h4 class="card-title"><i class="feather icon-codepen"></i> Topup History</h4>
                        <div class="col">
                            <div class="row justify-content-end align-items-center">
                                <h5 class="mb-0">Status : </h5>
                                <div class="col-auto pr-0">
                                    <select class="form-control" name="status">
                                        <option value="all" {{ isset($_GET['status']) && $_GET['status'] === "All" ? 'selected' : '' }}>All</option>
                                        <option value="SUCCESS" {{ isset($_GET['status']) && $_GET['status'] === "SUCCESS" ? 'selected' : '' }}>Success</option>
                                        <option value="PENDING" {{ isset($_GET['status']) && $_GET['status'] === "PENDING" ? 'selected' : '' }}>Pending</option>
                                        <option value="FAIL" {{ isset($_GET['status']) && $_GET['status'] === "FAIL" ? 'selected' : '' }}>Failed</option>
                                        <option value="REFUNDED" {{ isset($_GET['status']) && $_GET['status'] === "REFUNDED" ? 'selected' : '' }}>Refunded</option>
                                    </select>
                                </div>
                                <div class="col-auto pr-0">
                                    <button id="reportrange" class="btn btn-secondary">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <i class="fa fa-caret-down"></i>
                                    </button>
                                </div>
                                <div class="col-auto">
                                    <button id="filter" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>Topup ID</th>
                                        <th>Is Local</th>
                                        <th>Operator</th>
                                        <th>Number</th>
                                        <th>Amount</th>
                                        <th>Local Amount</th>
                                        @if(\Illuminate\Support\Facades\Auth::user()['user_role_id'] === 1 OR \Illuminate\Support\Facades\Auth::user()['user_role_id'] === 2)
                                            <th>Discount Amount</th>
                                        @endif
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($topups as $topup)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($topup['created_at'])->format('Y-m-d H:m') }}</td>
                                        <td>{{ $topup['id'] }}</td>
                                        <td>
                                            @if($topup['is_local'])
                                                <div class="badge badge-pill badge-warning pl-1 pr-1">Yes</div>
                                            @else
                                                <div class="badge badge-pill badge-primary pl-1 pr-1">No</div>
                                            @endif
                                        </td>
                                        <td>{{ $topup['operator']['name'] }}</td>
                                        <td>{{ $topup['number'] }}</td>
                                        <td>{{ number_format($topup['amount'],2).' '.$topup['sender_currency'] }}</td>
                                        <td>{{ number_format($topup['topup'],2).' '.$topup['receiver_currency'] }}</td>
                                        @if(\Illuminate\Support\Facades\Auth::user()['user_role_id'] === 1 OR \Illuminate\Support\Facades\Auth::user()['user_role_id'] === 2)
                                            <td>
                                                @if($topup['discount_transaction'])
                                                    {{$topup['discount_transaction']['amount']." ".$topup['discount_transaction']['currency']}}
                                                @else
                                                    ---
                                                @endif
                                            </td>
                                        @endif
                                        <td>
                                            @switch($topup['status'])
                                                @case('PENDING')
                                                <div class="badge badge-pill badge-primary">Pending</div>
                                                @break
                                                @case('SUCCESS')
                                                    @if(isset($topup['pin']) && sizeof($topup['pin']) > 0)
                                                        <button class="btn btn-sm round btn-success" data-toggle="modal-feed" data-target="#modal_lg" data-feed="history/{{ $topup['id'] }}/pin_detail">Pin Available</button>
                                                    @else
                                                        <div class="badge badge-pill badge-success">Success</div>
                                                    @endif
                                                @break
                                                @case('FAIL')
                                                <button class="btn btn-sm round btn-danger" data-toggle="modal-feed" data-target="#modal_lg" data-feed="history/{{ $topup['id'] }}/failed">Failed</button>
                                                @if(Auth::user()['user_role']['name'] == 'ADMIN')
                                                    <button class="btn btn-sm round btn-warning" data-toggle="retry-feed" data-target="#modal_lg" data-feed="{{ $topup['id'] }}/retry">Retry</button>
                                                @endif
                                                @break
                                                @case('PENDING_PAYMENT')
                                                <div class="badge badge-pill badge-secondary">Pending Payment</div>
                                                @break
                                                @case('REFUNDED')
                                                <button class="btn btn-sm round btn-black" data-toggle="modal-feed" data-target="#modal_lg" data-feed="history/{{ $topup['id'] }}/failed">Refunded</button>
                                                @break
                                            @endswitch
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>Topup ID</th>
                                        <th>Is Local</th>
                                        <th>Operator</th>
                                        <th>Number</th>
                                        <th>Amount</th>
                                        <th>Local Amount</th>
                                        @if(\Illuminate\Support\Facades\Auth::user()['user_role_id'] === 1 OR \Illuminate\Support\Facades\Auth::user()['user_role_id'] === 2)
                                            <th>Discount Amount</th>
                                        @endif
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
        $('.zero-configuration').DataTable({
            dom: "B<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    </script>
    <script>
        $(document).on('click', '[data-toggle="retry-feed"]', function (e) {
            e.preventDefault();
            let url = $(this).attr('data-feed');
            let title = $(this).attr('data-title');
            let text = $(this).attr('data-text');
            swal.fire({
                title: title?title:'Are you sure?',
                html: text?text:'Do you want to retry sending topup?',
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
    <script type="text/javascript">
        $(function() {

            var start = {!! isset($_GET['start'])?"moment('".$_GET['start']."')":"moment().startOf('month')"  !!};
            var end = {!! isset($_GET['end'])?"moment('".$_GET['end']."')":"moment().endOf('month')"  !!};

            function cb(s, e) {
                start = s;
                end = e;
                $('#reportrange span').html(start.format('MMM D') + ' - ' + end.format('MMM D'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

            $('#filter').click(function () {
                window.location = 'history?start='+start.format('YYYY-MM-DD')+'&end='+end.format('YYYY-MM-DD')+'&status='+$('select[name="status"]').val();
            });

        });
    </script>

@endpush
