<div class="modal-header">
    <div class="col row justify-content-center align-items-center">
        <h4 class="modal-title" id="modal_title"><i class="feather icon-credit-card"></i> Checkout Via Stripe</h4>
    </div>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="form-body mx-2">
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <tbody>
                    <tr>
                        <td>Invoice Id</td>
                        <td class="text-center">{{ $invoice['id'] }}</td>
                    </tr>
                    <tr>
                        <td>Total Amount</td>
                        <td class="text-center">{{ $invoice['amount'].' '.$invoice['currency_code'] }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12 mb-2">
                <p class="text-center">Payment processed via Stripe.<br>We do not store any credit card information.</p>
            </div>
            <div class="col-12">
                <div class="row align-items-center justify-content-center">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ sizeof($invoice['user']['stripe_payment_methods']) > 0?'':'active' }}" data-toggle="tab" href="#add_new" aria-controls="add_new" role="tab" aria-selected="true">Add New Card</a>
                        </li>
                        @if(sizeof($invoice['user']['stripe_payment_methods']) > 0)
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#existing_cards" aria-controls="existing_cards" role="tab" aria-selected="false">Existing Cards</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="tab-content col-12 mt-1">
                <div class="row tab-pane {{ sizeof($invoice['user']['stripe_payment_methods']) > 0?'':'active' }}" id="add_new" role="tabpanel">
                    <div class="col-12">
                        <div id="card-element"></div>
                        <div id="card-errors" role="alert"></div>
                    </div>
                </div>
                @if(sizeof($invoice['user']['stripe_payment_methods']) > 0)
                <div class="row tab-pane active" id="existing_cards" role="tabpanel">
                    <div class="col-12">
                        <div class="form-label-group position-relative">
                            <select id="cards" name="cards" class="form-control">
                                @foreach($invoice['user']['stripe_payment_methods'] as $card)
                                    <option value="{{ $card['stripe_id'] }}" >{{ $card['name']. ' Expiry '.$card['exp_month'].'/'.$card['exp_year'] }}</option>
                                @endforeach
                            </select>
                            <label for="cards">Cards</label>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button id="submit_payment" class="btn btn-primary">Pay <i class="fa fa-spinner fa-spin d-none"></i></button>
</div>

<script>
    var stripe = null;
    stripe = Stripe("{{ @OTIFSolutions\Laravel\Settings\Models\Setting::get('stripe_publishable_key') }}");
    var elements = stripe.elements();
    // Set up Stripe.js and Elements to use in checkout form
    var style = {
        base: {
            color: "#32325d",
        }
    };
    var card = elements.create("card", { style: style });
    card.mount("#card-element");
    $('#submit_payment').on('click',function (e) {
        e.preventDefault();
        $('body').LoadingOverlay("show");
        var method = {
            card: card
        };
        if ($('.modal-body ul.nav.nav-pills li a.active').attr('href') === "#existing_cards"){
            method = $('select#cards').val();
        }else{
            method = {
                card: card
            };
        }
        stripe.confirmCardPayment("{{ $invoice['payment_intent_response']['client_secret'] }}", {
            payment_method: method,
            setup_future_usage: 'off_session'
        }).then(function(result) {
            if (result.error) {
                $('body').LoadingOverlay("hide");
                toastr.error(result.error.message,'Error');
            } else {
                if (result.paymentIntent.status === 'succeeded') {
                    toastr.success('Payment Processed. Please wait.','Success');
                    $.ajax({
                        type: 'POST',
                        url: '/checkout/stripe/response',
                        data: JSON.stringify(result.paymentIntent),
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function (response) {
                            $('body').LoadingOverlay("hide");
                            toastr.success(response.message);
                            window.location = response.location;
                        },
                        error: function (response) {
                            $('body').LoadingOverlay("hide");
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
            }
        });
    });
</script>
