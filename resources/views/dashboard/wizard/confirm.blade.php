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
    <section id="app" class="data-list-view-header">
        <number-table data-file-id="{{ $file['id'] }}" data-numbers="{{ $file['numbers'] }}" data-countries="{{ $countries }}"></number-table>
    </section>
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
