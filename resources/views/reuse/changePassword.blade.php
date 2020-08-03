

<!-- MAIN CONTENT-->
<div class="main-content bg-white" style="padding-top: 6% !important;">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12 shadow">
                    <div class="card border-0">
                        <div class="card-body p-4">
                            <div class="card-title">
                                <h3 class="text-center title-2 mt-1 font-weight-bold">Change Password</h3>
                            </div>
                            <hr>
                            @if($user_type == 'buyer')
                            <form action="{{ route('changeBuyerPassword') }}" method="POST" enctype="multipart/form-data"
                                  novalidate="novalidate">
                            @elseif($user_type == 'seller')
                                    <form action="{{ route('changeSellerPassword') }}" method="POST" enctype="multipart/form-data"
                                          novalidate="novalidate">
                                @endif
                                <div class="form-group">
                                    <label for="password" class="control-label mb-1 mt-2 font-weight-bold">New Password</label>
                                    <input id="password" name="password" type="password"
                                           class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" aria-required="true"
                                           aria-invalid="false"
                                           placeholder="New Password"
                                    >
                                    @if ($errors->has('password'))
                                        <span class="text-danger">
                                            <small>{{ $errors->first('password') }}</small>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group has-success">
                                    <label for="confirm_password" class="control-label mb-1 mt-1 font-weight-bold">Confirm Password</label>
                                    <input id="confirm_password" name="confirm_password" type="password"
                                           class="form-control cc-name valid {{ $errors->has('confirm_password') ? ' is-invalid' : '' }}" required
                                           placeholder="Confim New Password">
                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                                    @if ($errors->has('confirm_password'))
                                        <span class="text-danger">
                                            <small>{{ $errors->first('confirm_password') }}</small>
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-5">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-lg"
                                                style="width: 50%; border-radius: 12px; background-color: #111111; color:white">Confirm
                                        </button>
                                    </div>
                                </div>

                                <input type="hidden" name="_token" value={{csrf_token()}}>
                            </form>
                        </div>
                    </div>
                </div>
                @if (session()->has('password_mismatch_message'))
                    <div class="col-10" style="padding-left: 20%">
                        <div class="card bg-danger">
                            <div class="card-body">
                                <p class="text-light" style="padding-left: 20%">{{session('password_mismatch_message')}}</p>
                            </div>
                        </div>
                    </div>
                @elseif (session()->has('password_mismatch_message_seller'))
                    <div class="col-10" style="padding-left: 20%">
                        <div class="card bg-danger">
                            <div class="card-body">
                                <p class="text-light" style="padding-left: 20%">{{session('password_mismatch_message_seller')}}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTAINER-->







