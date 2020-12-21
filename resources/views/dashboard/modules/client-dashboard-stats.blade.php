@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css"/>
    <style>
        .iti{
            display: block !important;
        }
    </style>
    @if(@OTIFSolutions\Laravel\Settings\Models\Setting::get('reloadly_api_token') && sizeof($stats['countries']) > 0)
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link rel="stylesheet" type="text/css" href="/css/app/app.css">
    @endif
@endpush

<section id="statistics-card">
    <div class="row justify-content-center">
        @if(Auth::user()['user_role']['name'] === 'RESELLER' || Auth::user()['user_role']['name'] === 'CLIENT')
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="avatar bg-rgba-success p-50 m-0 mb-1">
                                <div class="avatar-content">
                                    <i class="fa fa-money text-success font-medium-5"></i>
                                </div>
                            </div>
                            <h4 class="text-bold-700">{{ (isset(Auth::user()['balance_value']) && Auth::user()['balance_value'] != ''?number_format(Auth::user()['balance_value'],2).' ':0.00).' '.@OTIFSolutions\Laravel\Settings\Models\Setting::get('reloadly_currency') }}</h4>
                            <p class="mb-0 line-ellipsis">Balance</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-globe text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{ count($stats['countries']) }}</h2>
                        <p class="mb-0 line-ellipsis">Countries</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-danger p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-compass text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{ $stats['operators'] }}</h2>
                        <p class="mb-0 line-ellipsis">Operators</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-codepen text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{ $stats['topups'] }}</h2>
                        <p class="mb-0 line-ellipsis">Topups</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-secondary p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-file-text text-secondary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{ $stats['invoices'] }}</h2>
                        <p class="mb-0 line-ellipsis">Invoices</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-success p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-credit-card text-success font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{ $stats['cards'] }}</h2>
                        <p class="mb-0 line-ellipsis">Cards</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6 col-12">
            <div id="app">
                <div class="card">
                    <div class="card-header align-items-center">
                        <h4 class="card-title"><i class="feather icon-globe"></i> Send Topup</h4>
                    </div>
                    <send-topup int_input="{{ App\Models\Country::GetForInputField() }}" v-bind:send="'{{$stats['send']}}'" v-bind:token="'{{$stats['token']}}'"></send-topup>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-primary p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-codepen text-primary font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1 mb-25">{{ number_format($stats['topups_total'],2).' '.@OTIFSolutions\Laravel\Settings\Models\Setting::get('reloadly_currency') }}</h2>
                    <p class="mb-0">Total Topups Sent</p>
                </div>
                <div class="card-content">
                    <div id="topup-gain-chart"></div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('js')
    <script src="/js/pages/apexcharts.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    @if(@OTIFSolutions\Laravel\Settings\Models\Setting::get('reloadly_api_token') && sizeof($stats['countries']) > 0)
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="/js/app.js"></script>

        <script>
            $(document).on('click','a[href="#tabs-amount"]',function(){
                $('#select_amount').attr('disabled',false);
            });
        </script>
    @endif
    <script>
        var chartConfig = {
            chart: {
                height: 100,
                type: 'area',
                toolbar: {
                    show: false,
                },
                sparkline: {
                    enabled: true
                },
                grid: {
                    show: false,
                    padding: {
                        left: 0,
                        right: 0
                    }
                },
            },
            colors: ['#7367F0'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2.5
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 0.9,
                    opacityFrom: 0.7,
                    opacityTo: 0.5,
                    stops: [0, 80, 100]
                }
            },
            series: [],
            noData: {
                text: 'Not Enough Data'
            },

            xaxis: {
                labels: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                }
            },
            yaxis: [{
                y: 0,
                offsetX: 0,
                offsetY: 0,
                padding: { left: 0, right: 0 },
            }],
            tooltip: {
                x: { show: false }
            },
        };
        var topUpChart = new ApexCharts(
            document.querySelector("#topup-gain-chart"),
            chartConfig
        );
        topUpChart.render();
        $.getJSON('/dashboard/stats/topups/amounts', function(response) {
            topUpChart.updateSeries([{
                name: 'Topups',
                data: response
            }])
        });
    </script>
@endpush
