@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Api Documentation')

@push('css')
<link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.css">
<link rel="stylesheet" type="text/css" href="app-assets/css/colors.css">
<link rel="stylesheet" type="text/css" href="app-assets/css/components.css">
     <style>
        .nav-pills .nav-link {
            padding: 0.786rem 1.5rem !important;
            font-size: 1rem;
            line-height: 1rem;
            border: 1px solid transparent;
                border-top-color: transparent;
                border-right-color: transparent;
                border-bottom-color: transparent;
                border-left-color: transparent;
            color: #5E5873;
        }
        .nav-pills .nav-link i.feather{
            font-size: 130%;
        }
        .avatar.avatar-tag i.feather{
            font-size: 150%;
        }
        .text-success{
            color: #690 !important;
        }
        .text-danger{
            color: #DD4A68 !important;
        }
        .text-secondary{
            color: #a3b4bd;
        }
        .bg-custom {
            background-color: rgb(213, 222, 225)!important;
        }
    </style>

@endpush

@section('content')
    <section>
        <div class="row">
            <div class="col">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title text-center"><i class="feather icon-book-open"></i> API Documentation</h4>
                  </div>
                </div>
            </div>
        </div>
    </section>
    <section id="faq-tabs">
                    <!-- vertical tab pill -->
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <div class="faq-navigation d-flex justify-content-between flex-column mb-2 mb-md-0">
                                <!-- pill tabs navigation -->
                                <ul class="nav nav-pills nav-left flex-column" role="tablist">
                                    <!-- About -->
                                    <li class="nav-item">
                                        <a class="nav-link active" id="about" data-toggle="pill" href="#api-about" aria-expanded="true" role="tab">
                                            <i class="feather icon-help-circle"></i>
                                            <span class="font-weight-bold">About API</span>
                                        </a>
                                    </li>

                                    <!-- Token -->
                                    <li class="nav-item">
                                        <a class="nav-link" id="token" data-toggle="pill" href="#api-token" aria-expanded="false" role="tab">
                                            <i class="feather icon-check-square"></i>
                                            <span class="font-weight-bold">Get Token</span>
                                        </a>
                                    </li>

                                    <!-- Countries -->
                                    <li class="nav-item">
                                        <a class="nav-link" id="countries" data-toggle="pill" href="#api-countries" aria-expanded="false" role="tab">
                                            <i class="fa fa-globe font-medium-3 mr-1" aria-hidden="true"></i>
                                            <span class="font-weight-bold">Get Countries</span>
                                        </a>
                                    </li>

                                    <!-- Operators -->
                                    <li class="nav-item">
                                        <a class="nav-link" id="operators" data-toggle="pill" href="#api-operators" aria-expanded="false" role="tab">
                                            <i class="feather icon-aperture"></i>
                                            <span class="font-weight-bold">Get Operators</span>
                                        </a>
                                    </li>

                                    <!-- Operator By Country-->
                                    <li class="nav-item">
                                        <a class="nav-link" id="operator-country" data-toggle="pill" href="#api-operator-country" aria-expanded="false" role="tab">
                                            <i class="feather icon-aperture"></i>
                                            <span class="font-weight-bold">Get Operators By Country id</span>
                                        </a>
                                    </li>

                                    <!-- Operator By Id-->
                                    <li class="nav-item">
                                        <a class="nav-link" id="operator-id" data-toggle="pill" href="#api-operator-id" aria-expanded="false" role="tab">
                                            <i class="feather icon-aperture"></i>
                                            <span class="font-weight-bold">Get Operators By id</span>
                                        </a>
                                    </li>

                                    <!-- Send Topup -->
                                    <li class="nav-item">
                                        <a class="nav-link" id="send-topup" data-toggle="pill" href="#api-send-topup" aria-expanded="false" role="tab">
                                            <i class="feather icon-send"></i>
                                            <span class="font-weight-bold">Send Topup</span>
                                        </a>
                                    </li>

                                    <!-- Transactions -->
                                    <li class="nav-item">
                                        <a class="nav-link" id="transactions" data-toggle="pill" href="#api-transactions" aria-expanded="false" role="tab">
                                            <i class="feather icon-aperture"></i>
                                            <span class="font-weight-bold">Get Transactions</span>
                                        </a>
                                    </li>

                                    <!-- Transactions By Ref No-->
                                    <li class="nav-item">
                                        <a class="nav-link" id="transaction-ref" data-toggle="pill" href="#api-transaction-ref" aria-expanded="false" role="tab">
                                            <i class="feather icon-aperture"></i>
                                            <span class="font-weight-bold">Get Transactions By Ref no</span>
                                        </a>
                                    </li>

                                    <!-- Transactions By Id-->
                                    <li class="nav-item">
                                        <a class="nav-link" id="transaction-id" data-toggle="pill" href="#api-transaction-id" aria-expanded="false" role="tab">
                                            <i class="feather icon-aperture"></i>
                                            <span class="font-weight-bold">Get Transactions By id</span>
                                        </a>
                                    </li>

                                    <!-- Get Gift Card Products-->
                                    <li class="nav-item">
                                        <a class="nav-link" id="gift_card_products" data-toggle="pill" href="#api-gift_card_products" aria-expanded="false" role="tab">
                                            <i class="feather icon-aperture"></i>
                                            <span class="font-weight-bold">Get Gift Card Products</span>
                                        </a>
                                    </li>
                                    <!-- Get Gift Card Product By Id-->
                                    <li class="nav-item">
                                        <a class="nav-link" id="gift_card_products_id" data-toggle="pill" href="#api-gift_card_products_id" aria-expanded="false" role="tab">
                                            <i class="feather icon-aperture"></i>
                                            <span class="font-weight-bold">Get Gift Card Product By Id</span>
                                        </a>
                                    </li>
                                    <!-- Order Gift Card-->
                                    <li class="nav-item">
                                        <a class="nav-link" id="order_gift_card" data-toggle="pill" href="#api-order_gift_card" aria-expanded="false" role="tab">
                                            <i class="feather icon-aperture"></i>
                                            <span class="font-weight-bold">Order Gift Card</span>
                                        </a>
                                    </li>
                                </ul>

                                <!-- FAQ image -->
                                <img src="app-assets/images/illustration/faq-illustrations.svg" class="img-fluid d-none d-md-block" alt="demand img" />
                            </div>
                        </div>

                        <div class="col-lg-9 col-md-8 col-sm-12">
                            <!-- pill tabs tab content -->
                            <div class="tab-content">
                                <!-- payment panel -->
                                <div role="tabpanel" class="tab-pane active" id="api-about" aria-labelledby="about" aria-expanded="true">
                                    <!-- icon and header -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-tag bg-light-primary mr-1">
                                            <i class="feather icon-help-circle"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0 font-weight-bolder">About API</h4>
                                            <span>There are six endpoints that are readily available.</span>
                                        </div>
                                    </div>

                                    <!-- frequent answer and question  collapse  -->
                                    <div class="collapse-margin collapse-icon mt-2" id="api-about-qna">
                                        <div class="card">
                                            <div class="card-header bg-custom" id="AboutUs" data-toggle="collapse" role="button" data-target="#api-about-one" aria-expanded="true" aria-controls="api-about-one">
                                                <span class="lead collapse-title font-weight-bolder">Endpoints</span>
                                            </div>
                                            <div id="api-about-one" class="collapse show" aria-labelledby="AboutUs" data-parent="#api-about-qna">
                                                <div class="card-body">
                                                   <ul class="list-style-square my-1">
                                                       <li>Get Token <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/get_token</span></li>
                                                       <li class="mt-1">Get Countries <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/countries</span></li>
                                                       <li class="mt-1">Get Operators <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/operators</span></li>
                                                       <li class="mt-1">Get Operators By Country id <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/countries/{countryId}/operators</span></li>
                                                       <li class="mt-1">Get Single Operator <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/operators/{operatorId}</span></li>
                                                       <li class="mt-1">Send Topup  <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/topup</span></li>
                                                       <li class="mt-1">Get Transactions <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/transactions</span></li>
                                                       <li class="mt-1">Get Transaction By Ref <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/transactions/reference/{refNo}</span></li>
                                                       <li class="mt-1">Get Transaction By Id <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/transactions/id/{id}</span></li>
                                                       <li class="mt-1">Get Gift Card Products<span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/gift_cards/products</span></li>
                                                       <li class="mt-1">Get Gift Card Products By Id <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/gift_cards/products/{id}</span></li>
                                                       <li class="mt-1">Order Gift Card <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/gift_cards/order</span></li>
                                                   </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- delivery panel -->
                                <div class="tab-pane" id="api-token" role="tabpanel" aria-labelledby="Token" aria-expanded="false">
                                    <!-- icon and header -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-tag bg-light-primary mr-1">
                                            <i class="feather icon-check-square"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0 font-weight-bolder">Get Token</h4>
                                            <span>The api works on OAuth 2.0 Protocol and thus requires a token for all calls.
                                                To get this token user calls the POST api route <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/get_token</span> with their email and password.</span>
                                        </div>
                                    </div>

                                    <!-- frequent answer and question  collapse  -->
                                    <div class="collapse-margin collapse-icon mt-2" id="api-token-qna">
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="deliveryOne" data-toggle="collapse" role="button" data-target="#api-token-one" aria-expanded="true" aria-controls="api-token-one">
                                                <span class="lead collapse-title font-weight-bolder">Fields Supported</span>
                                            </div>

                                            <div id="api-token-one" class="collapse bg-light show" aria-labelledby="deliveryOne" data-parent="#api-token-qna">
                                                <div class="card-body">
                                                    <ul class="list-style-square my-1">
                                                        <li>email</li>
                                                        <li>password</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="deliveryTwo" data-toggle="collapse" role="button" data-target="#api-token-two" aria-expanded="false" aria-controls="api-token-two">
                                                <span class="lead collapse-title font-weight-bolder">
                                                Sample Request
                                                </span>
                                            </div>
                                            <div id="api-token-two" class="collapse bg-light" aria-labelledby="deliveryTwo" data-parent="#api-token-qna">
                                                <div class="card-body">
                                                    <pre class="py-2 font-weight-bolder">
    <span class="text-danger font-weight-bolder">curl</span>
            <span class="text-secondary">--location</span>
            <span class="text-secondary">--request POST</span>
                      <span class="text-success">'/api/get_token'</span>  \
            <span class="text-secondary">--form</span>
                      <span class="text-success">'email="user@abc.com"'</span>  \
            <span class="text-secondary">--form</span>
                      <span class="text-success">'password="user"'</span>  \
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="deliveryThree" data-toggle="collapse" role="button" data-target="#api-token-three" aria-expanded="false" aria-controls="api-token-three">
                                                <span class="lead collapse-title font-weight-bolder">Sample Response</span>
                                            </div>
                                            <div id="api-token-three" class="collapse bg-light" aria-labelledby="deliveryThree" data-parent="#api-token-qna">
                                                <div class="card-body shadow-none">
                                                      <pre class="py-2 font-weight-bolder">
    <span class="text-secondary font-weight-bolder">{</span>
            <span class="text-secondary">"accessToken"</span> <span class="text-danger">:</span> <span class="text-success">"ACCESS_TOKEN_COMES_HERE" ,</span>
            <span class="text-secondary">"token"</span> <span class="text-danger">:</span> <span class="text-secondary">{</span>
            <span class="text-secondary">"id"</span> <span class="text-danger">:</span> <span class="text-success">"SOME_ID_FOR_TOKEN" ,</span>
            <span class="text-secondary">"user_id"</span> <span class="text-danger">:</span>    <span class="text-danger">1 ,</span>
            <span class="text-secondary">"client_id"</span> <span class="text-danger">:</span>  <span class="text-danger">1 ,</span>
            <span class="text-secondary">"name"</span> <span class="text-danger">:</span> <span class="text-success">"USER_EMAIL_NAME" ,</span>
            <span class="text-secondary">"scopes"</span> <span class="text-danger">:</span> <span class="text-success">[] ,</span>
            <span class="text-secondary">"revoked"</span> <span class="text-danger">:</span> <span class="text-success">false ,</span>
            <span class="text-secondary">"created_at"</span> <span class="text-danger">:</span> <span class="text-success">2020-12-17 07:57:04 ,</span>
            <span class="text-secondary">"updated_at"</span> <span class="text-danger">:</span> <span class="text-success">2020-12-17 07:57:04 ,</span>
            <span class="text-secondary">"expires_at"</span> <span class="text-danger">:</span> <span class="text-success">2021-12-17T07:57:04.000000Z ,</span>
    <span class="text-secondary font-weight-bolder">}</span>
                                                    </pre>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- cancellation return  -->
                                <div class="tab-pane" id="api-countries" role="tabpanel" aria-labelledby="cancellation-return" aria-expanded="false">
                                    <!-- icon and header -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-tag bg-light-primary mr-1">
                                            <i class="fa fa-globe font-medium-4"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0 font-weight-bolder">Get Countries</h4>
                                            <span>
                                                To get All countries a user sends <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">GET</span> request to the
                                                <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/countries</span> route.
                                                This is protected via OAuth 2.0 so requires token to be sent in the header.
                                            </span>
                                        </div>
                                    </div>

                                    <!-- frequent answer and question  collapse  -->
                                    <div class="collapse-margin collapse-icon mt-2" id="api-countries-qna">
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="cancellationOne" data-toggle="collapse" role="button" data-target="#api-countries-one" aria-expanded="true" aria-controls="api-countries-one">
                                                <span class="lead collapse-title font-weight-bolder">
                                                    Sample Request
                                                </span>
                                            </div>

                                            <div id="api-countries-one" class="collapse bg-light show" aria-labelledby="cancellationOne" data-parent="#api-countries-qna">
                                                <div class="card-body">
                                                    <pre class="py-2 font-weight-bolder">
    <span class="text-danger font-weight-bolder">curl</span>
            <span class="text-secondary">--location</span>
            <span class="text-secondary">--request GET</span>
                      <span class="text-success">'/api/countries'</span>  \
            <span class="text-secondary">--header</span>
                      <span class="text-success">'Authorization: Bearer TOKEN_GOES_HERE'</span>
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="cancellationTwo" data-toggle="collapse" role="button" data-target="#api-countries-two" aria-expanded="false" aria-controls="api-countries-two">
                                                <span class="lead collapse-title font-weight-bolder">Sample Response</span>
                                            </div>
                                            <div id="api-countries-two" class="collapse bg-light" aria-labelledby="cancellationTwo" data-parent="#api-countries-qna">
                                                <div class="card-body shadow-none">
                                                      <pre class="py-2 font-weight-bolder">
    <span class="text-secondary font-weight-bolder">[</span>
            <span class="text-secondary font-weight-bolder">{</span>
                       <span class="text-success">"id"</span> <span class="text-danger">:</span> <span class="text-success">1</span>
                       <span class="text-success">"iso"</span> <span class="text-danger">:</span> <span class="text-success">"AF"</span>
                       <span class="text-success">"name"</span> <span class="text-danger">:</span> <span class="text-success">"Afghanistan"</span>
                       <span class="text-success">"currency_code"</span> <span class="text-danger">:</span> <span class="text-success">"AFN"</span>
                       <span class="text-success">"currency_name"</span> <span class="text-danger">:</span> <span class="text-success">"Afghan Afghani"</span>
                       <span class="text-success">"currency_symbol"</span> <span class="text-danger">:</span> <span class="text-success">"؋"</span>
                       <span class="text-success">"flag"</span> <span class="text-danger">:</span> <span class="text-success">"https://s3.amazonaws.com/rld-flags/af.svg"</span>

            <span class="text-secondary font-weight-bolder">}</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-secondary font-weight-bolder">{</span>
                       <span class="text-success">"id"</span> <span class="text-danger">:</span> <span class="text-success">2</span>
                       <span class="text-success">"iso"</span> <span class="text-danger">:</span> <span class="text-success">"AL"</span>
                       <span class="text-success">"name"</span> <span class="text-danger">:</span> <span class="text-success">"Albania"</span>
                       <span class="text-success">"currency_code"</span> <span class="text-danger">:</span> <span class="text-success">"ALL"</span>
                       <span class="text-success">"currency_name"</span> <span class="text-danger">:</span> <span class="text-success">"Albanian Lek"</span>
                       <span class="text-success">"currency_symbol"</span> <span class="text-danger">:</span> <span class="text-success">"Lek"</span>
                       <span class="text-success">"flag"</span> <span class="text-danger">:</span> <span class="text-success">"https://s3.amazonaws.com/rld-flags/al.svg"</span>

            <span class="text-secondary font-weight-bolder">}</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-secondary font-weight-bolder">{</span>
                       <span class="text-success">"id"</span> <span class="text-danger">:</span> <span class="text-success">3</span>
                       <span class="text-success">"iso"</span> <span class="text-danger">:</span> <span class="text-success">"DZ"</span>
                       <span class="text-success">"name"</span> <span class="text-danger">:</span> <span class="text-success">"Algeria"</span>
                       <span class="text-success">"currency_code"</span> <span class="text-danger">:</span> <span class="text-success">"DZD"</span>
                       <span class="text-success">"currency_name"</span> <span class="text-danger">:</span> <span class="text-success">"Algerian Dinar"</span>
                       <span class="text-success">"currency_symbol"</span> <span class="text-danger">:</span> <span class="text-success">"د.ج.‏"</span>
                       <span class="text-success">"flag"</span> <span class="text-danger">:</span> <span class="text-success">"https://s3.amazonaws.com/rld-flags/dz.svg"</span>

            <span class="text-secondary font-weight-bolder">}</span>

    <span class="text-secondary font-weight-bolder">]</span>
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- my order -->
                                <div class="tab-pane" id="api-operators" role="tabpanel" aria-labelledby="my-order" aria-expanded="false">
                                    <!-- icon and header -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-tag bg-light-primary mr-1">
                                            <i class="feather icon-aperture"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0 font-weight-bolder">Get Operators</h4>
                                            <span>
                                                To get All operators a user sends <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">GET</span> request to the
                                                <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/operators</span> route.
                                                This is protected via OAuth 2.0 so requires token to be sent in the header.
                                            </span>
                                        </div>
                                    </div>

                                    <!-- frequent answer and question  collapse  -->
                                    <div class="collapse-margin collapse-icon mt-2" id="api-operators-qna">
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="myOrderOne" data-toggle="collapse" role="button" data-target="#api-operators-one" aria-expanded="true" aria-controls="api-operators-one">
                                                <span class="lead collapse-title font-weight-bolder">Sample Request</span>
                                            </div>

                                            <div id="api-operators-one" class="collapse bg-light show" aria-labelledby="myOrderOne" data-parent="#api-operators-qna">
                                                <div class="card-body">
                                                    <pre class="py-2 font-weight-bolder">
    <span class="text-danger font-weight-bolder">curl</span>
            <span class="text-secondary">--location</span>
            <span class="text-secondary">--request GET</span>
                      <span class="text-success">'/api/operators'</span>  \
            <span class="text-secondary">--header</span>
                      <span class="text-success">'Authorization: Bearer TOKEN_GOES_HERE'</span>
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="myOrderTwo" data-toggle="collapse" role="button" data-target="#api-operators-two" aria-expanded="false" aria-controls="api-operators-two">
                                                <span class="lead collapse-title font-weight-bolder">
                                                    Sample Response
                                                </span>
                                            </div>
                                            <div id="api-operators-two" class="collapse bg-light" aria-labelledby="myOrderTwo" data-parent="#api-operators-qna">
                                                <div class="card-body shadow-none">
                                                      <pre class="py-2 font-weight-bolder">
    <span class="text-secondary font-weight-bolder">[</span>
            <span class="text-secondary font-weight-bolder">{</span>
                       <span class="text-success">"id"</span> <span class="text-danger">:</span> <span class="text-success">1</span>
                       <span class="text-success">"country_id"</span> <span class="text-danger">:</span> <span class="text-success">119</span>
                       <span class="text-success">"name"</span> <span class="text-danger">:</span> <span class="text-success">"168 Thailand"</span>
                       <span class="text-success">"bundle"</span> <span class="text-danger">:</span> <span class="text-success">"0"</span>
                       <span class="text-success">"data"</span> <span class="text-danger">:</span> <span class="text-success">0</span>
                       <span class="text-success">"pin"</span> <span class="text-danger">:</span> <span class="text-success">0</span>
                       <span class="text-success">"supports_local_amounts"</span> <span class="text-danger">:</span> <span class="text-success">0</span>
                       <span class="text-success">"denomination_type"</span> <span class="text-danger">:</span> <span class="text-success">"FIXED"</span>
                       <span class="text-success">"sender_currency_code"</span> <span class="text-danger">:</span> <span class="text-success">"CAD"</span>
                       <span class="text-success">"sender_currency_symbol"</span> <span class="text-danger">:</span> <span class="text-success">"$"</span>
                       <span class="text-success">"destination_currency_code"</span> <span class="text-danger">:</span> <span class="text-success">"THB"</span>
                       <span class="text-success">"destination_currency_symbol"</span> <span class="text-danger">:</span> <span class="text-success">"฿"</span>
                       <span class="text-success">"most_popular_amount"</span> <span class="text-danger">:</span> <span class="text-success">26.34</span>
                       <span class="text-success">"min_amount"</span> <span class="text-danger">:</span> <span class="text-success">null</span>
                       <span class="text-success">"local_min_amount"</span> <span class="text-danger">:</span> <span class="text-success">null</span>
                       <span class="text-success">"max_amount"</span> <span class="text-danger">:</span> <span class="text-success">null</span>
                       <span class="text-success">"local_max_amount"</span> <span class="text-danger">:</span> <span class="text-success">null</span>
                       <span class="text-success">"fx_rate"</span> <span class="text-danger">:</span> <span class="text-success">18.80</span>
                       <span class="text-success">"logo_urls"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[</span>
                                <span class="text-success">"https://s3.amazonaws.com/rld-operator/13f57481-aad1-4534-8434-428f7ea32ffb-size-1.png"</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">"https://s3.amazonaws.com/rld-operator/13f57481-aad1-4534-8434-428f7ea32ffb-size-3.png",</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">"https://s3.amazonaws.com/rld-operator/13f57481-aad1-4534-8434-428f7ea32ffb-size-2.png"</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-secondary font-weight-bolder">]</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"fixed_amounts"</span> <span class="text-danger">:</span><span class="text-secondary font-weight-bolder">[</span>
                                <span class="text-success">0.53</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">1.06</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">2.65</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">5.28</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">10.54</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">15.81</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">26.33</span>
                       <span class="text-secondary font-weight-bolder">]</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"fixed_amounts_descriptions"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[ ]</span><span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"local_fixed_amounts"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[ ]</span><span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"local_fixed_amounts_descriptions"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[ ]</span><span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"suggested_amounts"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[ ]</span><span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"suggested_amounts_map"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">{</span>
                                <span class="text-secondary">"0.53"</span> <span class="text-danger">:</span> <span class="text-success">10</span>
                                <span class="text-secondary">"1.06"</span> <span class="text-danger">:</span> <span class="text-success">20</span>
                                <span class="text-secondary">"2.65"</span> <span class="text-danger">:</span> <span class="text-success">50</span>
                                <span class="text-secondary">"5.28"</span> <span class="text-danger">:</span> <span class="text-success">100</span>
                                <span class="text-secondary">"10.54"</span> <span class="text-danger">:</span> <span class="text-success">200</span>
                                <span class="text-secondary">"15.81"</span> <span class="text-danger">:</span> <span class="text-success">300</span>
                                <span class="text-secondary">"26.34"</span> <span class="text-danger">:</span> <span class="text-success">500</span>
                       <span class="text-secondary font-weight-bolder">}</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"created_at"</span> <span class="text-danger">:</span> <span class="text-success">2020-11-17T07:25:30.000000Z</span>
                       <span class="text-success">"updated_at"</span> <span class="text-danger">:</span> <span class="text-success">2020-12-17T00:00:09.000000Z</span>
                       <span class="text-success">"select_amounts"</span> <span class="text-danger">:</span><span class="text-secondary font-weight-bolder">[</span>
                                <span class="text-success">0.53</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">1.06</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">2.64</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">5.28</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">10.54</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">15.81</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">26.34</span>
                       <span class="text-secondary font-weight-bolder">]</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"rates"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">{</span>
                                <span class="text-secondary">"international_discount"</span> <span class="text-danger">:</span> <span class="text-success">1</span>
                                <span class="text-secondary">"local_discount"</span> <span class="text-danger">:</span> <span class="text-success">0</span>
                       <span class="text-secondary font-weight-bolder">}</span>


            <span class="text-secondary font-weight-bolder">}</span> <span class="text-secondary font-weight-bolder">,</span>
            <span class="text-secondary font-weight-bolder">{</span>
                       <span class="text-success">"id"</span> <span class="text-danger">:</span> <span class="text-success">2</span>
                       <span class="text-success">"country_id"</span> <span class="text-danger">:</span> <span class="text-success">88</span>
                       <span class="text-success">"name"</span> <span class="text-danger">:</span> <span class="text-success">"9Mobile (Etisalat) Nigeria"</span>
                       <span class="text-success">"bundle"</span> <span class="text-danger">:</span> <span class="text-success">"0"</span>
                       <span class="text-success">"data"</span> <span class="text-danger">:</span> <span class="text-success">0</span>
                       <span class="text-success">"pin"</span> <span class="text-danger">:</span> <span class="text-success">0</span>
                       <span class="text-success">"supports_local_amounts"</span> <span class="text-danger">:</span> <span class="text-success">1</span>
                       <span class="text-success">"denomination_type"</span> <span class="text-danger">:</span> <span class="text-success">"RANGE"</span>
                       <span class="text-success">"sender_currency_code"</span> <span class="text-danger">:</span> <span class="text-success">"CAD"</span>
                       <span class="text-success">"sender_currency_symbol"</span> <span class="text-danger">:</span> <span class="text-success">"$"</span>
                       <span class="text-success">"destination_currency_code"</span> <span class="text-danger">:</span> <span class="text-success">"NGN"</span>
                       <span class="text-success">"destination_currency_symbol"</span> <span class="text-danger">:</span> <span class="text-success">"₦"</span>
                       <span class="text-success">"most_popular_amount"</span> <span class="text-danger">:</span> <span class="text-success">19</span>
                       <span class="text-success">"min_amount"</span> <span class="text-danger">:</span> <span class="text-success">0.029</span>
                       <span class="text-success">"local_min_amount"</span> <span class="text-danger">:</span> <span class="text-success">5</span>
                       <span class="text-success">"max_amount"</span> <span class="text-danger">:</span> <span class="text-success">179</span>
                       <span class="text-success">"local_max_amount"</span> <span class="text-danger">:</span> <span class="text-success">50000</span>
                       <span class="text-success">"fx_rate"</span> <span class="text-danger">:</span> <span class="text-success">246.745</span>
                       <span class="text-success">"logo_urls"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[</span>
                                <span class="text-success">"https://s3.amazonaws.com/rld-operator/a6c9c490-39fa-47c0-a63a-b4a4d1d4dbe5-size-3.png"</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">"https://s3.amazonaws.com/rld-operator/a6c9c490-39fa-47c0-a63a-b4a4d1d4dbe5-size-2.png",</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">"https://s3.amazonaws.com/rld-operator/a6c9c490-39fa-47c0-a63a-b4a4d1d4dbe5-size-1.png"</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-secondary font-weight-bolder">]</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"fixed_amounts"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[ ]</span><span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"fixed_amounts_descriptions"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[ ]</span><span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"local_fixed_amounts"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[ ]</span><span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"local_fixed_amounts_descriptions"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[ ]</span><span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"suggested_amounts"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[ ]</span><span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"suggested_amounts"</span> <span class="text-danger">:</span><span class="text-secondary font-weight-bolder">[</span>
                                <span class="text-success">1</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">6</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">12</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">19</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">25</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">32</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">38</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">45</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">51</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">58</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">64</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">71</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">77</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">84</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">90</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">97</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">103</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">110</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">116</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">123</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">129</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">136</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">142</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">149</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">155</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">162</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">168</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">175</span>
                       <span class="text-secondary font-weight-bolder">]</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"suggested_amounts_map"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">{</span>
                                <span class="text-success">1</span> <span class="text-danger">:</span> <span class="text-success">246.75</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">6</span> <span class="text-danger">:</span> <span class="text-success">1480.48</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">12</span> <span class="text-danger">:</span> <span class="text-success">2960.96</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">19</span> <span class="text-danger">:</span> <span class="text-success">4688.18</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">25</span> <span class="text-danger">:</span> <span class="text-success">6168.66</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">32</span> <span class="text-danger">:</span> <span class="text-success">7895.88</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">38</span> <span class="text-danger">:</span> <span class="text-success">9376.36</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">45</span> <span class="text-danger">:</span> <span class="text-success">11103.59</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">51</span> <span class="text-danger">:</span> <span class="text-success">12584.06</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">58</span> <span class="text-danger">:</span> <span class="text-success">14311.29</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">64</span> <span class="text-danger">:</span> <span class="text-success">15791.76</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">71</span> <span class="text-danger">:</span> <span class="text-success">17518.99</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">77</span> <span class="text-danger">:</span> <span class="text-success">18999.46</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">84</span> <span class="text-danger">:</span> <span class="text-success">20726.69</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">90</span> <span class="text-danger">:</span> <span class="text-success">22207.17</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">97</span> <span class="text-danger">:</span> <span class="text-success">23934.39</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">103</span> <span class="text-danger">:</span> <span class="text-success">25414.87</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">110</span> <span class="text-danger">:</span> <span class="text-success">27142.09</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">116</span> <span class="text-danger">:</span> <span class="text-success">28622.57</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">123</span> <span class="text-danger">:</span> <span class="text-success">30349.79</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">129</span> <span class="text-danger">:</span> <span class="text-success">31830.27</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">136</span> <span class="text-danger">:</span> <span class="text-success">33557.49</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">142</span> <span class="text-danger">:</span> <span class="text-success">35037.97</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">149</span> <span class="text-danger">:</span> <span class="text-success">36765.19</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">155</span> <span class="text-danger">:</span> <span class="text-success">38245.67</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">162</span> <span class="text-danger">:</span> <span class="text-success">39972.89</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">168</span> <span class="text-danger">:</span> <span class="text-success">41453.37</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">175</span> <span class="text-danger">:</span> <span class="text-success">43180.59</span>
                       <span class="text-secondary font-weight-bolder">}</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"created_at"</span> <span class="text-danger">:</span> <span class="text-success">2020-11-17T07:25:30.000000Z</span>
                       <span class="text-success">"updated_at"</span> <span class="text-danger">:</span> <span class="text-success">2020-12-17T00:00:09.000000Z</span>
                       <span class="text-success">"select_amounts"</span> <span class="text-danger">:</span><span class="text-secondary font-weight-bolder">[</span>
                                <span class="text-success">1</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">6</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">12</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">19</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">25</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">32</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">38</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">45</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">51</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">58</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">64</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">71</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">77</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">84</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">90</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">97</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">103</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">110</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">116</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">123</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">129</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">136</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">142</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">149</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">155</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">162</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">168</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">175</span>
                       <span class="text-secondary font-weight-bolder">]</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"rates"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">{</span>
                                   <span class="text-secondary">"international_discount"</span> <span class="text-danger">:</span> <span class="text-success">4.5</span>
                                   <span class="text-secondary">"local_discount"</span> <span class="text-danger">:</span> <span class="text-success">0</span>
                       <span class="text-secondary font-weight-bolder">}</span>


            <span class="text-secondary font-weight-bolder">}</span> <span class="text-secondary font-weight-bolder">,</span>

    <span class="text-secondary font-weight-bolder">]</span>
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- product services -->
                                <div class="tab-pane" id="api-operator-country" role="tabpanel" aria-labelledby="product-services" aria-expanded="false">
                                    <!-- icon and header -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-tag bg-light-primary mr-1">
                                            <i class="feather icon-aperture"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0 font-weight-bolder">Get Operators By Country id</h4>
                                            <span>
                                                To get All Operators By Country id a user sends <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">GET</span> request to the
                                                <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/countries/{countryId}/operators</span> route.
                                                This is protected via OAuth 2.0 so requires token to be sent in the header.
                                            </span>
                                        </div>
                                    </div>

                                    <!-- frequent answer and question  collapse  -->
                                    <div class="collapse-margin collapse-icon mt-2" id="api-operator-country-qna">
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="productOne" data-toggle="collapse" role="button" data-target="#api-operator-country-one" aria-expanded="true" aria-controls="api-operator-country-one">
                                                <span class="lead collapse-title font-weight-bolder">Sample Request</span>
                                            </div>

                                            <div id="api-operator-country-one" class="collapse bg-light show" aria-labelledby="productOne" data-parent="#api-operator-country-qna">
                                                <div class="card-body">
                                                    <pre class="py-2 font-weight-bolder">
    <span class="text-danger font-weight-bolder">curl</span>
            <span class="text-secondary">--location</span>
            <span class="text-secondary">--request GET</span>
                      <span class="text-success">'/api/countries/1/operators'</span>  \
            <span class="text-secondary">--header</span>
                      <span class="text-success">'Authorization: Bearer TOKEN_GOES_HERE'</span>
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="productTwo" data-toggle="collapse" role="button" data-target="#api-operator-country-two" aria-expanded="false" aria-controls="api-operator-country-two">
                                                <span class="lead collapse-title font-weight-bolder">Sample Response</span>
                                            </div>
                                            <div id="api-operator-country-two" class="collapse bg-light" aria-labelledby="productTwo" data-parent="#api-operator-country-qna">
                                                <div class="card-body shadow-none">
                                                      <pre class="py-2 font-weight-bolder">
    <span class="text-secondary font-weight-bolder">[</span>
            <span class="text-secondary font-weight-bolder">{</span>
                       <span class="text-success">"id"</span> <span class="text-danger">:</span> <span class="text-success">5</span>
                       <span class="text-success">"country_id"</span> <span class="text-danger">:</span> <span class="text-success">1</span>
                       <span class="text-success">"name"</span> <span class="text-danger">:</span> <span class="text-success">"Afghan Wireless Afghanistan"</span>
                       <span class="text-success">"bundle"</span> <span class="text-danger">:</span> <span class="text-success">"0"</span>
                       <span class="text-success">"data"</span> <span class="text-danger">:</span> <span class="text-success">0</span>
                       <span class="text-success">"pin"</span> <span class="text-danger">:</span> <span class="text-success">0</span>
                       <span class="text-success">"supports_local_amounts"</span> <span class="text-danger">:</span> <span class="text-success">1</span>
                       <span class="text-success">"denomination_type"</span> <span class="text-danger">:</span> <span class="text-success">"RANGE"</span>
                       <span class="text-success">"sender_currency_code"</span> <span class="text-danger">:</span> <span class="text-success">"CAD"</span>
                       <span class="text-success">"sender_currency_symbol"</span> <span class="text-danger">:</span> <span class="text-success">"$"</span>
                       <span class="text-success">"destination_currency_code"</span> <span class="text-danger">:</span> <span class="text-success">"AFN"</span>
                       <span class="text-success">"destination_currency_symbol"</span> <span class="text-danger">:</span> <span class="text-success">"؋"</span>
                       <span class="text-success">"most_popular_amount"</span> <span class="text-danger">:</span> <span class="text-success">19</span>
                       <span class="text-success">"min_amount"</span> <span class="text-danger">:</span> <span class="text-success">0.65</span>
                       <span class="text-success">"local_min_amount"</span> <span class="text-danger">:</span> <span class="text-success">38</span>
                       <span class="text-success">"max_amount"</span> <span class="text-danger">:</span> <span class="text-success">42</span>
                       <span class="text-success">"local_max_amount"</span> <span class="text-danger">:</span> <span class="text-success">2500</span>
                       <span class="text-success">"fx_rate"</span> <span class="text-danger">:</span> <span class="text-success">50.12</span>
                       <span class="text-success">"logo_urls"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[</span>
                                <span class="text-success">"https://s3.amazonaws.com/rld-operator/b0c4d9d0-9feb-48ba-9a29-3f4a8bcd3268-size-2.png"</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">"https://s3.amazonaws.com/rld-operator/b0c4d9d0-9feb-48ba-9a29-3f4a8bcd3268-size-3.png",</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">"https://s3.amazonaws.com/rld-operator/b0c4d9d0-9feb-48ba-9a29-3f4a8bcd3268-size-1.png"</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-secondary font-weight-bolder">]</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"fixed_amounts"</span> <span class="text-danger">:</span><span class="text-secondary font-weight-bolder">[ ]</span>
                       <span class="text-success">"fixed_amounts_descriptions"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[ ]</span><span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"local_fixed_amounts"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[ ]</span><span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"local_fixed_amounts_descriptions"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[ ]</span><span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"suggested_amounts"</span> <span class="text-danger">:</span><span class="text-secondary font-weight-bolder">[ ]</span>
                                <span class="text-success">1</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">6</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">12</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">19</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">25</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">32</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">38</span>
                       <span class="text-secondary font-weight-bolder">]</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"suggested_amounts_map"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">{</span>
                                <span class="text-secondary">"1"</span> <span class="text-danger">:</span> <span class="text-success">50.13</span>
                                <span class="text-secondary">"6"</span> <span class="text-danger">:</span> <span class="text-success">300.73</span>
                                <span class="text-secondary">"12"</span> <span class="text-danger">:</span> <span class="text-success">601.45</span>
                                <span class="text-secondary">"19"</span> <span class="text-danger">:</span> <span class="text-success">952.29</span>
                                <span class="text-secondary">"25"</span> <span class="text-danger">:</span> <span class="text-success">1253.01</span>
                                <span class="text-secondary">"32"</span> <span class="text-danger">:</span> <span class="text-success">1603.86</span>
                                <span class="text-secondary">"38"</span> <span class="text-danger">:</span> <span class="text-success">1904.58</span>
                       <span class="text-secondary font-weight-bolder">}</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"created_at"</span> <span class="text-danger">:</span> <span class="text-success">2020-11-17T07:25:30.000000Z</span>
                       <span class="text-success">"updated_at"</span> <span class="text-danger">:</span> <span class="text-success">2020-12-17T00:00:09.000000Z</span>
                       <span class="text-success">"select_amounts"</span> <span class="text-danger">:</span><span class="text-secondary font-weight-bolder">[</span>
                                <span class="text-success">1</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">6</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">12</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">19</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">25</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">32</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">38</span>
                       <span class="text-secondary font-weight-bolder">]</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"rates"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">{</span>
                                <span class="text-secondary">"international_discount"</span> <span class="text-danger">:</span> <span class="text-success">5</span>
                                <span class="text-secondary">"local_discount"</span> <span class="text-danger">:</span> <span class="text-success">0.5</span>
                       <span class="text-secondary font-weight-bolder">}</span>


            <span class="text-secondary font-weight-bolder">}</span>


    <span class="text-secondary font-weight-bolder">]</span>
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="api-operator-id" role="tabpanel" aria-labelledby="operator-id" aria-expanded="false">
                                    <!-- icon and header -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-tag bg-light-primary mr-1">
                                            <i class="feather icon-aperture"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0 font-weight-bolder">Get Operators By id</h4>
                                            <span>
                                                To get Operators By its id a user sends <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">GET</span> request to the
                                                <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/operators/{operatorId}</span> route.
                                                This is protected via OAuth 2.0 so requires token to be sent in the header.
                                            </span>
                                        </div>
                                    </div>

                                    <!-- frequent answer and question  collapse  -->
                                    <div class="collapse-margin collapse-icon mt-2" id="api-operator-qna">
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="operatorOne" data-toggle="collapse" role="button" data-target="#api-operator-one" aria-expanded="true" aria-controls="api-operator-one">
                                                <span class="lead collapse-title font-weight-bolder">Sample Request</span>
                                            </div>

                                            <div id="api-operator-one" class="collapse bg-light show" aria-labelledby="operatorOne" data-parent="#api-operator-qna">
                                                <div class="card-body">
                                                    <pre class="py-2 font-weight-bolder">
    <span class="text-danger font-weight-bolder">curl</span>
            <span class="text-secondary">--location</span>
            <span class="text-secondary">--request GET</span>
                      <span class="text-success">'/api/operators/1'</span>  \
            <span class="text-secondary">--header</span>
                      <span class="text-success">'Authorization: Bearer TOKEN_GOES_HERE'</span>
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="operatorTwo" data-toggle="collapse" role="button" data-target="#api-operator-two" aria-expanded="false" aria-controls="api-operator-two">
                                                <span class="lead collapse-title font-weight-bolder">Sample Response</span>
                                            </div>
                                            <div id="api-operator-two" class="collapse bg-light" aria-labelledby="operatorTwo" data-parent="#api-operator-qna">
                                                <div class="card-body shadow-none">
                                                      <pre class="py-2 font-weight-bolder">
            <span class="text-secondary font-weight-bolder">{</span>
                       <span class="text-success">"id"</span> <span class="text-danger">:</span> <span class="text-success">1</span>
                       <span class="text-success">"country_id"</span> <span class="text-danger">:</span> <span class="text-success">119</span>
                       <span class="text-success">"name"</span> <span class="text-danger">:</span> <span class="text-success">"168 Thailand"</span>
                       <span class="text-success">"bundle"</span> <span class="text-danger">:</span> <span class="text-success">"0"</span>
                       <span class="text-success">"data"</span> <span class="text-danger">:</span> <span class="text-success">0</span>
                       <span class="text-success">"pin"</span> <span class="text-danger">:</span> <span class="text-success">0</span>
                       <span class="text-success">"supports_local_amounts"</span> <span class="text-danger">:</span> <span class="text-success">0</span>
                       <span class="text-success">"denomination_type"</span> <span class="text-danger">:</span> <span class="text-success">"FIXED"</span>
                       <span class="text-success">"sender_currency_code"</span> <span class="text-danger">:</span> <span class="text-success">"CAD"</span>
                       <span class="text-success">"sender_currency_symbol"</span> <span class="text-danger">:</span> <span class="text-success">"$"</span>
                       <span class="text-success">"destination_currency_code"</span> <span class="text-danger">:</span> <span class="text-success">"THB"</span>
                       <span class="text-success">"destination_currency_symbol"</span> <span class="text-danger">:</span> <span class="text-success">"฿"</span>
                       <span class="text-success">"most_popular_amount"</span> <span class="text-danger">:</span> <span class="text-success">26.34</span>
                       <span class="text-success">"min_amount"</span> <span class="text-danger">:</span> <span class="text-success">null</span>
                       <span class="text-success">"local_min_amount"</span> <span class="text-danger">:</span> <span class="text-success">null</span>
                       <span class="text-success">"max_amount"</span> <span class="text-danger">:</span> <span class="text-success">null</span>
                       <span class="text-success">"local_max_amount"</span> <span class="text-danger">:</span> <span class="text-success">null</span>
                       <span class="text-success">"fx_rate"</span> <span class="text-danger">:</span> <span class="text-success">18.81</span>
                       <span class="text-success">"logo_urls"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[</span>
                                <span class="text-success">"https://s3.amazonaws.com/rld-operator/13f57481-aad1-4534-8434-428f7ea32ffb-size-1.png"</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">"https://s3.amazonaws.com/rld-operator/13f57481-aad1-4534-8434-428f7ea32ffb-size-3.png",</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">"https://s3.amazonaws.com/rld-operator/13f57481-aad1-4534-8434-428f7ea32ffb-size-2.png"</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-secondary font-weight-bolder">]</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"fixed_amounts"</span> <span class="text-danger">:</span><span class="text-secondary font-weight-bolder">[ </span>
                       <span class="text-success">1</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">0.53</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">1.06</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">2.65</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">5.28</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">10.54</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">15.81</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">26.34</span>
                       <span class="text-secondary font-weight-bolder">]</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"fixed_amounts_descriptions"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[ ]</span><span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"local_fixed_amounts"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[ ]</span><span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"local_fixed_amounts_descriptions"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">[ ]</span><span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"suggested_amounts"</span> <span class="text-danger">:</span><span class="text-secondary font-weight-bolder">[ ]</span>
                       <span class="text-success">"suggested_amounts_map"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">{</span>
                                <span class="text-secondary">"0.53"</span> <span class="text-danger">:</span> <span class="text-success">10</span>
                                <span class="text-secondary">"1.06"</span> <span class="text-danger">:</span> <span class="text-success">20</span>
                                <span class="text-secondary">"2.65"</span> <span class="text-danger">:</span> <span class="text-success">50</span>
                                <span class="text-secondary">"5.28"</span> <span class="text-danger">:</span> <span class="text-success">100</span>
                                <span class="text-secondary">"10.54"</span> <span class="text-danger">:</span> <span class="text-success">200</span>
                                <span class="text-secondary">"15.81"</span> <span class="text-danger">:</span> <span class="text-success">300</span>
                                <span class="text-secondary">"26.34"</span> <span class="text-danger">:</span> <span class="text-success">500</span>
                       <span class="text-secondary font-weight-bolder">}</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"created_at"</span> <span class="text-danger">:</span> <span class="text-success">2020-11-17T07:25:30.000000Z</span>
                       <span class="text-success">"updated_at"</span> <span class="text-danger">:</span> <span class="text-success">2020-12-17T00:00:09.000000Z</span>
                       <span class="text-success">"select_amounts"</span> <span class="text-danger">:</span><span class="text-secondary font-weight-bolder">[</span>
                                <span class="text-success">0.53</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">1.06</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">2.65</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">5.28</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">10.54</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">15.81</span> <span class="text-secondary font-weight-bolder">,</span>
                                <span class="text-success">26.34</span>
                       <span class="text-secondary font-weight-bolder">]</span> <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-success">"rates"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">{</span>
                                <span class="text-secondary">"international_discount"</span> <span class="text-danger">:</span> <span class="text-success">1</span>
                                <span class="text-secondary">"local_discount"</span> <span class="text-danger">:</span> <span class="text-success">0</span>
                       <span class="text-secondary font-weight-bolder">}</span>


            <span class="text-secondary font-weight-bolder">}</span>
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="api-send-topup" role="tabpanel" aria-labelledby="send-topup" aria-expanded="false">
                                    <!-- icon and header -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-tag bg-light-primary mr-1">
                                            <i class="feather icon-send"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0 font-weight-bolder">Send Topup</h4>
                                            <span>
                                                To send topup a user is required to send a <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">POST</span> call to
                                                <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/topup</span> route.
                                                This is protected via OAuth 2.0 so requires token to be sent in the header.
                                            </span>
                                        </div>
                                    </div>

                                    <!-- frequent answer and question  collapse  -->
                                    <div class="collapse-margin collapse-icon mt-2" id="api-topup-qna">
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="topupZero" data-toggle="collapse" role="button" data-target="#api-topup-zero" aria-expanded="true" aria-controls="api-topup-one">
                                                <span class="lead collapse-title font-weight-bolder">Fields Supported</span>
                                            </div>

                                            <div id="api-topup-zero" class="collapse bg-light show" aria-labelledby="topupZero" data-parent="#api-topup-qna">
                                                <div class="card-body">
                                                    <ul class="list-style-square my-1">
                                                        <li>operator</li>
                                                        <li>number</li>
                                                        <li>amount</li>
                                                        <li>ref</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="topupOne" data-toggle="collapse" role="button" data-target="#api-topup-one" aria-expanded="false" aria-controls="api-topup-one">
                                                <span class="lead collapse-title font-weight-bolder">Sample Request</span>
                                            </div>

                                            <div id="api-topup-one" class="collapse bg-light" aria-labelledby="topupOne" data-parent="#api-topup-qna">
                                                <div class="card-body">
                                                    <pre class="py-2 font-weight-bolder">
    <span class="text-danger font-weight-bolder">curl</span>
            <span class="text-secondary">--location</span>
            <span class="text-secondary">--request POST</span>
                      <span class="text-success">'/api/topup'</span>  \
            <span class="text-secondary">--header</span>
                      <span class="text-success">'Authorization: Bearer TOKEN_GOES_HERE'</span>  \
            <span class="text-secondary">--form</span>
                      <span class="text-success">'operator="555"'</span>  \
            <span class="text-secondary">--form</span>
                      <span class="text-success">'number="0923333333333"'</span>  \
            <span class="text-secondary">--form</span>
                      <span class="text-success">'amount="2"'</span>  \
            <span class="text-secondary">--form</span>
                      <span class="text-success">'ref="ABC123"'</span>  \
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="topupTwo" data-toggle="collapse" role="button" data-target="#api-topup-two" aria-expanded="false" aria-controls="api-topup-two">
                                                <span class="lead collapse-title font-weight-bolder">Sample Response</span>
                                            </div>
                                            <div id="api-topup-two" class="collapse bg-light" aria-labelledby="topupTwo" data-parent="#api-topup-qna">
                                                <div class="card-body shadow-none">
                                                      <pre class="py-2 font-weight-bolder">
            <span class="text-secondary font-weight-bolder">{</span>
                        <span class="text-success">"success"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">{</span>
                                <span class="text-secondary">"message"</span> <span class="text-danger">:</span> <span class="text-success">Transaction created. It will be processed in a few minutes.</span>
                                <span class="text-secondary">"transaction"</span> <span class="text-danger">: {</span>
                                <span class="text-secondary">"ref_no"</span> <span class="text-danger">: </span> <span class="text-success">ABC123</span>
                                <span class="text-secondary">"operator_id"</span> <span class="text-danger">: </span> <span class="text-success">793</span>
                                <span class="text-secondary">"invoice_id"</span> <span class="text-danger">: </span> <span class="text-success">4</span>
                                <span class="text-secondary">"topup"</span> <span class="text-danger">: </span> <span class="text-success">116.4314187</span>
                                <span class="text-secondary">"amount"</span> <span class="text-danger">: </span> <span class="text-success">1.07</span>
                                <span class="text-secondary">"number"</span> <span class="text-danger">: </span> <span class="text-success">123123123</span>
                                <span class="text-secondary">"sender_currency"</span> <span class="text-danger">: </span> <span class="text-success">CAD</span>
                                <span class="text-secondary">"receiver_currency"</span> <span class="text-danger">: </span> <span class="text-success">PKR</span>
                                <span class="text-secondary">"is_local"</span> <span class="text-danger">: </span> <span class="text-success">false</span>
                                <span class="text-secondary">"updated_at"</span> <span class="text-danger">: </span> <span class="text-success">2021-10-23T10:18:48.000000Z</span>
                                <span class="text-secondary">"created_at"</span> <span class="text-danger">: </span> <span class="text-success">2021-10-23T10:18:47.000000Z</span>
                                <span class="text-secondary">"id"</span> <span class="text-danger">: </span> <span class="text-success">3</span>
                                <span class="text-secondary">"status"</span> <span class="text-danger">: </span> <span class="text-success">PENDING</span>
                                <span class="text-secondary">"message"</span> <span class="text-danger">: </span> <span class="text-success">Transaction is paid. But its pending topup. Please wait a few minuites for the status to update.</span>
                       <span class="text-secondary font-weight-bolder">}</span> <span class="text-secondary font-weight-bolder">,</span>

            <span class="text-secondary font-weight-bolder">}</span>
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="tab-pane" id="api-transactions" role="tabpanel" aria-labelledby="transactions" aria-expanded="false">
                                    <!-- icon and header -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-tag bg-light-primary mr-1">
                                            <i class="feather icon-send"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0 font-weight-bolder">Get Transactions</h4>
                                            <span>
                                                To get transactions a user is required to send a <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">GET</span> call to
                                                <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/transactions</span> route.
                                                This is protected via OAuth 2.0 so requires token to be sent in the header.
                                            </span>
                                        </div>
                                    </div>

                                    <!-- frequent answer and question  collapse  -->
                                    <div class="collapse-margin collapse-icon mt-2" id="api-transactions-qna">
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="transactionsOne" data-toggle="collapse" role="button" data-target="#api-transactions-one" aria-expanded="false" aria-controls="api-transactions-one">
                                                <span class="lead collapse-title font-weight-bolder">Sample Request</span>
                                            </div>

                                            <div id="api-transactions-one" class="collapse bg-light show" aria-labelledby="transactionsOne" data-parent="#api-transactions-qna">
                                                <div class="card-body">
                                                    <pre class="py-2 font-weight-bolder">
    <span class="text-danger font-weight-bolder">curl</span>
            <span class="text-secondary">--location</span>
            <span class="text-secondary">--request GET</span>
                      <span class="text-success">'/api/transactions'</span>  \
            <span class="text-secondary">--header</span>
                      <span class="text-success">'Authorization: Bearer TOKEN_GOES_HERE'</span>  \
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="topupTwo" data-toggle="collapse" role="button" data-target="#api-transactions-two" aria-expanded="false" aria-controls="api-transactions-two">
                                                <span class="lead collapse-title font-weight-bolder">Sample Response</span>
                                            </div>
                                            <div id="api-transactions-two" class="collapse bg-light" aria-labelledby="transactionsTwo" data-parent="#api-transactions-qna">
                                                <div class="card-body shadow-none">
                                                      <pre class="py-2 font-weight-bolder">
            <span class="text-secondary font-weight-bolder">[</span>
                        <span class="text-secondary font-weight-bolder">{</span>
                                <span class="text-secondary">"message"</span> <span class="text-danger">:</span> <span class="text-success">Transaction created. It will be processed in a few minutes.</span>
                                <span class="text-secondary">"transaction"</span> <span class="text-danger">: {</span>
                                <span class="text-secondary">"ref_no"</span> <span class="text-danger">: </span> <span class="text-success">ABC123</span>
                                <span class="text-secondary">"operator_id"</span> <span class="text-danger">: </span> <span class="text-success">793</span>
                                <span class="text-secondary">"invoice_id"</span> <span class="text-danger">: </span> <span class="text-success">4</span>
                                <span class="text-secondary">"topup"</span> <span class="text-danger">: </span> <span class="text-success">116.4314187</span>
                                <span class="text-secondary">"amount"</span> <span class="text-danger">: </span> <span class="text-success">1.07</span>
                                <span class="text-secondary">"number"</span> <span class="text-danger">: </span> <span class="text-success">123123123</span>
                                <span class="text-secondary">"sender_currency"</span> <span class="text-danger">: </span> <span class="text-success">CAD</span>
                                <span class="text-secondary">"receiver_currency"</span> <span class="text-danger">: </span> <span class="text-success">PKR</span>
                                <span class="text-secondary">"is_local"</span> <span class="text-danger">: </span> <span class="text-success">false</span>
                                <span class="text-secondary">"updated_at"</span> <span class="text-danger">: </span> <span class="text-success">2021-10-23T10:18:48.000000Z</span>
                                <span class="text-secondary">"created_at"</span> <span class="text-danger">: </span> <span class="text-success">2021-10-23T10:18:47.000000Z</span>
                                <span class="text-secondary">"id"</span> <span class="text-danger">: </span> <span class="text-success">3</span>
                                <span class="text-secondary">"status"</span> <span class="text-danger">: </span> <span class="text-success">PENDING</span>
                                <span class="text-secondary">"message"</span> <span class="text-danger">: </span> <span class="text-success">Transaction is paid. But its pending topup. Please wait a few minuites for the status to update.</span>
                       <span class="text-secondary font-weight-bolder">}</span>
                       <span class="text-secondary font-weight-bolder">,</span>
                       <span class="text-secondary font-weight-bolder">{</span>
                                <span class="text-secondary">"message"</span> <span class="text-danger">:</span> <span class="text-success">Transaction created. It will be processed in a few minutes.</span>
                                <span class="text-secondary">"transaction"</span> <span class="text-danger">: {</span>
                                <span class="text-secondary">"ref_no"</span> <span class="text-danger">: </span> <span class="text-success">ABC123</span>
                                <span class="text-secondary">"operator_id"</span> <span class="text-danger">: </span> <span class="text-success">793</span>
                                <span class="text-secondary">"invoice_id"</span> <span class="text-danger">: </span> <span class="text-success">4</span>
                                <span class="text-secondary">"topup"</span> <span class="text-danger">: </span> <span class="text-success">116.4314187</span>
                                <span class="text-secondary">"amount"</span> <span class="text-danger">: </span> <span class="text-success">1.07</span>
                                <span class="text-secondary">"number"</span> <span class="text-danger">: </span> <span class="text-success">123123123</span>
                                <span class="text-secondary">"sender_currency"</span> <span class="text-danger">: </span> <span class="text-success">CAD</span>
                                <span class="text-secondary">"receiver_currency"</span> <span class="text-danger">: </span> <span class="text-success">PKR</span>
                                <span class="text-secondary">"is_local"</span> <span class="text-danger">: </span> <span class="text-success">false</span>
                                <span class="text-secondary">"updated_at"</span> <span class="text-danger">: </span> <span class="text-success">2021-10-23T10:18:48.000000Z</span>
                                <span class="text-secondary">"created_at"</span> <span class="text-danger">: </span> <span class="text-success">2021-10-23T10:18:47.000000Z</span>
                                <span class="text-secondary">"id"</span> <span class="text-danger">: </span> <span class="text-success">3</span>
                                <span class="text-secondary">"status"</span> <span class="text-danger">: </span> <span class="text-success">PENDING</span>
                                <span class="text-secondary">"message"</span> <span class="text-danger">: </span> <span class="text-success">Transaction is paid. But its pending topup. Please wait a few minuites for the status to update.</span>
                       <span class="text-secondary font-weight-bolder">}</span>

            <span class="text-secondary font-weight-bolder">]</span>
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="api-transaction-ref" role="tabpanel" aria-labelledby="transaction-ref" aria-expanded="false">
                                    <!-- icon and header -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-tag bg-light-primary mr-1">
                                            <i class="feather icon-send"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0 font-weight-bolder">Get Transactions By Ref No</h4>
                                            <span>
                                                To get transactions by reference no a user is required to send a <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">GET</span> call to
                                                <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/transactions/reference/{refNo}</span> route.
                                                This is protected via OAuth 2.0 so requires token to be sent in the header.
                                            </span>
                                        </div>
                                    </div>

                                    <!-- frequent answer and question  collapse  -->
                                    <div class="collapse-margin collapse-icon mt-2" id="api-transaction-ref-qna">
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="transactionRefOne" data-toggle="collapse" role="button" data-target="#api-transaction-ref-one" aria-expanded="false" aria-controls="api-transaction-ref-one">
                                                <span class="lead collapse-title font-weight-bolder">Sample Request</span>
                                            </div>

                                            <div id="api-transaction-ref-one" class="collapse bg-light show" aria-labelledby="transactionRefOne" data-parent="#api-transaction-ref-qna">
                                                <div class="card-body">
                                                    <pre class="py-2 font-weight-bolder">
    <span class="text-danger font-weight-bolder">curl</span>
            <span class="text-secondary">--location</span>
            <span class="text-secondary">--request GET</span>
                      <span class="text-success">'/api/transactions/reference/ABC123'</span>  \
            <span class="text-secondary">--header</span>
                      <span class="text-success">'Authorization: Bearer TOKEN_GOES_HERE'</span>  \
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="transactionRefTwo" data-toggle="collapse" role="button" data-target="#api-transaction-ref-two" aria-expanded="false" aria-controls="api-transaction-ref-two">
                                                <span class="lead collapse-title font-weight-bolder">Sample Response</span>
                                            </div>
                                            <div id="api-transaction-ref-two" class="collapse bg-light" aria-labelledby="transactionRefTwo" data-parent="#api-transaction-ref-qna">
                                                <div class="card-body shadow-none">
                                                      <pre class="py-2 font-weight-bolder">
                        <span class="text-secondary font-weight-bolder">{</span>
                                <span class="text-secondary">"message"</span> <span class="text-danger">:</span> <span class="text-success">Transaction created. It will be processed in a few minutes.</span>
                                <span class="text-secondary">"transaction"</span> <span class="text-danger">: {</span>
                                <span class="text-secondary">"ref_no"</span> <span class="text-danger">: </span> <span class="text-success">ABC123</span>
                                <span class="text-secondary">"operator_id"</span> <span class="text-danger">: </span> <span class="text-success">793</span>
                                <span class="text-secondary">"invoice_id"</span> <span class="text-danger">: </span> <span class="text-success">4</span>
                                <span class="text-secondary">"topup"</span> <span class="text-danger">: </span> <span class="text-success">116.4314187</span>
                                <span class="text-secondary">"amount"</span> <span class="text-danger">: </span> <span class="text-success">1.07</span>
                                <span class="text-secondary">"number"</span> <span class="text-danger">: </span> <span class="text-success">123123123</span>
                                <span class="text-secondary">"sender_currency"</span> <span class="text-danger">: </span> <span class="text-success">CAD</span>
                                <span class="text-secondary">"receiver_currency"</span> <span class="text-danger">: </span> <span class="text-success">PKR</span>
                                <span class="text-secondary">"is_local"</span> <span class="text-danger">: </span> <span class="text-success">false</span>
                                <span class="text-secondary">"updated_at"</span> <span class="text-danger">: </span> <span class="text-success">2021-10-23T10:18:48.000000Z</span>
                                <span class="text-secondary">"created_at"</span> <span class="text-danger">: </span> <span class="text-success">2021-10-23T10:18:47.000000Z</span>
                                <span class="text-secondary">"id"</span> <span class="text-danger">: </span> <span class="text-success">3</span>
                                <span class="text-secondary">"status"</span> <span class="text-danger">: </span> <span class="text-success">PENDING</span>
                                <span class="text-secondary">"message"</span> <span class="text-danger">: </span> <span class="text-success">Transaction is paid. But its pending topup. Please wait a few minuites for the status to update.</span>
                       <span class="text-secondary font-weight-bolder">}</span>
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="api-transaction-id" role="tabpanel" aria-labelledby="transaction-id" aria-expanded="false">
                                    <!-- icon and header -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-tag bg-light-primary mr-1">
                                            <i class="feather icon-send"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0 font-weight-bolder">Get Transactions By Id</h4>
                                            <span>
                                                To get transactions by id a user is required to send a <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">GET</span> call to
                                                <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/transactions/id/{id}</span> route.
                                                This is protected via OAuth 2.0 so requires token to be sent in the header.
                                            </span>
                                        </div>
                                    </div>

                                    <!-- frequent answer and question  collapse  -->
                                    <div class="collapse-margin collapse-icon mt-2" id="api-transaction-id-qna">
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="transactionIdOne" data-toggle="collapse" role="button" data-target="#api-transaction-id-one" aria-expanded="false" aria-controls="api-transaction-id-one">
                                                <span class="lead collapse-title font-weight-bolder">Sample Request</span>
                                            </div>

                                            <div id="api-transaction-id-one" class="collapse bg-light show" aria-labelledby="transactionIdOne" data-parent="#api-transaction-id-qna">
                                                <div class="card-body">
                                                    <pre class="py-2 font-weight-bolder">
    <span class="text-danger font-weight-bolder">curl</span>
            <span class="text-secondary">--location</span>
            <span class="text-secondary">--request GET</span>
                      <span class="text-success">'/api/transactions/id/3'</span>  \
            <span class="text-secondary">--header</span>
                      <span class="text-success">'Authorization: Bearer TOKEN_GOES_HERE'</span>  \
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="transactionIdTwo" data-toggle="collapse" role="button" data-target="#api-transaction-id-two" aria-expanded="false" aria-controls="api-transaction-id-two">
                                                <span class="lead collapse-title font-weight-bolder">Sample Response</span>
                                            </div>
                                            <div id="api-transaction-id-two" class="collapse bg-light" aria-labelledby="transactionIdTwo" data-parent="#api-transaction-id-qna">
                                                <div class="card-body shadow-none">
                                                      <pre class="py-2 font-weight-bolder">
                        <span class="text-secondary font-weight-bolder">{</span>
                                <span class="text-secondary">"message"</span> <span class="text-danger">:</span> <span class="text-success">Transaction created. It will be processed in a few minutes.</span>
                                <span class="text-secondary">"transaction"</span> <span class="text-danger">: {</span>
                                <span class="text-secondary">"ref_no"</span> <span class="text-danger">: </span> <span class="text-success">ABC123</span>
                                <span class="text-secondary">"operator_id"</span> <span class="text-danger">: </span> <span class="text-success">793</span>
                                <span class="text-secondary">"invoice_id"</span> <span class="text-danger">: </span> <span class="text-success">4</span>
                                <span class="text-secondary">"topup"</span> <span class="text-danger">: </span> <span class="text-success">116.4314187</span>
                                <span class="text-secondary">"amount"</span> <span class="text-danger">: </span> <span class="text-success">1.07</span>
                                <span class="text-secondary">"number"</span> <span class="text-danger">: </span> <span class="text-success">123123123</span>
                                <span class="text-secondary">"sender_currency"</span> <span class="text-danger">: </span> <span class="text-success">CAD</span>
                                <span class="text-secondary">"receiver_currency"</span> <span class="text-danger">: </span> <span class="text-success">PKR</span>
                                <span class="text-secondary">"is_local"</span> <span class="text-danger">: </span> <span class="text-success">false</span>
                                <span class="text-secondary">"updated_at"</span> <span class="text-danger">: </span> <span class="text-success">2021-10-23T10:18:48.000000Z</span>
                                <span class="text-secondary">"created_at"</span> <span class="text-danger">: </span> <span class="text-success">2021-10-23T10:18:47.000000Z</span>
                                <span class="text-secondary">"id"</span> <span class="text-danger">: </span> <span class="text-success">3</span>
                                <span class="text-secondary">"status"</span> <span class="text-danger">: </span> <span class="text-success">PENDING</span>
                                <span class="text-secondary">"message"</span> <span class="text-danger">: </span> <span class="text-success">Transaction is paid. But its pending topup. Please wait a few minuites for the status to update.</span>
                       <span class="text-secondary font-weight-bolder">}</span>
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="api-gift_card_products" role="tabpanel" aria-labelledby="gift_card_products" aria-expanded="false">
                                    <!-- icon and header -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-tag bg-light-primary mr-1">
                                            <i class="feather icon-send"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0 font-weight-bolder">Get Gift Card Products</h4>
                                            <span>
                                                To get all gift card products a user is required to send a <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">GET</span> call to
                                                <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/gift_cards/products</span> route.
                                                This is protected via OAuth 2.0 so requires token to be sent in the header.
                                            </span>
                                        </div>
                                    </div>

                                    <!-- frequent answer and question  collapse  -->
                                    <div class="collapse-margin collapse-icon mt-2" id="api-gift_card_products-qna">
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="gift_card_productsOne" data-toggle="collapse" role="button" data-target="#api-gift_card_products-one" aria-expanded="false" aria-controls="api-gift_card_products-one">
                                                <span class="lead collapse-title font-weight-bolder">Sample Request</span>
                                            </div>

                                            <div id="api-gift_card_products-one" class="collapse bg-light show" aria-labelledby="gift_card_productsOne" data-parent="#api-gift_card_products-qna">
                                                <div class="card-body">
                                                    <pre class="py-2 font-weight-bolder">
    <span class="text-danger font-weight-bolder">curl</span>
            <span class="text-secondary">--location</span>
            <span class="text-secondary">--request GET</span>
                      <span class="text-success">'/api/gift_cards/products'</span>  \
            <span class="text-secondary">--header</span>
                      <span class="text-success">'Authorization: Bearer TOKEN_GOES_HERE'</span>  \
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="gift_card_productsTwo" data-toggle="collapse" role="button" data-target="#api-gift_card_products-two" aria-expanded="false" aria-controls="api-gift_card_products-two">
                                                <span class="lead collapse-title font-weight-bolder">Sample Response</span>
                                            </div>
                                            <div id="api-gift_card_products-two" class="collapse bg-light" aria-labelledby="gift_card_productsTwo" data-parent="#api-gift_card_products-qna">
                                                <div class="card-body shadow-none">
                                                      <pre class="py-2 font-weight-bolder">
            <span class="text-secondary font-weight-bolder">[</span>
                        <span class="text-secondary font-weight-bolder">{</span>
                                <span class="text-secondary">"id"</span> <span class="text-danger">:</span> <span class="text-success">1</span>
                                <span class="text-secondary">"title"</span> <span class="text-danger">:</span> <span class="text-success">1-800-PetSupplies</span>
                                                          <span class="text-secondary">"is_global"</span> <span class="text-danger">:</span> <span class="text-success">0</span>
                                                          <span class="text-secondary">"recipient_currency_code"</span> <span class="text-danger">:</span> <span class="text-success">USD</span>
                                                          <span class="text-secondary">"sender_currency_code"</span> <span class="text-danger">:</span> <span class="text-success">CAD</span>
                                                          <span class="text-secondary">"logo_urls"</span> <span class="text-danger">:</span> <span class="text-success">[</span>
                                                          <span class="text-secondary"></span> <span class="text-danger"></span> <span class="text-success">"https://cdn.reloadly.com/giftcards/5daa2b8b-b1ad-4ca6-a34d-a7ce3c14dfaf.jpg"</span>
                                                          <span class="text-secondary">"logo_urls"</span> <span class="text-danger">:</span> <span class="text-success">],</span>
                                                          <span class="text-secondary">"country"</span> <span class="text-danger">:</span> <span class="text-success">{</span>
                                                          <span class="text-secondary">"id"</span> <span class="text-danger">:</span> <span class="text-success">131</span>
                                                          <span class="text-secondary">"iso"</span> <span class="text-danger">:</span> <span class="text-success">US</span>
                                                          <span class="text-secondary">"name"</span> <span class="text-danger">:</span> <span class="text-success">United States</span>
                                                          <span class="text-secondary">"currency_code"</span> <span class="text-danger">:</span> <span class="text-success">USD</span>
                                                          <span class="text-secondary">"currency_name"</span> <span class="text-danger">:</span> <span class="text-success">US Dollar</span>
                                                          <span class="text-secondary">"currency_symbol"</span> <span class="text-danger">:</span> <span class="text-success">$</span>
                                                          <span class="text-secondary"></span> <span class="text-danger"></span> <span class="text-success">}</span>
                                                          <span class="text-secondary">"amounts"</span> <span class="text-danger">:</span> <span class="text-success">{</span>
                                                          <span class="text-secondary">"25.00"</span> <span class="text-danger">:</span> <span class="text-success">31.38</span>
                                                          <span class="text-secondary">"50.00"</span> <span class="text-danger">:</span> <span class="text-success">62.15</span>
                                                          <span class="text-secondary"></span> <span class="text-danger"></span> <span class="text-success">}</span>
                       <span class="text-secondary font-weight-bolder">}</span>
                       <span class="text-secondary font-weight-bolder">,</span>

            <span class="text-secondary font-weight-bolder">]</span>
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="api-gift_card_products_id" role="tabpanel" aria-labelledby="gift_card_products_id" aria-expanded="false">
                                    <!-- icon and header -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-tag bg-light-primary mr-1">
                                            <i class="feather icon-send"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0 font-weight-bolder">Get Gift Card Product By Id</h4>
                                            <span>
                                                To get gift card product by id a user is required to send a <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">GET</span> call to
                                                <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/gift_cards/products/{id}</span> route.
                                                This is protected via OAuth 2.0 so requires token to be sent in the header.
                                            </span>
                                        </div>
                                    </div>

                                    <!-- frequent answer and question  collapse  -->
                                    <div class="collapse-margin collapse-icon mt-2" id="api-gift_card_products-qna">
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="gift_card_productsOne" data-toggle="collapse" role="button" data-target="#api-gift_card_products-one" aria-expanded="false" aria-controls="api-gift_card_products-one">
                                                <span class="lead collapse-title font-weight-bolder">Sample Request</span>
                                            </div>

                                            <div id="api-gift_card_products-one" class="collapse bg-light show" aria-labelledby="gift_card_productsOne" data-parent="#api-gift_card_products-qna">
                                                <div class="card-body">
                                                    <pre class="py-2 font-weight-bolder">
    <span class="text-danger font-weight-bolder">curl</span>
            <span class="text-secondary">--location</span>
            <span class="text-secondary">--request GET</span>
                      <span class="text-success">'/api/gift_cards/products/1'</span>  \
            <span class="text-secondary">--header</span>
                      <span class="text-success">'Authorization: Bearer TOKEN_GOES_HERE'</span>  \
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="gift_card_productsTwo" data-toggle="collapse" role="button" data-target="#api-gift_card_products-two" aria-expanded="false" aria-controls="api-gift_card_products-two">
                                                <span class="lead collapse-title font-weight-bolder">Sample Response</span>
                                            </div>
                                            <div id="api-gift_card_products-two" class="collapse bg-light" aria-labelledby="gift_card_productsTwo" data-parent="#api-gift_card_products-qna">
                                                <div class="card-body shadow-none">
                                                      <pre class="py-2 font-weight-bolder">
                        <span class="text-secondary font-weight-bolder">{</span>
                                <span class="text-secondary">"id"</span> <span class="text-danger">:</span> <span class="text-success">1</span>
                                <span class="text-secondary">"title"</span> <span class="text-danger">:</span> <span class="text-success">1-800-PetSupplies</span>
                                                          <span class="text-secondary">"is_global"</span> <span class="text-danger">:</span> <span class="text-success">0</span>
                                                          <span class="text-secondary">"recipient_currency_code"</span> <span class="text-danger">:</span> <span class="text-success">USD</span>
                                                          <span class="text-secondary">"sender_currency_code"</span> <span class="text-danger">:</span> <span class="text-success">CAD</span>
                                                          <span class="text-secondary">"logo_urls"</span> <span class="text-danger">:</span> <span class="text-success">[</span>
                                                          <span class="text-secondary"></span> <span class="text-danger"></span> <span class="text-success">"https://cdn.reloadly.com/giftcards/5daa2b8b-b1ad-4ca6-a34d-a7ce3c14dfaf.jpg"</span>
                                                          <span class="text-secondary">"logo_urls"</span> <span class="text-danger">:</span> <span class="text-success">],</span>
                                                          <span class="text-secondary">"country"</span> <span class="text-danger">:</span> <span class="text-success">{</span>
                                                          <span class="text-secondary">"id"</span> <span class="text-danger">:</span> <span class="text-success">131</span>
                                                          <span class="text-secondary">"iso"</span> <span class="text-danger">:</span> <span class="text-success">US</span>
                                                          <span class="text-secondary">"name"</span> <span class="text-danger">:</span> <span class="text-success">United States</span>
                                                          <span class="text-secondary">"currency_code"</span> <span class="text-danger">:</span> <span class="text-success">USD</span>
                                                          <span class="text-secondary">"currency_name"</span> <span class="text-danger">:</span> <span class="text-success">US Dollar</span>
                                                          <span class="text-secondary">"currency_symbol"</span> <span class="text-danger">:</span> <span class="text-success">$</span>
                                                          <span class="text-secondary"></span> <span class="text-danger"></span> <span class="text-success">}</span>
                                                          <span class="text-secondary">"amounts"</span> <span class="text-danger">:</span> <span class="text-success">{</span>
                                                          <span class="text-secondary">"25.00"</span> <span class="text-danger">:</span> <span class="text-success">31.38</span>
                                                          <span class="text-secondary">"50.00"</span> <span class="text-danger">:</span> <span class="text-success">62.15</span>
                                                          <span class="text-secondary"></span> <span class="text-danger"></span> <span class="text-success">}</span>
                       <span class="text-secondary font-weight-bolder">}</span>
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="api-order_gift_card" role="tabpanel" aria-labelledby="order_gift_card" aria-expanded="false">
                                    <!-- icon and header -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-tag bg-light-primary mr-1">
                                            <i class="feather icon-send"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0 font-weight-bolder">Order Gift Card Product</h4>
                                            <span>
                                                To order gift card product a user is required to send a <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">POST</span> call to
                                                <span class="badge badge-pill badge-light-primary" style="border-radius: 0;">/api/gift_cards/order</span> route.
                                                This is protected via OAuth 2.0 so requires token to be sent in the header.
                                            </span>
                                        </div>
                                    </div>

                                    <!-- frequent answer and question  collapse  -->
                                    <div class="collapse-margin collapse-icon mt-2" id="api-topup-qna">
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="topupZero" data-toggle="collapse" role="button" data-target="#api-topup-zero" aria-expanded="true" aria-controls="api-topup-one">
                                                <span class="lead collapse-title font-weight-bolder">Fields Supported</span>
                                            </div>

                                            <div id="api-topup-zero" class="collapse bg-light show" aria-labelledby="topupZero" data-parent="#api-topup-qna">
                                                <div class="card-body">
                                                    <ul class="list-style-square my-1">
                                                        <li>product_id</li>
                                                        <li>recipient_email</li>
                                                        <li>amount</li>
                                                        <li>ref</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="topupOne" data-toggle="collapse" role="button" data-target="#api-topup-one" aria-expanded="false" aria-controls="api-topup-one">
                                                <span class="lead collapse-title font-weight-bolder">Sample Request</span>
                                            </div>

                                            <div id="api-topup-one" class="collapse bg-light" aria-labelledby="topupOne" data-parent="#api-topup-qna">
                                                <div class="card-body">
                                                    <pre class="py-2 font-weight-bolder">
    <span class="text-danger font-weight-bolder">curl</span>
            <span class="text-secondary">--location</span>
            <span class="text-secondary">--request POST</span>
                      <span class="text-success">'/api/gift_cards/order'</span>  \
            <span class="text-secondary">--header</span>
                      <span class="text-success">'Authorization: Bearer TOKEN_GOES_HERE'</span>  \
            <span class="text-secondary">--form</span>
                      <span class="text-success">'product_id=1'</span>  \
            <span class="text-secondary">--form</span>
                      <span class="text-success">'recipient_email="abc@email.com"'</span>  \
            <span class="text-secondary">--form</span>
                      <span class="text-success">'amount=31.38'</span>  \
            <span class="text-secondary">--form</span>
                      <span class="text-success">'ref="some_reference_to_Track"'</span>  \
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="box-shadow: none !important;">
                                            <div class="card-header bg-custom" id="topupTwo" data-toggle="collapse" role="button" data-target="#api-topup-two" aria-expanded="false" aria-controls="api-topup-two">
                                                <span class="lead collapse-title font-weight-bolder">Sample Response</span>
                                            </div>
                                            <div id="api-topup-two" class="collapse bg-light" aria-labelledby="topupTwo" data-parent="#api-topup-qna">
                                                <div class="card-body shadow-none">
                                                      <pre class="py-2 font-weight-bolder">
            <span class="text-secondary font-weight-bolder">{</span>
                        <span class="text-success">"success"</span> <span class="text-danger">:</span> <span class="text-secondary font-weight-bolder">{</span>
                                <span class="text-secondary">"message"</span> <span class="text-danger">:</span> <span class="text-success">Transaction created. It will be processed in a few minutes.</span>
                                <span class="text-secondary">"transaction"</span> <span class="text-danger">: {</span>
                                <span class="text-secondary">"email"</span> <span class="text-danger">: </span> <span class="text-success">abc@email.com</span>
                                                          <span class="text-secondary">"invoice_id"</span> <span class="text-danger">: </span> <span class="text-success">32</span>
                                                          <span class="text-secondary">"product_id"</span> <span class="text-danger">: </span> <span class="text-success">1</span>
                                                          <span class="text-secondary">"sender_amount"</span> <span class="text-danger">: </span> <span class="text-success">31.38</span>
                                                          <span class="text-secondary">"recipient_amount"</span> <span class="text-danger">: </span> <span class="text-success">25.00</span>
                                                          <span class="text-secondary">"reference"</span> <span class="text-danger">: </span> <span class="text-success">some_reference_to_Track</span>
                                                          <span class="text-secondary">"updated_at"</span> <span class="text-danger">: </span> <span class="text-success">2021-11-12T08:51:52.000000Z</span>
                                                          <span class="text-secondary">"created_at"</span> <span class="text-danger">: </span> <span class="text-success">2021-11-12T08:51:51.000000Z</span>
                                                          <span class="text-secondary">"id"</span> <span class="text-danger">: </span> <span class="text-success">10</span>
                                                          <span class="text-secondary">"status"</span> <span class="text-danger">: </span> <span class="text-success">PENDING</span>
                       <span class="text-secondary font-weight-bolder">}</span> <span class="text-secondary font-weight-bolder">,</span>

            <span class="text-secondary font-weight-bolder">}</span>
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
                <!-- / frequently asked questions tabs pills -->
@endsection

@push('js')

@endpush
