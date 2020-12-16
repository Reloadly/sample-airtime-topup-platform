<form class="form" action="{{$url}}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ @$item['id'] }}">
    <div class="modal-header">
        <div class="col row justify-content-center align-items-center">
            <h4 class="modal-title" id="modal_title"><i class="{{$icon}}"></i> {{$name}} Modal</h4>
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
                        <input type="text" id="first-name-floating-icon" class="form-control" placeholder="Full Name" name="name" value="{{ @$item['name'] }}">
                        <div class="form-control-position">
                            <i class="feather icon-user"></i>
                        </div>
                        <label for="first-name-floating-icon">Full Name</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-label-group position-relative has-icon-left">
                        <input type="email" id="email-id-floating-icon" class="form-control {{ $item?'disabled':'' }}" name="email" placeholder="Email" value="{{ @$item['email'] }}" {{ $item?'disabled':'' }}>
                        <div class="form-control-position">
                            <i class="feather icon-mail"></i>
                        </div>
                        <label for="email-id-floating-icon">Email</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-label-group position-relative has-icon-left">
                        <input type="text" id="username-id-floating-icon" class="form-control {{ $item?'disabled':'' }}" name="username" placeholder="Username" value="{{ @$item['username'] }}" {{ $item?'disabled':'' }}>
                        <div class="form-control-position">
                            <i class="feather icon-hash"></i>
                        </div>
                        <label for="username-id-floating-icon">Username</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-label-group position-relative has-icon-left">
                        <input type="text" id="phone-id-floating-icon" class="form-control {{ $item?'disabled':'' }}" name="phone" placeholder="Phone" value="{{ @$item['phone'] }}" {{ $item?'disabled':'' }}>
                        <div class="form-control-position">
                            <i class="feather icon-hash"></i>
                        </div>
                        <label for="phone-id-floating-icon">Phone</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-label-group position-relative has-icon-left">
                        <input type="password" id="first-name-floating-icon" class="form-control" placeholder="Password" name="password" value="">
                        <div class="form-control-position">
                            <i class="feather icon-lock"></i>
                        </div>
                        <label for="first-name-floating-icon">Password</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-label-group position-relative has-icon-left">
                        <input type="password" id="email-id-floating-icon" class="form-control" name="confirm_password" placeholder="Confirm Password" value="">
                        <div class="form-control-position">
                            <i class="feather icon-lock"></i>
                        </div>
                        <label for="email-id-floating-icon">Confirm Password</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save <i class="fa fa-spinner fa-spin d-none"></i></button>
    </div>
</form>
