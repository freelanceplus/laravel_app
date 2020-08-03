@extends('app')

@section('content')

    <body class="animsition" style="animation-duration: 900ms; opacity: 1;">
    <div class="page-wrapper bg-white">

        @include('reuse.navbarDesktopBuyer');
        @include('reuse.adminSidebar');

        <!-- PAGE CONTAINER-->
        <div class="page-container">


            <!-- MAIN CONTENT-->
            <div class="main-content bg-white">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12  shadow">
                                <div class="card p-4 pb-0 border-0">

                                    <div class="card-body">
                                        <div class="card-title">
                                            <h3 class="text-center title-2">Assign <strong>{{ $order_details->title }}</strong> to
                                                <strong>{{ $seller_name }}</strong>
                                            </h3>
                                        </div>
                                        <hr>
                                        <form class="mt-5" action="{{ url('/admin/assignProjectToSeller') }}" method="POST" novalidate="novalidate">
                                            <div class="form-group">
                                                <label for="deadline" class="control-label mb-1">Deadline</label>
                                                <input id="deadline" name="deadline" type="date" value="{{ $order_details->deadline }}"
                                                       class="form-control {{ $errors->has('deadline') ? ' is-invalid' : '' }}" aria-required="true"
                                                       aria-invalid="false">
                                                @if ($errors->has('deadline'))
                                                    <span class="text-danger">
                                                        <small>{{ $errors->first('deadline') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="budget" class="control-label mb-1">Budget</label>
                                                <input id="budget" name="budget" type="text" value="{{ $order_details->budget }}"
                                                       class="form-control {{ $errors->has('budget') ? ' is-invalid' : '' }}" aria-required="true"
                                                       aria-invalid="false">
                                                @if ($errors->has('budget'))
                                                    <span class="text-danger">
                                                        <small>{{ $errors->first('budget') }}</small>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-lg"
                                                        style="width: 50%; border-radius: 12px; background-color: #000000; color:white">ASSIGN
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


