@extends('app')

@section('content')

    <body class="animsition" style="animation-duration: 900ms; opacity: 1;">
    <div class="page-wrapper">

        @include('reuse.adminSidebar');

        <!-- PAGE CONTAINER-->
        <div class="page-container">


            @include('reuse.navbarDesktopBuyer');
            @include('reuse.completedProjects');


        </div>
        <!-- END PAGE CONTAINER-->

    </div>


    <!-- end document-->
    </body>


@endsection

