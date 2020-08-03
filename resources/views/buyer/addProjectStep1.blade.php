@extends('app')

@section('content')

    <body class="animsition" style="animation-duration: 900ms; opacity: 1;">
    <div class="page-wrapper bg-white">
        @include('reuse.navbarDesktopBuyer')
        @include('reuse.buyerSidebar')

        <!-- PAGE CONTAINER-->
        <div class="page-container">



            <!-- MAIN CONTENT-->
            <div class="main-content bg-white" style="padding-top: 8% !important;">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 shadow ">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h3 class="text-center title-2">Step 1</h3>
                                        </div>
                                        <hr>
                                        <form action="{{ route('addProjectStep1') }}" method="POST" novalidate="novalidate">
                                                <label for="cc-payment" class="control-label mb-1">
                                                    Select technologies you are interested in:
                                                </label>

                                            <div class="row form-group mt-4">

                                                <div class="col col-md-9">
                                                    <div class="form-check">
                                                        @foreach($skills as $skill)
                                                        <div class="checkbox mt-2">
                                                            <label for="checkbox1" class="form-check-label">
                                                                <input type="checkbox" name="project_type[]"
                                                                       value="{{ $skill->id }}" class="form-check-input">
                                                                {{ $skill->title }}
                                                            </label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-lg"
                                                        style="width: 50%; border-radius: 12px; background-color: #111111; color:white">NEXT
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

    <!-- Footer -->
    <footer class="page-footer font-small blue" style="background: #111111">

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3" style="padding-left: 20% !important;">© 2020 Copyright:
            <a href="https://mdbootstrap.com/">FreeLauncePlus.com</a>
        </div>
        <!-- Copyright -->

    </footer>
    <!-- Footer -->




@endsection

