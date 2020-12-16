Dear {{$invoice['user']['name']}},<br>
<br>
An Invoice payment failed. We tried to bill you but count not make a successful payment. Bellow are the details for the Invoice.<br>
<br>
INVOICE NO. : {{ $invoice['id'] }}<br>
INVOICE DATE : {{ \Carbon\Carbon::parse($invoice['created_at'])->format('Y-m-d H:m') }}<br><br>
STATUS : {{ $invoice['status'] }}<br><br>
SUBTOTAL : {{$invoice['amount'].' '.$invoice['currency_code']}}<br>
DISCOUNT (0%) : 0.00 {{ $invoice['currency_code'] }}<br>
TOTAL : {{$invoice['amount'].' '.$invoice['currency_code']}}<br>
<br>
You can login to the dashboard to pay the invoice manually using any of our payment methods.
<br>
Kind Regards,<br>
{{ env('APP_NAME','SYSTEM EMAIL') }}
