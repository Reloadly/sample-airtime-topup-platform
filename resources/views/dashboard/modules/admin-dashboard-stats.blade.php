@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="/css/dashboard-analytics.css">
    <style>
        .bg-analytics .img-left {
            width : 200px;
            position : absolute;
            top : 0;
            left : 0;
        }

        .bg-analytics .img-right {
            width : 175px;
            position : absolute;
            top : 0;
            right : 0;
        }

        .bg-analytics .avatar {
            margin-bottom : 2rem;
        }

        .bg-analytics table tr th:first-child, .bg-analytics table tr td:first-child {
            padding-left : 2rem;
        }

        .bg-analytics table tr th:last-child, .bg-analytics table tr td:last-child {
            padding-right : 2rem;
        }

        .bg-analytics table td {
            padding : 0.75rem;
        }

        @media only screen and (max-width: 576px) {
            .bg-analytics .img-left, .bg-analytics .img-right {
                width : 140px;
            }
        }
    </style>
@endpush

<section id="dashboard-analytics">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card bg-analytics text-white">
                <div class="card-content">
                    <div class="card-body text-center">
                        <img src="/assets/images/decore-left.png" class="img-left">
                        <img src="/assets/images/decore-right.png" class="img-right">
                        <div class="avatar avatar-xl bg-primary shadow mt-0">
                            <div class="avatar-content">
                                <i class="feather icon-award white font-large-1"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <h1 class="mb-2 text-white">Congratulations {{ Auth::user()['name'] }},</h1>
                            <p class="m-auto w-75">You have gone Live. Here are a few stats to get you going through the day.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
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
    <div class="row justify-content-center">
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-align-justify text-info font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{ $stats['balance'] }}</h2>
                        <p class="mb-0 line-ellipsis">Balance</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-globe text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{ $stats['countries'] }}</h2>
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
                        <div class="avatar bg-rgba-secondary p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-users text-secondary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{ $stats['users'] }}</h2>
                        <p class="mb-0 line-ellipsis">Users</p>
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
    </div>
</section>

@push('js')
    <script src="/js/pages/apexcharts.min.js"></script>
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
