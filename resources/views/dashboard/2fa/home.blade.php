@extends('dashboard.layout.app')

@section('body-class','1-column bg-full-screen-image  blank-page blank-page')
@section('page-name','2FA Authenticate')

@push('css')
    <link rel="stylesheet" type="text/css" href="/css/pages/authentication.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('content')
    <section class="row flexbox-container">
        <div class="col-xl-8 col-11 d-flex justify-content-center">
            <div class="card bg-authentication rounded-0 mb-0 w-100">
                <div class="row m-0">
                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                        @if((@OTIFSolutions\Laravel\Settings\Models\Setting::get('custom_theme')==true) && (@OTIFSolutions\Laravel\Settings\Models\Setting::get('login_logo')))
                            <img src="{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('login_logo') }}" class="w-100">
                        @else
                            <img src="/assets/images/logo.svg" class="w-100">
                        @endif
                    </div>
                    <div class="col-lg-6 col-12 p-0" style="border-left: 1px solid gray;">
                        <div class="card rounded-0 mb-0 px-2">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">2FA Verify</h4>
                                </div>
                            </div>
                            <p class="px-2">Hi {{ Auth::user()['name'] }}. Please enter your OTP Pin.</p>
                            <div class="card-content">
                                <div class="card-body pt-1 mb-3">
                                    <form action="/2fa/required" method="POST">
                                        @csrf
                                        <input type="hidden" name="return" value="{{ $_GET['return'] }}">
                                        <fieldset class="form-label-group form-group position-relative has-icon-left">
                                            <input type="text" class="form-control" id="code" placeholder="Enter Code" name="code" required>
                                            <div class="form-control-position">
                                                <i class="feather icon-circle"></i>
                                            </div>
                                            <label for="code">Code</label>
                                        </fieldset>
                                        <button data-toggle="post-feed-no" data-feed="/2fa/required/send"  class="btn btn-secondary float-left btn-inline waves-effect waves-light">Resend OTP</button>
                                        <button type="submit" class="btn btn-primary float-right btn-inline waves-effect waves-light">Submit <i class="fa fa-spinner fa-spin d-none"></i></button>
                                    </form>
                                </div>
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
    <script src="/js/general.js"></script>
    <script>
        $(document).on('click', '[data-toggle="post-feed-no"]', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('data-feed'),
                type: 'POST',
                data: {},
                error: function (response) {
                    response = $.parseJSON(response.responseText);
                    $.each(response, function (key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function (key, value) {
                                toastr.error(value, 'Error');
                            });
                        }
                    });
                },
                success: function (response) {
                    if (response.message) {
                        toastr.success(response.message, 'Success');
                    } else {
                        toastr.success('All Done', 'Success');
                    }
                    if (response.location)
                        window.location = response.location;
                }
            });
        });
        $('[data-toggle="post-feed-no"]').click()
    </script>
@endpush
