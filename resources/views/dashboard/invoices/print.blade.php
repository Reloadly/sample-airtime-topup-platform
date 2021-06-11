@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Invoice')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/invoice.min.css">
    <link rel="stylesheet" type="text/css" href="/css/pages/app-invoice-print.css">
    <style>
        .app-content{
            margin: 0px !important;
        }
        .content-wrapper{
            margin: 0px !important;
            padding: 0px !important;
        }
        .header-navbar-shadow{
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <section class="card invoice-page">
        <div id="invoice-template" class="card-body">
            <!-- Invoice Company Details -->
            <div id="invoice-company-details" class="row">
                <div class="col-sm-6 col-12 text-left pt-1">
                    <div class="media pt-1">
                        @if((@OTIFSolutions\Laravel\Settings\Models\Setting::get('custom_theme')==true) && (@OTIFSolutions\Laravel\Settings\Models\Setting::get('login_logo')))
                            <img src="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('login_logo') }}" width="200px" alt="company logo" >
                        @else
                            <img src="{{ asset('/assets/svgs/logo.svg') }}" width="200px" alt="company logo" />
                        @endif
                    </div>
                </div>
                <div class="col-sm-6 col-12 text-right">
                    <h1>Invoice</h1>
                    <div class="invoice-details mt-2">
                        <h6>INVOICE NO4. {{ $invoice['id'] }}</h6>
                        <h6 class="mt-2">INVOICE DATE</h6>
                        <p>{{ \Carbon\Carbon::parse($invoice['created_at'])->format('Y-m-d H:m') }}</p>
                    </div>
                </div>
            </div>
            <!--/ Invoice Company Details -->

            <!-- Invoice Recipient Details -->
            <div id="invoice-customer-details" class="row pt-2">
                <div class="col-sm-6 col-12 text-left">
                    <h5>Recipient</h5>
                    <div class="recipient-info my-2">
                        <p>{{ @$invoice['user']['name'] }}</p>
                        <p>{{ @$invoice['user']['address_line_1'] }}</p>
                        <p>{{ @$invoice['user']['address_line_2'] }}</p>
                        <p>{{ @$invoice['user']['city'].($invoice['user']['city'].$invoice['user']['country']!==''?' , ':'').$invoice['user']['country'] }}</p>
                        <p>{{ @$invoice['user']['postal_code'] }}</p>
                    </div>
                    <div class="recipient-contact pb-2">
                        @isset($invoice['user']['email'])
                            <p>
                                <i class="feather icon-mail"></i>
                                {{ $invoice['user']['email'] }}
                            </p>
                        @endisset
                        @isset($invoice['user']['phone'])
                            <p>
                                <i class="feather icon-phone"></i>
                                {{ $invoice['user']['phone'] }}
                            </p>
                        @endisset
                    </div>
                </div>
                <div class="col-sm-6 col-12 text-right">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>United Kingdom (UK)</h5>
                            <div class="company-info my-2">
                                <p>19 DEAN ROAD ROOM 3</p>
                                <p> LONDON NW2</p>
                                <p> 5AB UK.</p>
                            </div>
                            <div class="company-contact">

                                <p>
                                    <i class="feather icon-phone"></i>
                                    +44-746-633-5235
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>West Africa (Nigeria)</h5>
                            <div class="company-info my-2">
                                <p>No. 9 Udotung Street</p>
                                <p>Off Okop Eto Road</p>
                                <p>Ikot Ekpene,Akwa Ibom, Nigeria</p>
                            </div>
                            <div class="company-contact">
                                <p>
                                    <i class="feather icon-mail"></i>
                                    billing@topup.com
                                </p>
                                <p>
                                    <i class="feather icon-phone"></i>
                                    (234) 702 060 4785
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Invoice Recipient Details -->

            <!-- Invoice Items Details -->
            <div id="invoice-items-details" class="pt-1 invoice-items-table">
                @switch($invoice['type'])
                    @case('Topup')
                    <div class="row">
                        <div class="table-responsive col-12">
                            <table class="table table-borderless">
                                <thead>
                                <tr>
                                    <th>DESCRIPTION</th>
                                    @if(($invoice['user']['user_role']['name'] == 'CUSTOMER') && ($invoice['amount'] != $invoice['topup']['amount']))
                                        <th>RATE</th>
                                    @endif
                                    <th>AMOUNT</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Topup Request</td>
                                    @if(($invoice['user']['user_role']['name'] == 'CUSTOMER') && ($invoice['amount'] != $invoice['topup']['amount']))
                                        <td>{{ number_format(($invoice['amount']-$invoice['topup']['amount']),2).' '.$invoice['currency_code'] }}</td>
                                    @endif
                                    <td>{{ number_format($invoice['amount'],2).' '.$invoice['currency_code'] }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @break
                    @case('AddFunds')
                    <div class="row">
                        <div class="table-responsive col-12">
                            <table class="table table-borderless">
                                <thead>
                                <tr>
                                    <th>DESCRIPTION</th>
                                    <th>AMOUNT</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Add Funds to Wallet</td>
                                    <td>{{ number_format($invoice['amount'],2).' '.$invoice['currency_code'] }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @break
                @endswitch
            </div>
            <div id="invoice-total-details" class="invoice-total-table">
                <div class="row">
                    <div class="col-7 offset-5">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <th>SUBTOTAL</th>
                                    <td>{{number_format($invoice['amount'],2).' '.$invoice['currency_code']}}</td>
                                </tr>
                                <tr>
                                    <th>TOTAL</th>
                                    <td>{{ number_format($invoice['amount'],2).' '.$invoice['currency_code']}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Invoice Footer -->
            <div id="invoice-footer" class="text-right pt-3">
                @switch($invoice['status'])
                    @case('PENDING')
                    @if (($invoice['user']['user_role']['name']!='CUSTOMER') && $invoice['type'] !== 'AddFunds' && $invoice['user']['balance_value'] > $invoice['amount'] )
                        <div class="row justify-content-end align-items-end align-content-end">
                            <div class="col-3">
                                <button class="w-100 btn btn-info mb-1" data-toggle="post-feed" data-feed="/invoices/{{ $invoice['id'] }}/pay/balance"><i class="fa fa-money"></i> Pay with Balance</button>
                            </div>
                        </div>
                    @endif
                    <div class="row justify-content-end align-items-end align-content-end mt-1">
                        <div class="col-8 col-sm-6 col-md-3">
                            <button class="w-100 btn btn-primary mb-1" data-toggle="modal-feed" data-target="#modal_sm" data-feed="/invoices/{{ $invoice['id'] }}/stripe/checkout"><i class="feather icon-credit-card"></i> Pay Now (Card)</button>
                        </div>
                    </div>
                    @if(\App\Models\System::isPaypalSupported($invoice))
                        <div class="row justify-content-end align-content-end align-items-end">
                            <div id="paypal-button-container" class="col-8 col-sm-6 col-md-3 mb-1"></div>
                        </div>
                    @endif
                    @break
                @endswitch
                <p>Keep your invoices paid in order to enjoy non stop service.</p>

            </div>
        </div>
    </section>
    @include('dashboard.layout.modals')
@endsection

@push('js')
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script src="/js/pages/app-invoice-print.js"></script>
@endpush
