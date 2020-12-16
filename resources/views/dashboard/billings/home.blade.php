@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Billings')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/datatables.min.css">
@endpush

@section('content')
    <section>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header align-items-center">
                        <h4 class="card-title"><i class="feather icon-credit-card"></i> Cards Attached</h4>
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal-feed" data-target="#modal_sm" data-feed="billings/stripe/add">Add New</button>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Card Details</th>
                                        <th>Expiry Date</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cards as $card)
                                        <tr>
                                            <td>{{ $card['name'] }}</td>
                                            <td>{{ $card['exp_month'].'/'.$card['exp_year'] }}</td>
                                            <td>
                                                <button type="button" class="btn btn-xs btn-icon btn-outline-danger waves-effect waves-light" data-toggle="delete-feed" data-feed="billings/stripe/{{ $card['id'] }}"><i class="feather icon-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Card Details</th>
                                        <th>Expiry Date</th>
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
    <script src="//js.stripe.com/v3/"></script>
@endpush
