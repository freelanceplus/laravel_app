@extends('app')

@section('content')

    <body class="animsition " style="animation-duration: 900ms; opacity: 1;">
    <div class="page-wrapper bg-white">

        @include('reuse.adminSidebar');

        <!-- PAGE CONTAINER-->
        <div class="page-container">


            @include('reuse.navbarDesktopBuyer');

            <!-- MAIN CONTENT-->
            <div class="main-content bg-white" style="padding-top: 6% !important;">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 shadow">
                                <div class="card border-0">
                                    <div class="card-body p-4">
                                        <div class="card-title">
                                            <h3 class="text-center title-2 mt-1 font-weight-bold">Add Skill</h3>
                                        </div>
                                        <hr>
                                        <form action="{{ route('addSkill') }}" method="POST" enctype="multipart/form-data"
                                              novalidate="novalidate">
                                            <div class="form-group">
                                                <label for="skill" class="control-label mb-1 mt-2 font-weight-bold">Skill Name</label>
                                                <input id="skill" name="skill" type="text"
                                                       class="form-control {{ $errors->has('skill') ? ' is-invalid' : '' }}" aria-required="true"
                                                       aria-invalid="false">
                                                @if ($errors->has('skill'))
                                                    <span class="text-danger">
                                                        <small>{{ $errors->first('skill') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="mt-5">
                                                <div class="col-md-12 text-center">
                                                    <button type="submit" class="btn btn-lg"
                                                            style="width: 50%; border-radius: 12px; background-color: #111111; color:white">Add Skill
                                                    </button>
                                                </div>
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
            <!-- END PAGE CONTAINER-->

        </div>

    </div>
    <!-- end document-->
    </body>


@endsection


