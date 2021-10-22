<form class="form" action="/ip_restriction" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ @$item['id'] }}">
    <div class="modal-header">
        <div class="col row justify-content-center align-items-center">
            <h4 class="modal-title" id="modal_title"><i class="fa fa-circle"></i> IP Modal</h4>
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
                        <input type="text" id="ip" class="form-control" placeholder="Enter Ip Address" name="ip" value="{{ @$item['ip'] }}">
                        <div class="form-control-position">
                            <i class="fa fa-circle"></i>
                        </div>
                        <label for="ip">IP Address</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save <i class="fa fa-spinner fa-spin d-none"></i></button>
    </div>
</form>
