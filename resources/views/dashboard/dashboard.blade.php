@extends('dashboard.layout.app')

@section('page-name','Dashboard')

@push('css')
@endpush


@section('body-class','2-column')

@section('content')

    @if(Auth::user()['user_role']['name'] == 'ADMIN')
        @include('dashboard.modules.admin-dashboard-stats')
    @else
        @include('dashboard.modules.client-dashboard-stats')
    @endif

@endsection

@push('js')
@endpush



