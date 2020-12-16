<form class="form" action="account/balance/create" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ @$item['id'] }}">
    <div class="modal-header">
        <div class="col row justify-content-center align-items-center">
            <h4 class="modal-title" id="modal_title"><i class="fa fa-money"></i> Add Funds</h4>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-body mx-2">
            <div class="row">
                <div class="col-12">
                    <div class="form-label-group position-relative input-group">
                        <div class="input-group-prepend">
                            <select class="custom-select form-control" name="currency">
                                <option value="{{$currency}}">{{ $currency }}</option>
                            </select>
                        </div>
                        <input id="amount" class="form-control" type="number" name="amount" step="any" placeholder="User" value="10.00">
                        <label for="amount">Amount</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Create Invoice</button>
    </div>
</form>
