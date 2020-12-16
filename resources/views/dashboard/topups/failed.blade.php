<div class="modal-header">
    <div class="col row justify-content-center align-items-center">
        <h4 class="modal-title" id="modal_title"><i class="feather icon-hash"></i> Status Details</h4>
    </div>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="form-body mx-2">
        <div class="table-responsive">
            <table class="table modal-zero-configuration">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Operator</td>
                        <td><img src="{{ $topup['operator']['country']['flag'] }}" width="20px" class="mr-1">
                            {{ $topup['operator']['country']['name'].' '.$topup['file_entry']['operator']['name'] }}
                        </td>
                    </tr>
                    <tr>
                        <td>Number</td>
                        <td>{{ $topup['number'] }}</td>
                    </tr>
                    <tr>
                        <td>Amount</td>
                        <td>{{ number_format($topup['topup'],2).' '.$topup['operator']['destination_currency_code'] }}</td>
                    </tr>
                    <tr>
                        <td>Error Message</td>
                            <td>{{ @$topup['response']['message'] }}</td>
                    </tr>
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
