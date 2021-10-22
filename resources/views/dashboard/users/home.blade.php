@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name', $page['name'] )

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/datatables.min.css">
@endpush

@section('content')
    <section>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header align-items-center">
                        <h4 class="card-title"><i class="{{ $page['icon'] }}"></i> {{ $page['name'] }}</h4>
                        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal-feed" data-target="#modal_sm" data-feed="{{ $page['url'] }}/-1">Add New</button>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Balance</th>
                                        <th>2FA</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user['name'] }}</td>
                                            <td>{{ $user['username'] }}</td>
                                            <td>{{ $user['email'] }}</td>
                                            <td>{{ @$user['balance'].' '.(isset($user['stripe_response']['currency'])?strtoupper($user['stripe_response']['currency']):'') }}</td>
                                            <td><button data-toggle="post-feed" data-feed="accounts/{{ $user['id'] }}/2fa/change" data-text="{{ $user['2fa_mode'] === 'ENABLED'?'Disable 2FA! Are you sure you want to do this ?':"<div class='row justify-content-center'><img src='".\App\Traits\GoogleAuthenticator::Make()->getQRCodeGoogleUrl(env('APP_NAME'),$user['2fa_secret'])."'></div><br>Please scan the QR code in the google authenticator app. You will be required to enter pin after this.<br><br> Enable 2FA ?" }}" class="btn btn-sm waves-effect waves-light {{ $user['2fa_mode'] === 'ENABLED'?'btn-danger':'btn-info' }}">{{ $user['2fa_mode']==='ENABLED'?'Disable':'Enable' }}</button></td>
                                            <td>
                                                @if($manage_rates)
                                                    <a type="button" class="btn btn-xs btn-icon btn-outline-primary mr-1 waves-effect waves-light" href="{{ $page['url'] }}/{{ $user['id'] }}/rates"><i class="feather icon-aperture"></i></a>
                                                @endif
                                                    <button type="button" class="btn btn-xs btn-icon btn-outline-primary mr-1 waves-effect waves-light" data-toggle="modal-feed" data-target="#modal_sm" data-feed="{{ $page['url'] }}/{{ $user['id'] }}"><i class="feather icon-edit"></i></button>
                                                <button type="button" class="btn btn-xs btn-icon btn-outline-danger waves-effect waves-light mt-1 mt-sm-0" data-toggle="delete-feed" data-feed="{{ $page['url'] }}/{{ $user['id'] }}"><i class="feather icon-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Balance</th>
                                        <th>2FA</th>
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
