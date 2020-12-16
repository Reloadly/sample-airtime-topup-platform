Dear {{$invoice['user']['name']}},<br>
<br>
An Invoice has been created for your order. Bellow are the details for the Invoice.<br>
<br>
INVOICE NO. : {{ $invoice['id'] }}<br>
INVOICE DATE : {{ \Carbon\Carbon::parse($invoice['created_at'])->format('Y-m-d H:m') }}<br>
<br>
<table>
    <thead>
    <tr>
        <th>TOPUP</th>
        <th>AMOUNT</th>
        <th>RATE</th>
        <th>TOTAL</th>
    </tr>
    </thead>
    <tbody>
        @foreach($invoice['topups'] as $topup)
            <tr>
                <td>{{ $topup['operator']['name'].' '.$topup['number'] }}</td>
                <td>{{ (number_format($topup['topup'],2)).' '.$topup['receiver_currency'] }}</td>
                <td>{{ number_format($topup['topup']/($invoice['amount']/sizeof($invoice['topups'])),2) }}</td>
                <td>{{ number_format($invoice['amount']/sizeof($invoice['topups']),2).' '.$invoice['currency_code'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table><br>
<br>
SUBTOTAL : {{$invoice['amount'].' '.$invoice['currency_code']}}<br>
DISCOUNT (0%) : 0.00 {{ $invoice['currency_code'] }}<br>
TOTAL : {{$invoice['amount'].' '.$invoice['currency_code']}}<br>
<br>
<br>
Kind Regards,<br>
{{ env('APP_NAME','SYSTEM EMAIL') }}
