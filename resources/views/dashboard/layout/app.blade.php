<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
    <head>
        @include('dashboard.layout.head')
    </head>
    <body class="vertical-layout vertical-menu-modern semi-dark-layout navbar-floating footer-static @yield('body-class')" data-open="click" data-menu="vertical-menu-modern" data-layout="semi-dark-layout">
        @if(isset($page['type']) && $page['type'] == 'dashboard')
            @include('dashboard.layout.header')
            @include('dashboard.layout.sidebar')
        @endif
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    @yield('content')
                </div>
            </div>
        </div>
        @if(isset($page['type']) && $page['type'] == 'dashboard')
            <div class="sidenav-overlay"></div>
            <div class="drag-target"></div>
            @include('dashboard.layout.footer')
        @endif
        @include('dashboard.layout.js')

    </body>
</html>
