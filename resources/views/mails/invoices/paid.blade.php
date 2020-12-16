Dear {{$invoice['user']['name']}},<br>
<br>
An Invoice has been paid. Bellow are the details for the Invoice.<br>
<br>
INVOICE NO. : {{ $invoice['id'] }}<br>
INVOICE DATE : {{ \Carbon\Carbon::parse($invoice['created_at'])->format('Y-m-d H:m') }}<br><br>
STATUS : {{ $invoice['status'] }}<br><br>
SUBTOTAL : {{$invoice['amount'].' '.$invoice['currency_code']}}<br>
DISCOUNT (0%) : 0.00 {{ $invoice['currency_code'] }}<br>
TOTAL : {{$invoice['amount'].' '.$invoice['currency_code']}}<br>
<br>
Your order for the invoice will be processed shortly.
<br>
Kind Regards,<br>
{{ env('APP_NAME','SYSTEM EMAIL') }}
