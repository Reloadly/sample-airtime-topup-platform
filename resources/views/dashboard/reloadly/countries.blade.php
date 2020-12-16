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
                        <h4 class="card-title"><i class="feather icon-star"></i> Countries</h4>
                        @if(Auth::user()['user_role']['name'] == 'ADMIN')
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="change-status" data-msg="Are you sure you want to Sync Countries ?" data-feed="countries/sync">Sync Now</button>
                        @endif
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Flag</th>
                                        <th>ISO</th>
                                        <th>Name</th>
                                        <th>Currency</th>
                                        <th>Calling Codes</th>
                                        <th>Operators</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($countries as $country)
                                        <tr>
                                            <td>{{ $country['id'] }}</td>
                                            <td><img src="{{ $country['flag'] }}" alt="Flag" class="users-avatar-shadow" width="50" height="30"></td>
                                            <td>{{ $country['iso'] }}</td>
                                            <td>{{ $country['name'] }}</td>
                                            <td>{{ $country['currency_symbol'] }}</td>
                                            <td>{{ @$country['calling_codes'][0] }}</td>
                                            <td>
                                                <a class="btn btn-xs btn-icon btn-outline-primary mr-1 waves-effect waves-light" href="countries/{{ $country['id'] }}/operators"><i class="feather icon-list"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Flag</th>
                                        <th>ISO</th>
                                        <th>Name</th>
                                        <th>Currency</th>
                                        <th>Calling Codes</th>
                                        <th>Operators</th>
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
