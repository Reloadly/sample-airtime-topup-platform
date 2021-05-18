@if(@OTIFSolutions\Laravel\Settings\Models\Setting::get('custom_theme')==true)
    @if(@OTIFSolutions\Laravel\Settings\Models\Setting::get('topbar_background_color'))
        <style>
            .header-navbar{
                background-color: #{{@OTIFSolutions\Laravel\Settings\Models\Setting::get('topbar_background_color')}} !important;
            }
        </style>
    @endif
    @if(@OTIFSolutions\Laravel\Settings\Models\Setting::get('sidebar_background_color'))
        <style>
            .main-menu, .menu-content, #main-menu-navigation, body.semi-dark-layout .main-menu-content .navigation-main .nav-item.open a{
                background-color: #{{@OTIFSolutions\Laravel\Settings\Models\Setting::get('sidebar_background_color')}} !important;
            }
            #main-menu-navigation .open a{
                background-color: #{{@OTIFSolutions\Laravel\Settings\Models\Setting::get('sidebar_background_color')}} !important;
            }
            body.semi-dark-layout .main-menu-content .navigation-main .sidebar-group-active a{
                background: #{{@OTIFSolutions\Laravel\Settings\Models\Setting::get('sidebar_background_color')}} !important;
            }
            .main-menu.menu-dark .navigation > li.active > a{
                background: linear-gradient(118deg, #{{@OTIFSolutions\Laravel\Settings\Models\Setting::get('sidebar_background_color')}}, #{{@OTIFSolutions\Laravel\Settings\Models\Setting::get('sidebar_background_color')}}) !important;
            }
        </style>
    @endif
    @if(@OTIFSolutions\Laravel\Settings\Models\Setting::get('sidebar_text_color'))
        <style>
            .menu-title{
                color: #{{@OTIFSolutions\Laravel\Settings\Models\Setting::get('sidebar_text_color')}} !important;
            }
        </style>
    @endif
    @if(@OTIFSolutions\Laravel\Settings\Models\Setting::get('icon_color'))
        <style>
            .feather, .fa{
                color: #{{@OTIFSolutions\Laravel\Settings\Models\Setting::get('icon_color')}} !important;
            }
        </style>
    @endif
    @if(@OTIFSolutions\Laravel\Settings\Models\Setting::get('mini_logo'))
        <style>
            .main-menu .navbar-header .navbar-brand .brand-logo {
                background : url({{@OTIFSolutions\Laravel\Settings\Models\Setting::get('mini_logo')}}) no-repeat !important;
                background-size: contain !important;
            }
        </style>
    @endif
    @if(@OTIFSolutions\Laravel\Settings\Models\Setting::get('ui_color'))
        <style>
            .btn-primary, .custom-switch-primary .custom-control-input:checked ~ .custom-control-label::before{
                background-color: #{{@OTIFSolutions\Laravel\Settings\Models\Setting::get('ui_color')}} !important;
            }
            .pagination .page-item.active .page-link{
                background-color: #{{@OTIFSolutions\Laravel\Settings\Models\Setting::get('ui_color')}} !important;
            }
            .btn-outline-primary{
                border: 1px solid #{{@OTIFSolutions\Laravel\Settings\Models\Setting::get('ui_color')}} !important;
            }
        </style>
    @endif
@endif
