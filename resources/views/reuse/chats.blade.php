@extends('app')

@section('content')

    <body class="animsition" style="animation-duration: 900ms; opacity: 1;">
    <div class="page-wrapper bg-white">

        @include('reuse.buyerSidebar');

        <!-- PAGE CONTAINER-->
        <div class="page-container bg-white">
            @include('reuse.navbarDesktopBuyer');

            <meta name="buyer_id" content="2">
            <meta name="seller_id" content="31">
            <meta name="sender" content="{{ $sender }}">
            <div class="col-8 mt-5">
                <div class="card card-default mb-0">
                    <div class="card-header font-weight-bold">{{ $receiver_name }}</div>

                </div>
                <chat v-bind:chats="chats" v-bind:sender="{{ $sender }}" v-bind:seller_id="{{ $seller_id }}" v-bind:buyer_id="{{ $buyer_id }}"></chat>
{{--                    <input type="text" name="message" placeholder="Enter your message..." class="form-control">--}}
                </div>
{{--                <span class="text-muted">user is typing...</span>--}}
            </div>

        </div>
        <!-- END PAGE CONTAINER-->

    </div>


    <!-- end document-->
    </body>

    <script src="{{ asset('js/app.js') }}"></script>

@endsection


