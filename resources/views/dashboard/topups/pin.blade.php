<div class="modal-header">
    <div class="col row justify-content-center align-items-center">
        <h4 class="modal-title" id="modal_title"><i class="feather icon-hash"></i> Pin Details</h4>
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
                        <th>Serial</th>
                        <th>Info1</th>
                        <th>Info2</th>
                        <th>Info3</th>
                        <th>Value</th>
                        <th>Code</th>
                        <th>IVR</th>
                        <th>Validity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ @$topup['pin']['serial'] }}</td>
                        <td>{{ @$topup['pin']['info1'] }}</td>
                        <td>{{ @$topup['pin']['info2'] }}</td>
                        <td>{{ @$topup['pin']['info3'] }}</td>
                        <td>{{ @$topup['pin']['value'] }}</td>
                        <td>{{ @$topup['pin']['code'] }}</td>
                        <td>{{ @$topup['pin']['ivr'] }}</td>
                        <td>{{ @$topup['pin']['validity'] }}</td>
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
