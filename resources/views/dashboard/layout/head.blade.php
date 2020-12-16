<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<title>{{ env('APP_NAME') }} | @yield('page-name')</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
@if((@OTIFSolutions\Laravel\Settings\Models\Setting::get('custom_theme')==true) && (@OTIFSolutions\Laravel\Settings\Models\Setting::get('favicon')))
    <link rel="shortcut icon" type="image/png" href="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('favicon') }}">
@else
    <link rel="shortcut icon" type="image/png" href="{{ asset('/assets/images/icon.png') }}">
@endif

@include('dashboard.layout.css')
@include('dashboard.layout.adaptive_layout')
