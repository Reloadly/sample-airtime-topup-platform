<div class="modal-header">
    <div class="col row justify-content-center align-items-center">
        <h4 class="modal-title" id="modal_title"><i class="feather icon-credit-card"></i> Add New Card</h4>
    </div>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="form-body mx-2">
        <div class="row">
            <div class="col-12 mb-2">
                <p class="text-center">All private details handled via Stripe.<br>We do not store any credit card information.</p>
            </div>
            <div class="col-12">
                <div id="card-element"></div>
                <div id="card-errors" role="alert"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button id="submit_payment" class="btn btn-primary">Pay <i class="fa fa-spinner fa-spin d-none"></i></button>
</div>

<script>
    var stripe = Stripe("{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('stripe_publishable_key') }}");
    var elements = stripe.elements();
    var card = elements.create("card");
    card.mount("#card-element");
    $('#submit_payment').on('click',function (e) {
        e.preventDefault();
        $('#submit_payment i').removeClass('d-none');
        $('#submit_payment').prop('disabled', true);
        stripe.confirmCardSetup("{{ $intent->client_secret }}",
            {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: "{{ Auth::user()['name'] }}",
                    },
                },
            }
        ).then(function(result) {
            if (result.error) {
                toastr.error(result.error.message,'Error');
            } else {
                toastr.success('Card Added Successfully. Please wait.','Success');
                $.ajax({
                    type: 'POST',
                    url: '/billings/stripe/sync',
                    data: '',
                    success: function (response) {
                        $('#submit_payment i').addClass('d-none');
                        $('#submit_payment').prop('disabled', false);
                        toastr.success(response.message);
                        window.location = response.location;
                    },
                    error: function (response) {
                        $('#submit_payment i').addClass('d-none');
                        $('#submit_payment').prop('disabled', false);
                        response = $.parseJSON(response.responseText);
                        $.each(response, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    toastr.error(value, 'Error');
                                });
                            }
                        });
                    }
                });
            }
        });
    });
</script>
