<form class="form" action="/invoices" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ @$item['id'] }}">
    <div class="modal-header">
        <div class="col row justify-content-center align-items-center">
            <h4 class="modal-title" id="modal_title"><i class="feather icon-hash"></i>Invoice Modal</h4>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-body mx-2">
            <div class="row">
                <div class="col-12">
                    <div class="form-label-group position-relative has-icon-left">
                        <input id="user" class="form-control" type="text" disabled placeholder="User" value="{{ @$item['user']['email'] }}">
                        <div class="form-control-position">
                            <i class="feather icon-hash"></i>
                        </div>
                        <label for="user">User</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-label-group position-relative has-icon-left">
                        <input id="amount" class="form-control" type="number" name="amount" step="any" placeholder="User" value="{{ @$item['amount'] }}">
                        <div class="form-control-position">
                            <i class="feather icon-hash"></i>
                        </div>
                        <label for="amount">Amount</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-label-group position-relative">
                        <select id="status" name="status" class="form-control">
                            <option value="PENDING" {{ @$item['status'] == 'PENDING'?'selected':'' }}>Pending</option>
                            <option value="PAID" {{ @$item['status'] == 'PAID'?'selected':'' }}>Paid</option>
                            <option value="FAIL" {{ @$item['status'] == 'FAIL'?'selected':'' }}>Failed</option>
                            <option value="CANCELLED" {{ @$item['status'] == 'CANCELLED'?'selected':'' }}>Cancelled</option>
                        </select>
                        <label for="status">Status</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
