@extends('app')

@section('content')

    <body class="animsition" style="animation-duration: 900ms; opacity: 1;">
    <div class="page-wrapper bg-white">

        @include('reuse.buyerSidebar');

        <!-- PAGE CONTAINER-->
        <div class="page-container bg-white">


            @include('reuse.navbarDesktopBuyer');
            @include('reuse.newRequests');

        </div>
        <!-- END PAGE CONTAINER-->

    </div>


    <!-- end document-->
    </body>


@endsection
