@extends('app')

@section('content')
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
         https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-analytics.js"></script>

    <script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyCDqV5w3C64oKwL8E2Bfxz_L8N-l5ez-sc",
            authDomain: "freelanceplus-9aa42.firebaseapp.com",
            databaseURL: "https://freelanceplus-9aa42.firebaseio.com",
            projectId: "freelanceplus-9aa42",
            storageBucket: "freelanceplus-9aa42.appspot.com",
            messagingSenderId: "579583429088",
            appId: "1:579583429088:web:1f6f38bd573ab3c62b4385",
            measurementId: "G-XNQY7WG735"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        firebase.analytics();

        function writeData() {
            // console.log("clicked");
            var input = document.getElementById("input_message");
            var message = $('#input_message').val();
            $("#input_message").val('');
            var order_id = input.getAttribute('data-order_id');
            var buyer_id = input.getAttribute('data-buyer_id');
            var buyer_name = input.getAttribute('data-buyer_name');
            var seller_id = input.getAttribute('data-seller_id');
            var seller_name = input.getAttribute('data-seller_name');
            var sender = input.getAttribute('data-sender');
            // var title = input.getAttribute('data-title');
            firebase.database().ref("chat").push({
                order_id: order_id,
                buyer_id: buyer_id,
                buyer_name: buyer_name,
                seller_id: seller_id,
                seller_name: seller_name,
                sender: sender,
                message: message
            });
        }
        function writeDataAdmin() {
            // console.log("clicked");
            var input = document.getElementById("input_message");
            var message = $('#input_message_admin').val();
            $("#input_message_admin").val('');
            var order_id = input.getAttribute('data-order_id');
            var buyer_id = input.getAttribute('data-buyer_id');
            var buyer_name = input.getAttribute('data-buyer_name');
            var seller_id = "1";
            var seller_name = "admin";
            var sender = input.getAttribute('data-sender');
            // var title = input.getAttribute('data-title');
            firebase.database().ref("chat").push({
                order_id: order_id,
                buyer_id: buyer_id,
                buyer_name: buyer_name,
                seller_id: seller_id,
                seller_name: seller_name,
                sender: sender,
                message: message
            });
        }


        $(document).ready(function () {
            var order_id = "{{ $order_id }}";
            var chats = [];
            firebase.database().ref("chat").orderByChild("order_id").equalTo(order_id)
                .on("value", snap => {
                    // console.log(snap.val());
                    chats = snap.val();
                    console.log(chats);

                    // for (var i = 0; i < chats.length; i++){
                    //     console.log("1");
                    //     // document.getElementById("chat_table").innerHTML = ""++"";
                    // }
                    document.getElementById("chat_table").innerHTML = "";
                    Object.keys(chats).forEach(function (key){
                        // console.log(chats[key].message);
                        if(chats[key].seller_id != 1) {
                            if (chats[key].sender == "buyer") {
                                document.getElementById("chat_table").innerHTML += "<tr class=''><td class=''>" + "<span class='text-danger'>" + "me: " + "</span>" + chats[key].message + "</td>" + "<td></td>" + "</tr>";
                            } else if (chats[key].sender == "seller") {
                                document.getElementById("chat_table").innerHTML += "<tr class=''>" + "<td></td>" + "<td class='text-right'><span class='text-danger'>" + "" + chats[key].seller_name + ":     " + "</span>" + chats[key].message + "</td></tr>";
                            }
                        }
                    });
                    // chats.forEach(function (item, index) {
                    //     console.log("1");
                    // });
                });

            firebase.database().ref("chat").orderByChild("order_id").equalTo(order_id)
                .on("value", snap => {
                    // console.log(snap.val());
                    chats = snap.val();
                    console.log(chats);

                    // for (var i = 0; i < chats.length; i++){
                    //     console.log("1");
                    //     // document.getElementById("chat_table").innerHTML = ""++"";
                    // }
                    document.getElementById("chat_table_admin").innerHTML = "";
                    Object.keys(chats).forEach(function (key){
                        // console.log(chats[key].message);
                        if(chats[key].seller_id == 1) {
                            if (chats[key].sender == "buyer") {
                                document.getElementById("chat_table_admin").innerHTML += "<tr class=''><td class=''>" + "<span class='text-danger'>" + "me: " + "</span>" + chats[key].message + "</td>" + "<td></td>" + "</tr>";
                            } else if (chats[key].sender == "admin") {
                                document.getElementById("chat_table_admin").innerHTML += "<tr class=''>" + "<td></td>" + "<td class='text-right'><span class='text-danger'>" + "" + chats[key].seller_name + ":     " + "</span>" + chats[key].message + "</td></tr>";
                            }
                        }
                    });
                    // chats.forEach(function (item, index) {
                    //     console.log("1");
                    // });
                });

            // function myFunction(item, index) {
            //
            // }
        });


    </script>



    <body class="animsition" style="animation-duration: 900ms; opacity: 1;">
    <div class="page-wrapper bg-white">

        @include('reuse.buyerSidebar')

        <!-- PAGE CONTAINER-->
        <div class="page-container bg-white">

            @include('reuse.navbarDesktopBuyer')
            @include('reuse.projectDetails')


            <div class="row mt-5 ml-4 mr-4">
                <div class="col-12">

                    <div class="table-responsive table--no-card m-b-10" style="height: 300px; overflow: scroll !important;">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                            <tr>
                                <th class="admin-panel-color"></th>
                                <th class="admin-panel-color text-left">Chat with buyer</th>
                            </tr>
                            </thead>
                            <tbody id="chat_table">


                            </tbody>
                        </table>
                    </div>
                    <form id="sendMessageForm" enctype="multipart/form-data">
                        <div class="row form-group" >
                            <div class="col-10">
                                <input id="input_message" name="input_message" type="text"  style="border: 3px solid #111111"
                                       placeholder="Enter your message" class="form-control"
                                       data-order_id="{{ $order_id }}"
                                       data-buyer_id="{{ $buyer_id }}"
                                       data-buyer_name="{{ $buyer_name }}"
                                       data-seller_id="{{ $seller_id }}"
                                       data-seller_name="{{ $seller_name }}"
                                       data-sender="buyer"
                                        >
                            </div>
                            <div class="col-2">
                                <button type="button" onclick="writeData()" class="btn btn-primary">
                                    <i class="fa fa-user"></i> Send
                                </button>
                            </div>
                            <input type="hidden" name="_token" value={{csrf_token()}}>
                        </div>
                    </form>
                </div>


            </div>

            <div class="row mt-5 ml-4 mr-4">
                <div class="col-12">

                    <div class="table-responsive table--no-card m-b-10" style="height: 300px; overflow: scroll !important;">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                            <tr>
                                <th class="admin-panel-color"></th>
                                <th class="admin-panel-color text-left">Chat with admin</th>
                            </tr>
                            </thead>
                            <tbody id="chat_table_admin">

                            </tbody>
                        </table>
                    </div>
                    <form id="sendMessageForm" enctype="multipart/form-data">
                        <div class="row form-group" >
                            <div class="col-10">
                                <input id="input_message_admin" name="input_message" type="text"  style="border: 3px solid #111111"
                                       placeholder="Enter your message" class="form-control"
                                       data-order_id="{{ $order_id }}"
                                       data-buyer_id="{{ $buyer_id }}"
                                       data-buyer_name="{{ $buyer_name }}"
                                       data-seller_id="1"
                                       data-seller_name="admin"
                                       data-sender="buyer"
                                >
                            </div>
                            <div class="col-2">
                                <button type="button" onclick="writeDataAdmin()" class="btn btn-primary">
                                    <i class="fa fa-user"></i> Send
                                </button>
                            </div>
                            <input type="hidden" name="_token" value={{csrf_token()}}>
                        </div>
                    </form>
                </div>


            </div>

        </div>
        <!-- END PAGE CONTAINER-->

    </div>

    <!-- end document-->
    </body>



    <script type="text/javascript">



        {{--$('#sendMessageForm').submit(function (e) {--}}

        {{--    e.preventDefault();--}}

        {{--    // console.log("clicked");--}}

        {{--    var input = document.getElementById("input_message");--}}
        {{--    // var input = $('#input_message').val();--}}
        {{--    var order_id = input.getAttribute('data-order_id');--}}
        {{--    var buyer_id = input.getAttribute('data-buyer_id');--}}
        {{--    var buyer_name = input.getAttribute('data-buyer_name');--}}
        {{--    var seller_id = input.getAttribute('data-seller_id');--}}
        {{--    var seller_name = input.getAttribute('data-seller_name');--}}
        {{--    var sender = input.getAttribute('data-sender');--}}
        {{--    // var title = input.getAttribute('data-title');--}}

        {{--    // alert($('#movieId').val());--}}
        {{--    $.ajax({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': "{{ csrf_token() }}"--}}
        {{--        },--}}
        {{--        url: "/sendMessage/"+order_id+"/"+buyer_id+"/"+buyer_name+"/"+seller_id+"/"+seller_name+"/"+sender,--}}
        {{--        type: "POST",--}}
        {{--        dataType: "json",--}}
        {{--        data: $("#sendMessageForm").serialize(),--}}
        {{--        success: function (data) {--}}

        {{--            console.log(data);--}}

        {{--        },error: function (result) {--}}
        {{--            // alert("1111");--}}
        {{--            console.log(result);--}}
        {{--        }--}}
        {{--    });--}}
        {{--    //just to be sure its not submiting form--}}
        {{--    // return false;--}}
        {{--});--}}

    </script>


@endsection

