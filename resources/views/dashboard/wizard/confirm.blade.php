@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Send Topup')

@push('css')
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="/css/app/app.css">
    <link rel="stylesheet" type="text/css" href="/css/pages/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="/css/pages/data-list-view.min.css">
@endpush

@section('content')
    @if( @OTIFSolutions\Laravel\Settings\Models\Setting::get('reloadly_api_token') && sizeof($countries) > 0)
        <section id="app" class="data-list-view-header">
            <number-table token="{{ $token }}" data-file-id="{{ $file['id'] }}" data-numbers="{{ $file['numbers'] }}" data-countries="{{ $countries }}"></number-table>
        </section>
    @else
        <div class="card">
            <div class="card-header justify-content-center">
                <h4 class="card-title"><i class="feather icon-codepen"></i> Bulk Topup Sender</h4>
            </div>
            <div class="card-content pt-2">
                <div class="card-body">
                    <div class="row justify-content-center align-items-center">
                        <p class="col-auto">Please add API keys in settings to enable this module.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/js/app.js"></script>
    <script src="/js/datatable/pdfmake.min.js"></script>
    <script src="/js/datatable/vfs_fonts.js"></script>
    <script src="/js/datatable/datatables.min.js"></script>
    <script src="/js/datatable/datatables.buttons.min.js"></script>
    <script src="/js/datatable/buttons.html5.min.js"></script>
    <script src="/js/datatable/buttons.print.min.js"></script>
    <script src="/js/datatable/buttons.bootstrap.min.js"></script>
    <script src="/js/datatable/datatables.bootstrap4.min.js"></script>
    <script>
        window.dtView = $(".data-list-view").DataTable({
            paging:false,
            ordering: false,
            pagination: false,
            dom: 'rt',
            select: {
                style: "single"
            },
            order: [[1, "asc"]],
            bInfo: false
        });
    </script>
@endpush
