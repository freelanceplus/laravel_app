@extends('app')

@section('content')

    {{--    <link href="{{ asset('vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">--}}

    <body class="animsition" style="animation-duration: 900ms; opacity: 1;">
    <div class="page-wrapper bg-white">

        @include('reuse.adminSidebar');

        <!-- PAGE CONTAINER-->
        <div class="page-container">


            @include('reuse.navbarDesktopBuyer');

            <!-- MAIN CONTENT-->
            <div class="main-content bg-white" style="padding-top: 6% !important;">
                <div class="section__content section__content--p0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                </div>
                            </div>
                        </div>


                        <div class="row mt-5 ">
                            <div class="col-12">

                                <div class="table-responsive table--no-card m-b-40 bg-white">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                        <tr>
                                            <th style="background: #000000 !important;">name</th>
                                            <th style="background: #000000 !important;">email</th>
                                            <th style="background: #000000 !important;">skills</th>
                                            <th class="" style="background: #000000 !important;">total projects</th>
                                            <th class="" style="background: #000000 !important;"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($sellers_data as $sd)
                                            <tr>
                                                <td>{{ $sd['name'] }}</td>
                                                <td>{{ $sd['email'] }}</td>
                                                <td>{{ $sd['skills'] }}</td>
                                                <td class="font-weight-bold" style="width: 15%;">
                                                    {{ $sd['projects'] }}
                                                </td>
                                                <td class="" style="width: 15%">
                                                    <a href="{{ route('developerDetails', ['id' => $sd['id']]) }}"
                                                       class="btn btn-primary btn-sm"
                                                       id=""><i class="zmdi zmdi-calendar-note mr-1"></i>Details</a>
                                                </td>

                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTAINER-->

    </div>

    <!-- Jquery JS-->
    <script src="{{ asset('vendor/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ asset('vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>



    <!-- end document-->
    </body>


@endsection


