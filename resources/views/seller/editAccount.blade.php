@extends('app')

@section('content')

    <body class="animsition " style="animation-duration: 900ms; opacity: 1;">
    <div class="page-wrapper bg-white">

        @include('reuse.sellerSidebar');

        <!-- PAGE CONTAINER-->
        <div class="page-container">

            @include('reuse.navbarDesktopBuyer')
            @include('reuse.editAccount')

        </div>

    </div>
    <!-- end document-->
    </body>
@endsection
