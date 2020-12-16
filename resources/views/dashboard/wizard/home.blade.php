@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Send Topup')

@push('css')
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="/css/pages/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="/css/pages/dropzone.min.css">
    <link rel="stylesheet" type="text/css" href="/css/pages/dropzone.css">
    <style>
        .dropzone{
            min-height: 200px;
        }
        .dropzone .dz-default.dz-message{
            width: 100%;
            margin-left: 0;
            left: 0;
            top: calc(50% - 37.5px);
            margin-top: 0;
            height: 75px;
        }
        .dropzone .dz-default.dz-message span{
            display: block;
            font-size: 70%;
        }
        .dropzone .dz-message::before{
            font-size: 35px;
            top: 30px;
        }
    </style>
@endpush

@section('content')
    <div class="row match-height justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header justify-content-center">
                    <h4 class="card-title"><i class="feather icon-download"></i> Download Template File</h4>
                </div>
                <div class="card-content pt-2 h-100">
                    <div class="card-body h-100">
                        <div class="row h-100 justify-content-center align-items-center">
                            <a href="#" data-toggle="modal-feed" data-target="#modal_sm" data-feed="/topups/bulk/wizard/template">
                                <div class="col-auto">
                                    <div class="row align-items-center justify-content-center">
                                        <h1 class="m-0"><i class="feather icon-file-text text-primary"></i></h1>
                                    </div>
                                    <div class="row align-items-center justify-content-center">
                                        <p>Download</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header justify-content-center">
                    <h4 class="card-title"><i class="feather icon-upload"></i> Upload Template File to Begin</h4>
                </div>
                <div class="card-content pt-2">
                    <div class="card-body">
                        <div id="dpz-single-file" class="dropzone text-center">
                            <div class="dz-default dz-message"><span>Drop CSV here to upload</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header justify-content-center align-items-center">
                        <h4 class="card-title"><i class="feather icon-file-text"></i> Files</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>Name</th>
                                        <th>Numbers</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($files as $file)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($file['created_at'])->format('Y-m-d H:m') }}</td>
                                            <td>{{ $file['original_name'] }}</td>
                                            <td>{{ sizeof($file['numbers']) }}</td>
                                            <td>
                                                @switch($file['status'])
                                                    @case('INVALID')
                                                        <span class="btn btn-sm round btn-danger" data-toggle="tooltip" data-original-title="Invalid File was uploaded." data-placement="right" data-trigger="click">Invalid File</span>
                                                    @break
                                                    @case('PROCESSING')
                                                        <span class="btn btn-sm round btn-secondary" data-toggle="tooltip" data-original-title="File is Being Processed." data-placement="right" data-trigger="click">Processing</span>
                                                    @break
                                                    @case('START')
                                                        <a class="btn btn-sm round btn-primary" href="/topups/bulk/wizard/start/file/{{$file['id']}}">Start</a>
                                                    @break
                                                    @case('DONE')
                                                        <span class="btn btn-sm round btn-success" data-toggle="tooltip" data-original-title="File was Scheduled Successfully." data-placement="right" data-trigger="click">Done</span>
                                                    @break
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>Name</th>
                                        <th>Numbers</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/js/dropzone.min.js"></script>
    <script src="/js/datatable/datatables.min.js"></script>
    <script src="/js/datatable/datatables.buttons.min.js"></script>
    <script src="/js/datatable/buttons.html5.min.js"></script>
    <script src="/js/datatable/buttons.print.min.js"></script>
    <script src="/js/datatable/buttons.bootstrap.min.js"></script>
    <script src="/js/datatable/datatables.bootstrap4.min.js"></script>
    <script>
        $('.zero-configuration').DataTable();
        Dropzone.autoDiscover = false;
        $("div#dpz-single-file").dropzone({
            paramName: "csv",
            url: '/file/upload',
            params: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            maxFiles: 1,
            uploadMultiple: false,
            acceptedFiles: '.csv',
            init: function () {
                this.on("maxfilesexceeded", function (file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
                this.on("success",function (file,response) {
                    if (response.message){
                        toastr.success(response.message);
                    }
                    if (response.location){
                        window.location = response.location;
                    }
                });
                this.on("error",function (file,response) {
                    $.each(response, function (key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function (key, value) {
                                toastr.error(value, 'Error');
                            });
                        }
                    });
                })
            }
        });
    </script>
@endpush
