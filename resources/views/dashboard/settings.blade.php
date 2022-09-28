@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Settings')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/sweetalert2.min.css">
    <link href="/app-assets/color_picker/css/bootstrap-colorpicker.css" rel="stylesheet" type="text/css"/>
    <style>
        .custom-control.custom-switch p{
            color: rgba(34, 41, 47, 0.4) !important;
            -webkit-transition: all 0.25s ease-in-out;
            transition: all 0.25s ease-in-out;
            opacity: 1;
            padding: 0.25rem 0;
            font-size: 0.7rem;
            top: -22px;
            left: -5px;
            position: absolute;
            display: block;
            pointer-events: none;
            cursor: text;
            margin-bottom: 0;
        }
        .custom-control.custom-switch .custom-control-label{
            margin-top: 0.4rem;
        }
        .navigation-setting-heading{
            padding-right: 20px;
        }
        .navigation-setting-link{
            font-size: 1.05rem !important;
        }
        .save-btn{
            position: absolute;
            right: 2%;
        }
        .colorpicker-element{
            padding-left: 0;
        }
        .colorpicker-input-addon{
            width: 40px;
        }
        .colorpicker-input-addon i{
            width: 100%;
            height: 100%;
        }

    </style>
    <link rel="stylesheet" type="text/css" href="/css/pages/dropzone.min.css">
    <link rel="stylesheet" type="text/css" href="/css/pages/dropzone.css">
@endpush

