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
                        <h4 class="card-title"><i class="fa fa-circle"></i> Whitelisted IP Address</h4>
                        <div>
                            <button data-toggle="post-feed" data-feed="/ip_restriction/status/change" data-text="{{ Auth::user()['ip_restriction'] === 'ENABLED'?'Disable Ip Restriction! Are you sure you want to do this ?':"<div class='row justify-content-center'><b>You will be locked out if you do not add your correct Ip Address and Enable This</b><br><br> Enable IP Restriction ?" }}" class="btn btn-info mr-75 waves-effect waves-light">{{ @Auth::user()['ip_restriction']==='ENABLED'?'Disable IP Restriction':'Enable IP Restriction' }}</button>
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal-feed" data-target="#modal_sm" data-feed="/ip_restriction/-1">Add New</button>
                        </div>

                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>IP</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($ips as $ip)
                                    <tr>
                                        <td>{{ $ip['ip'] }}</td>
                                        <td>
                                            <button type="button" class="btn btn-xs btn-icon btn-outline-primary mr-1 waves-effect waves-light" data-toggle="modal-feed" data-target="#modal_sm" data-feed="/ip_restriction/{{ $ip['id'] }}"><i class="feather icon-edit"></i></button>
                                            <button type="button" class="btn btn-xs btn-icon btn-outline-danger waves-effect waves-light mt-1 mt-sm-0" data-toggle="delete-feed" data-feed="/ip_restriction/{{ $ip['id'] }}"><i class="feather icon-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>IP</th>
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

@endpush
