<div class="modal-header">
    <div class="col row justify-content-center align-items-center">
        <h4 class="modal-title" id="modal_title"><i class="feather icon-star"></i> Promotion</h4>
    </div>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="form-body mx-2">
        <div class="row justify-content-center">
            <div class="col-auto">{{  @$item['title'] }}</div>
        </div>
        <div class="row justify-content-center">
            <div class="col-auto">{{  @$item['title2'] }}</div>
        </div>
        <div class="row">
            <div class="col-12">
                {!!  @$item['description'] !!}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">

</div>
