@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name', $page['name'] )

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/datatables.min.css">
@endpush

@section('content')
    <section>
        <form class="form" action="{{ $page['url'] }}/{{ $reseller['id'] }}/rates" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $reseller['id'] }}">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header align-items-center">
                            <h4 class="card-title"><i class="{{ $page['icon'] }}"></i> {{ $page['name'] }}</h4>
                            <button type="submit" class="btn btn-primary waves-effect waves-light" >Save</button>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table class="table zero-configuration">
                                        <thead>
                                        <tr>
                                            <th>Country</th>
                                            <th>Operator</th>
                                            <th>International Discount</th>
                                            <th>Local Discount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($operators as $operator)
                                            <tr>
                                                <td>{{ $operator['country']['name'] }}</td>
                                                <td>{{ $operator['name'] }}</td>
                                                <td>
                                                    <input type="number" step="any" name="international_discount[]" class="form-control text-center" value="{{ $operator->pivot->international_discount }}">
                                                </td>
                                                <td>
                                                    <input type="hidden" name="operator_id[]" class="form-control text-center" value="{{ $operator['id'] }}">
                                                    <input type="number" step="any" name="local_discount[]" class="form-control text-center" value="{{ $operator->pivot->local_discount }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Country</th>
                                            <th>Operator</th>
                                            <th>International Discount</th>
                                            <th>Local Discount</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    @include('dashboard.layout.modals')
@endsection

@push('js')

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