@section('content')
    <div class="dropzone-previews d-none"></div>
    <section class="users-edit">
        <div class="card">
            <div class="card-header justify-content-center">
                <h4 class="card-title"><i class="feather icon-settings"></i> Settings</h4>
            </div>
            <div class="card-content">
                <div class="card-body">


                    <form class="form" action="/settings" method="POST">
                        @csrf
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item navigation-setting-heading">
                                <a class="nav-link navigation-setting-link active" id="settings-tab" data-toggle="tab" href="#settings" aria-controls="settings" role="tab" aria-selected="true">Settings</a>
                            </li>
                            <li class="nav-item navigation-setting-heading">
                                <a class="nav-link navigation-setting-link" id="customization-tab" data-toggle="tab" href="#customization" aria-controls="customization" role="tab" aria-selected="false">Customization</a>
                            </li>
                            <li class="save-btn">
                                <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Save <i class="fa fa-spinner fa-spin d-none"></i></button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="settings" aria-labelledby="settings-tab" role="tabpanel">
                                <div class="row align-items-center mt-3 mb-2">
                                    <div class="col-md-4 col-6">
                                        <p> Allow Customer Registration</p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="custom-control custom-switch custom-switch-primary switch-md">
                                            <input type="checkbox" class="custom-control-input" id="allow-customer-registration" name="allow_customer_registration"
                                                {{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('allow_customer_registration')==true?'checked':'' }}>
                                            <label class="custom-control-label" for="allow-customer-registration">
                                                <span class="switch-text-left">YES</span>
                                                <span class="switch-text-right">NO</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-6">
                                        <div class="form-label-group position-relative has-icon-left">
                                            <input type="number" min="0" id="reseller-discount" class="form-control" placeholder="Reseller Discount"
                                                   name="reseller_discount" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('reseller_discount') }}">
                                            <div class="form-control-position">
                                                <i class="feather icon-percent"></i>
                                            </div>
                                            <label for="reseller-discount">Reseller Discount</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-label-group position-relative has-icon-left">
                                            <input type="number" step="any" id="customer-rate" class="form-control" placeholder="Customer Rate"
                                                   name="customer_rate" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('customer_rate') }}">
                                            <div class="form-control-position">
                                                <i class="feather icon-percent"></i>
                                            </div>
                                            <label for="customer-rate">Customer Rate</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-1">
                                    <div class="col-auto">
                                        <h4 class="card-title"><i class="feather icon-circle"></i> Company Details</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-6">
                                        <div class="form-label-group position-relative">
                                            <input type="email" id="company-email" class="form-control" placeholder="Email"
                                                   name="company_email" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('company_email') }}">
                                            <label for="company-email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-label-group position-relative">
                                            <input type="text" id="company-phone" class="form-control" placeholder="Phone"
                                                   name="company_phone" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('company_phone') }}">
                                            <label for="company-phone">Phone</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-label-group position-relative">
                                            <input type="text" id="company-address-line-1" class="form-control" placeholder="Address Line 1"
                                                   name="company_address_line_1" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('company_address_line_1') }}">
                                            <label for="company-address-line-1">Address Line 1</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-label-group position-relative">
                                            <input type="text" id="company-address-line-2" class="form-control" placeholder="Address Line 2"
                                                   name="company_address_line_2" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('company_address_line_2') }}">
                                            <label for="company-address-line-2">Address Line 2</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-label-group position-relative">
                                            <input type="text" id="company-city" class="form-control" placeholder="City"
                                                   name="company_city" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('company_city') }}">
                                            <label for="company-city">City</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-label-group position-relative">
                                            <input type="text" id="company-state" class="form-control" placeholder="State"
                                                   name="company_state" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('company_state') }}">
                                            <label for="company-state">State</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-label-group position-relative">
                                            <input type="text" id="company-country" class="form-control" placeholder="Country"
                                                   name="company_country" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('company_country') }}">
                                            <label for="company-country">Country</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-label-group position-relative">
                                            <input type="text" id="company-region" class="form-control" placeholder="Region"
                                                   name="company_region" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('company_region') }}">
                                            <label for="company-region">Region</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center mt-1 mb-1">
                                    <div class="col-md-4 col-6">
                                        <p> Same Billing Details</p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="custom-control custom-switch custom-switch-primary switch-md">
                                            <input type="checkbox" class="custom-control-input" id="same-billing-details" name="same_billing_details" onclick="handleBilling()"
                                                {{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('same_billing_details')==true?'checked':'' }}>
                                            <label class="custom-control-label" for="same-billing-details">
                                                <span class="switch-text-left">YES</span>
                                                <span class="switch-text-right">NO</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="billing-information" style="display: {{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('same_billing_details')==true?'none':'block' }}">
                                    <div class="row align-items-center mb-1">
                                        <div class="col-auto">
                                            <h4 class="card-title"><i class="feather icon-circle"></i> Billing Details</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <div class="form-label-group position-relative">
                                                <input type="email" id="billing-email" class="form-control" placeholder="Email"
                                                       name="billing_email" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('billing_email') }}">
                                                <label for="billing-email">Email</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-label-group position-relative">
                                                <input type="text" id="billing-phone" class="form-control" placeholder="Phone"
                                                       name="billing_phone" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('billing_phone') }}">
                                                <label for="billing-phone">Phone</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-label-group position-relative">
                                                <input type="text" id="billing-address-line-1" class="form-control" placeholder="Address Line 1"
                                                       name="billing_address_line_1" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('billing_address_line_1') }}">
                                                <label for="billing-address-line-1">Address Line 1</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-label-group position-relative">
                                                <input type="text" id="billing-address-line-2" class="form-control" placeholder="Address Line 2"
                                                       name="billing_address_line_2" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('billing_address_line_2') }}">
                                                <label for="billing-address-line-2">Address Line 2</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-label-group position-relative">
                                                <input type="text" id="billing-city" class="form-control" placeholder="City"
                                                       name="billing_city" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('billing_city') }}">
                                                <label for="billing-city">City</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-label-group position-relative">
                                                <input type="text" id="billing-state" class="form-control" placeholder="State"
                                                       name="billing_state" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('billing_state') }}">
                                                <label for="billing-state">State</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-label-group position-relative">
                                                <input type="text" id="billing-country" class="form-control" placeholder="Country"
                                                       name="billing_country" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('billing_country') }}">
                                                <label for="billing-country">Country</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-label-group position-relative">
                                                <input type="text" id="billing-region" class="form-control" placeholder="Region"
                                                       name="billing_region" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('billing_region') }}">
                                                <label for="billing-region">Region</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-1">
                                    <div class="col-auto">
                                        <h4 class="card-title"><i class="feather icon-circle"></i> Stripe</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-6">
                                        <div class="form-label-group position-relative">
                                            <input type="text" id="stripe-publishable-key" class="form-control" placeholder="Stripe Publishable Key"
                                                   name="stripe_publishable_key" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('stripe_publishable_key') }}">
                                            <label for="stripe-publishable-key">Stripe Publishable Key</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-label-group position-relative">
                                            <input type="text" id="stripe-secret-key" class="form-control" placeholder="Stripe Secret Key"
                                                   name="stripe_secret_key" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('stripe_secret_key') }}">
                                            <label for="stripe-secret-key">Stripe Secret Key</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-1">
                                    <div class="col-auto">
                                        <h4 class="card-title"><i class="feather icon-circle"></i> Paypal</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-6">
                                        <div class="form-label-group position-relative">
                                            <input type="text" id="paypal-client-id" class="form-control" placeholder="Paypal Client Id"
                                                   name="paypal_client_id" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('paypal_client_id') }}">
                                            <label for="paypal-client-id">Paypal Client Id</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-label-group position-relative">
                                            <input type="text" id="paypal-secret" class="form-control" placeholder="Paypal Secret"
                                                   name="paypal_secret" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('paypal_secret') }}">
                                            <label for="paypal-secret">Paypal Secret</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="custom-control custom-switch custom-switch-primary switch-md">
                                            <p>Api Mode</p>
                                            <input type="checkbox" class="custom-control-input" id="paypal-api-mode-switch" name="paypal_api_mode"
                                                {{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('paypal_api_mode')=='LIVE'?'checked':'' }}>
                                            <label class="custom-control-label" for="paypal-api-mode-switch">
                                                <span class="switch-text-left">LIVE</span>
                                                <span class="switch-text-right">TEST</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-1">
                                    <div class="col-auto">
                                        <h4 class="card-title"><i class="feather icon-circle"></i> Reloadly</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-6">
                                        <div class="form-label-group position-relative">
                                            <input type="text" id="reloadly-api-key" class="form-control" placeholder="Reloadly Api Key"
                                                   name="reloadly_api_key" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('reloadly_api_key') }}">
                                            <label for="reloadly-api-key">Reloadly Api Key</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-label-group position-relative">
                                            <input type="text" id="reloadly-api-secret" class="form-control" placeholder="Reloadly Api Secret"
                                                   name="reloadly_api_secret" value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('reloadly_api_secret') }}">
                                            <label for="reloadly-api-secret">Reloadly Api Secret</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="custom-control custom-switch custom-switch-primary switch-md">
                                            <p>Api Mode</p>
                                            <input type="checkbox" class="custom-control-input" id="reloadly-api-mode-switch" name="reloadly_api_mode"
                                                {{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('reloadly_api_mode')==true?'checked':'' }}>
                                            <label class="custom-control-label" for="reloadly-api-mode-switch">
                                                <span class="switch-text-left">LIVE</span>
                                                <span class="switch-text-right">TEST</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane" id="customization" aria-labelledby="customization-tab" role="tabpanel">

                                <div class="row col-12 mt-3 mb-2">
                                    <div class="col-md-4 col-6">
                                        <p>Customise the view of your Client-Level CMS Dashboard</p>
                                    </div>
                                </div>
                                <div class="row col-12 mb-3">
                                    <div class="col-md-3 control-label">
                                        <p> Custom Theme</p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="custom-control custom-switch custom-switch-primary switch-md">
                                            <input type="checkbox" class="custom-control-input" id="custom-theme" name="custom_theme"
                                                {{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('custom_theme')==true?'checked':'' }}>
                                            <label class="custom-control-label" for="custom-theme">
                                                <span class="switch-text-left">YES</span>
                                                <span class="switch-text-right">NO</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="media mb-3">
                                    <a class="col-md-3 control-label" href="#">
                                        <img src="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('full_logo') }}" alt="Full Logo" class="users-avatar-shadow rounded" width="90" height="90">
                                    </a>
                                    <div class="col-6 col-md-4 input-group p-0">
                                        <h6 class="media-heading">Full Logo</h6>

                                        <div class="col-12 d-flex mt-1 px-0">
                                            <button type="button" id="dpz-logo" class="btn btn-primary d-none d-sm-block mr-75 waves-effect waves-light">Change <i class="fa fa-spinner fa-spin d-none"></i></button>
                                            <button type="button" class="btn btn-primary d-block d-sm-none mr-75 waves-effect waves-light"><i class="feather icon-edit-1"></i></button>
                                            <button type="button" data-toggle="post-feed" data-feed="/settings/full_logo/remove" class="btn btn-outline-danger d-none d-sm-block waves-effect waves-light">Remove</button>
                                            <button type="button" data-toggle="post-feed" data-feed="/settings/full_logo/remove" class="btn btn-outline-danger d-block d-sm-none waves-effect waves-light"><i class="feather icon-trash-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="media mb-3">
                                    <a class="col-md-3 control-label" href="#">
                                        <img src="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('mini_logo') }}" alt="Mini Logo" class="users-avatar-shadow rounded" width="90" height="90">
                                    </a>
                                    <div class="col-6 col-md-4 input-group p-0">
                                        <h6 class="media-heading">Mini Logo</h6>

                                        <div class="col-12 d-flex mt-1 px-0">
                                            <button type="button" id="dpz-mini-logo" class="btn btn-primary d-none d-sm-block mr-75 waves-effect waves-light">Change <i class="fa fa-spinner fa-spin d-none"></i></button>
                                            <button type="button" class="btn btn-primary d-block d-sm-none mr-75 waves-effect waves-light"><i class="feather icon-edit-1"></i></button>
                                            <button type="button" data-toggle="post-feed" data-feed="/settings/mini_logo/remove" class="btn btn-outline-danger d-none d-sm-block waves-effect waves-light">Remove</button>
                                            <button type="button" data-toggle="post-feed" data-feed="/settings/mini_logo/remove" class="btn btn-outline-danger d-block d-sm-none waves-effect waves-light"><i class="feather icon-trash-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="media mb-3">
                                    <a class="col-md-3 control-label" href="#">
                                        <img src="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('favicon') }}" alt="Favicon" class="users-avatar-shadow rounded" width="90" height="90">
                                    </a>
                                    <div class="col-6 col-md-4 input-group p-0">
                                        <h6 class="media-heading">Favicon</h6>

                                        <div class="col-12 d-flex mt-1 px-0">
                                            <button type="button" id="dpz-favicon" class="btn btn-primary d-none d-sm-block mr-75 waves-effect waves-light">Change <i class="fa fa-spinner fa-spin d-none"></i></button>
                                            <button type="button" class="btn btn-primary d-block d-sm-none mr-75 waves-effect waves-light"><i class="feather icon-edit-1"></i></button>
                                            <button type="button" data-toggle="post-feed" data-feed="/settings/favicon/remove" class="btn btn-outline-danger d-none d-sm-block waves-effect waves-light">Remove</button>
                                            <button type="button" data-toggle="post-feed" data-feed="/settings/favicon/remove" class="btn btn-outline-danger d-block d-sm-none waves-effect waves-light"><i class="feather icon-trash-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="media mb-3">
                                    <a class="col-md-3 control-label" href="#">
                                        <img src="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('login_logo') }}" alt="Login Logo" class="users-avatar-shadow rounded" width="90" height="90">
                                    </a>
                                    <div class="col-6 col-md-4 input-group p-0">
                                        <h6 class="media-heading">Login Logo</h6>

                                        <div class="col-12 d-flex mt-1 px-0">
                                            <button type="button" id="dpz-login-logo" class="btn btn-primary d-none d-sm-block mr-75 waves-effect waves-light">Change <i class="fa fa-spinner fa-spin d-none"></i></button>
                                            <button type="button" class="btn btn-primary d-block d-sm-none mr-75 waves-effect waves-light"><i class="feather icon-edit-1"></i></button>
                                            <button type="button" data-toggle="post-feed" data-feed="/settings/login_logo/remove" class="btn btn-outline-danger d-none d-sm-block waves-effect waves-light">Remove</button>
                                            <button type="button" data-toggle="post-feed" data-feed="/settings/login_logo/remove" class="btn btn-outline-danger d-block d-sm-none waves-effect waves-light"><i class="feather icon-trash-2"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row col-12">
                                    <p class="col-md-3 control-label" for="reseller_rate">UI Color</p>
                                    <div class="col-6 col-md-4 input-group color_group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >&nbsp;#&nbsp;</span>
                                        </div>
                                        <input type="text" class="form-control color_changed" name="ui_color"
                                               value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('ui_color') }}">
                                        <div class="input-group-append">
                                            <span class="colorpicker-input-addon m-0 p-0 input-group-text">
                                                <i></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row col-12">
                                    <p class="col-md-3 control-label" for="reseller_rate">Icon Color</p>
                                    <div class="col-6 col-md-4 input-group color_group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >&nbsp;#&nbsp;</span>
                                        </div>
                                        <input type="text" class="form-control color_changed" name="icon_color"
                                               value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('icon_color') }}">
                                        <div class="input-group-append">
                                            <span class="colorpicker-input-addon m-0 p-0 input-group-text">
                                                <i></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row col-12">
                                    <p class="col-md-3 control-label" for="reseller_rate">Topbar Background Color</p>
                                    <div class="col-6 col-md-4 input-group color_group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >&nbsp;#&nbsp;</span>
                                        </div>
                                        <input type="text" class="form-control color_changed" name="topbar_background_color"
                                               value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('topbar_background_color') }}">
                                        <div class="input-group-append">
                                            <span class="colorpicker-input-addon m-0 p-0 input-group-text">
                                                <i></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="heading-small text-muted mb-1">Sidebar</h6>

                                <div class="form-group row col-12">
                                    <p class="col-md-3 control-label" for="reseller_rate">Background Color</p>
                                    <div class="col-6 col-md-4 input-group color_group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >&nbsp;#&nbsp;</span>
                                        </div>
                                        <input type="text" class="form-control color_changed" name="sidebar_background_color"
                                               value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('sidebar_background_color') }}">
                                        <div class="input-group-append">
                                            <span class="colorpicker-input-addon m-0 p-0 input-group-text">
                                                <i></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row col-12">
                                    <p class="col-md-3 control-label" for="reseller_rate">Text Color</p>
                                    <div class="col-6 col-md-4 input-group color_group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >&nbsp;#&nbsp;</span>
                                        </div>
                                        <input type="text" class="form-control color_changed" name="sidebar_text_color"
                                               value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('sidebar_text_color') }}">
                                        <div class="input-group-append">
                                            <span class="colorpicker-input-addon m-0 p-0 input-group-text">
                                                <i></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row col-12">
                                    <p class="col-md-3 control-label" for="reseller_rate">Nav Item Color</p>
                                    <div class="col-6 col-md-4 input-group color_group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >&nbsp;#&nbsp;</span>
                                        </div>
                                        <input type="text" class="form-control color_changed" name="sidebar_nav_item_color"
                                               value="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('sidebar_nav_item_color') }}">
                                        <div class="input-group-append">
                                            <span class="colorpicker-input-addon m-0 p-0 input-group-text">
                                                <i></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>




                            </div>
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="/js/dropzone.min.js"></script>
    <script src="/app-assets/color_picker/js/bootstrap-colorpicker.js" type="text/javascript"></script>
    <script>
        $('.color_group').colorpicker({
            useAlpha: false,
            autoInputFallback: false,
            fallbackColor: 'FFFFFF',
            format: 'hex',
            useHashPrefix: false
        }).on('colorpickerChange', function (e) {
            var io = $(this).children('input');
            if (e.value === io.val() || !e.color || !e.color.isValid()) {
                var changeInterval = setInterval(function(){ io.val(e.value);clearInterval(changeInterval); }, 1);
                return;
            }

            io.val(e.color.string());
        });
    </script>
    <script>
        Dropzone.autoDiscover = false;
        $("button#dpz-logo").dropzone({
            paramName: "full_logo",
            url: '/settings/full_logo/upload',
            params: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            maxFiles: 1,
            uploadMultiple: false,
            acceptedFiles: 'image/*',
            previewsContainer: ".dropzone-previews",
            createImageThumbnails: false,
            init: function () {
                this.on("maxfilesexceeded", function (file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
                this.on("addedfile",function () {
                    $('button#dpz-logo i').toggleClass('d-none');
                })
                this.on("success",function (file,response) {
                    $('button#dpz-logo i').toggleClass('d-none');
                    if (response.message){
                        toastr.success(response.message);
                    }
                    if (response.location){
                        window.location = response.location;
                    }
                });
                this.on("error",function (file,response) {
                    $('button#dpz-logo i').toggleClass('d-none');
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

        Dropzone.autoDiscover = false;
        $("button#dpz-mini-logo").dropzone({
            paramName: "mini_logo",
            url: '/settings/mini_logo/upload',
            params: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            maxFiles: 1,
            uploadMultiple: false,
            acceptedFiles: 'image/*',
            previewsContainer: ".dropzone-previews",
            createImageThumbnails: false,
            init: function () {
                this.on("maxfilesexceeded", function (file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
                this.on("addedfile",function () {
                    $('button#dpz-mini-logo i').toggleClass('d-none');
                })
                this.on("success",function (file,response) {
                    $('button#dpz-mini-logo i').toggleClass('d-none');
                    if (response.message){
                        toastr.success(response.message);
                    }
                    if (response.location){
                        window.location = response.location;
                    }
                });
                this.on("error",function (file,response) {
                    $('button#dpz-mini-logo i').toggleClass('d-none');
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

        Dropzone.autoDiscover = false;
        $("button#dpz-favicon").dropzone({
            paramName: "favicon",
            url: '/settings/favicon/upload',
            params: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            maxFiles: 1,
            uploadMultiple: false,
            acceptedFiles: 'image/*',
            previewsContainer: ".dropzone-previews",
            createImageThumbnails: false,
            init: function () {
                this.on("maxfilesexceeded", function (file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
                this.on("addedfile",function () {
                    $('button#dpz-favicon i').toggleClass('d-none');
                })
                this.on("success",function (file,response) {
                    $('button#dpz-favicon i').toggleClass('d-none');
                    if (response.message){
                        toastr.success(response.message);
                    }
                    if (response.location){
                        window.location = response.location;
                    }
                });
                this.on("error",function (file,response) {
                    $('button#dpz-favicon i').toggleClass('d-none');
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
        $("button#dpz-login-logo").dropzone({
            paramName: "login_logo",
            url: '/settings/login_logo/upload',
            params: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            maxFiles: 1,
            uploadMultiple: false,
            acceptedFiles: 'image/*',
            previewsContainer: ".dropzone-previews",
            createImageThumbnails: false,
            init: function () {
                this.on("maxfilesexceeded", function (file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
                this.on("addedfile",function () {
                    $('button#dpz-login-logo i').toggleClass('d-none');
                })
                this.on("success",function (file,response) {
                    $('button#dpz-login-logo i').toggleClass('d-none');
                    if (response.message){
                        toastr.success(response.message);
                    }
                    if (response.location){
                        window.location = response.location;
                    }
                });
                this.on("error",function (file,response) {
                    $('button#dpz-login-logo i').toggleClass('d-none');
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

        function handleBilling(){
            if(document.getElementById('same-billing-details').checked)
                document.getElementById('billing-information').style.display='none';
            else
                document.getElementById('billing-information').style.display='block';
        }

    </script>

@endpush
