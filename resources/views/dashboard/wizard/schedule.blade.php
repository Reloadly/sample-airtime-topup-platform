@extends('dashboard.layout.app')

@section('body-class','2-column')
@section('page-name','Send Topup')

@push('css')
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="/css/pages/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="/css/pages/pickadate.css">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header justify-content-center align-items-center">
                    <h4 class="card-title"><i class="feather icon-clock"></i> Set Schedule Details</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <form method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-5 col-12">
                                    <div class="form-label-group position-relative has-icon-left">
                                        <select class="form-control" name="timezone">
                                            @foreach($timezones as $timezone)
                                                <option value="{{$timezone['id']}}">{{ $timezone['name'] }}</option>
                                            @endforeach
                                        </select>
                                        <div class="form-control-position">
                                            <i class="feather icon-globe"></i>
                                        </div>
                                        <label for="timezone-field">Timezone</label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-label-group position-relative has-icon-left">
                                        <input type="text" id="date-field" class="form-control pickadate" placeholder="Select Date" name="date">
                                        <div class="form-control-position">
                                            <i class="feather icon-calendar"></i>
                                        </div>
                                        <label for="date-field">Date</label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-label-group position-relative has-icon-left">
                                        <input type="text" id="time-field" class="form-control pickatime" placeholder="Select Time" name="time">
                                        <div class="form-control-position">
                                            <i class="feather icon-clock"></i>
                                        </div>
                                        <label for="time-field">Time</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-auto">
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" value="true" name="schedule_now">
                                        <span class="vs-checkbox">
                                      <span class="vs-checkbox--check">
                                        <i class="vs-icon feather icon-check"></i>
                                      </span>
                                    </span>
                                        <span class="">Schedule Now ?</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Submit <i class="fa fa-spinner fa-spin d-none"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header justify-content-center align-items-center">
                        <h4 class="card-title"><i class="feather icon-codepen"></i> Estimate Topup Details</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Country / Operator</th>
                                        <th>Number</th>
                                        <th>Amount</th>
                                        <th>Topup</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($file['numbers'] as $number)
                                        <tr>
                                            <td>
                                                <img src="{{ $number['country']['flag'] }}" width="20px" class="mr-1">
                                                {{ $number['country']['name'].' '.$number['operator']['name'] }}
                                            </td>
                                            <td>{{ $number['number'] }}</td>
                                            <td>{{ $number['estimates']['amount'] }}</td>
                                            <td>{{ $number['estimates']['topup'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th># {{sizeof($file['numbers'])}}</th>
                                        <th>{{ $file['total_amount'].' '.@OTIFSolutions\Laravel\Settings\Models\Setting::get('reloadly_currency') }}</th>
                                        <th>---</th>
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
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/js/datatable/pdfmake.min.js"></script>
    <script src="/js/datatable/vfs_fonts.js"></script>
    <script src="/js/datatable/datatables.min.js"></script>
    <script src="/js/datatable/datatables.buttons.min.js"></script>
    <script src="/js/datatable/buttons.html5.min.js"></script>
    <script src="/js/datatable/buttons.print.min.js"></script>
    <script src="/js/datatable/buttons.bootstrap.min.js"></script>
    <script src="/js/datatable/datatables.bootstrap4.min.js"></script>
    <script src="/js/pickadate/picker.js"></script>
    <script src="/js/pickadate/picker.date.js"></script>
    <script src="/js/pickadate/picker.time.js"></script>
    <script src="/js/pickadate/legacy.js"></script>
    <script>
        $('.pickadate').pickadate({
            format: 'yyyy-mm-dd'
        });
        $('.pickatime').pickatime();
    </script>
@endpush
