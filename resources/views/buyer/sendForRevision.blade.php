@extends('app')
@section('content')

    <body class="animsition" style="animation-duration: 900ms; opacity: 1;">
    <div class="page-wrapper bg-white">

        {{--        @include('reuse.navbar');--}}
        @include('reuse.navbarDesktopBuyer')
        @include('reuse.buyerSidebar')

        <!-- PAGE CONTAINER-->
        <div class="page-container bg-white">


            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 shadow">
                                <div class="card border-0 pt-4 pr-4 pl-4">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h3 class="text-center title-2">Revise <strong>{{ $order_details->title }}</h3>
                                        </div>
                                        <hr>
                                        <form action="{{ route('buyerReviseProject', $order_id) }}" method="POST" novalidate="novalidate">
                                            <div class="form-group">
                                                <label for="remarks" class="control-label mb-1 mt-1">Remarks</label>
                                                <textarea name="remarks" id="remarks" rows="4" placeholder="" class="form-control"></textarea>
                                                <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                                                @if ($errors->has('remarks'))
                                                    <span class="text-danger">
                                                        <small>{{ $errors->first('remarks') }}</small>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-lg"
                                                        style="width: 50%; border-radius: 12px; background-color: #02a8d5; color:white">REVISE
                                                </button>
                                            </div>
                                            <input type="hidden" name="_token" value={{csrf_token()}}>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTAINER-->

    </div>


    <!-- end document-->
    </body>


@endsection





