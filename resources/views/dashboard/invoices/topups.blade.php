<div class="modal-header">
    <div class="col row justify-content-center align-items-center">
        <h4 class="modal-title" id="modal_title"><i class="feather icon-codepen"></i> Topup Details</h4>
    </div>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="form-body mx-2">
        <div class="table-responsive col-12">
            <table class="table table-borderless">
                <thead>
                <tr>
                    <th>Topup Id</th>
                    <th>TOPUP</th>
                    <th>Is Local</th>
                    <th>AMOUNT</th>
                    <th>RATE</th>
                    <th>TOTAL</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoice['topups'] as $topup)
                    <tr>
                        <td>{{ $topup['id'] }}</td>
                        <td>{{($topup['operator']['name']).' '.$topup['number']}}</td>
                        <td>
                            @if($topup['is_local'])
                                <div class="badge badge-pill badge-warning pl-1 pr-1">Yes</div>
                            @else
                                <div class="badge badge-pill badge-primary pl-1 pr-1">No</div>
                            @endif
                        </td>
                        <td>{{(number_format($topup['topup'],2)).' '.$topup['receiver_currency'] }}</td>
                        <td>{{ number_format($topup['topup']/($invoice['amount']/count($invoice['topups'])),2) }}</td>
                        <td>{{ number_format($invoice['amount']/count($invoice['topups']),2).' '.$invoice['currency_code'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $('.modal-zero-configuration').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching":     false
    });
</script>
