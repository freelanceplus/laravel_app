<!-- HEADER DESKTOP-->

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

    $(document).ready(function () {
        var user_type = "{{ $user_type }}";
        console.log(user_type);
        var notifications;
        if (user_type == "admin") {
            firebase.database().ref("notification").orderByChild("receiver").equalTo("admin")
                .on("value", snap => {
                    // console.log(snap.val());
                    notifications = snap.val();

                    // console.log(notifications[);
                    console.log(Object.keys(notifications).length);

                    document.getElementById("notifications-count").innerHTML = Object.keys(notifications).length;
                    document.getElementById("notifications-count-2").innerHTML = "You have " + Object.keys(notifications).length + " Notifications";
                    // console.log(chats);
                    // for (var i = 0; i < chats.length; i++){
                    //     console.log("1");
                    //     // document.getElementById("chat_table").innerHTML = ""++"";
                    // }
                    document.getElementById("notifications-message").innerHTML = "";
                    Object.keys(notifications).forEach(function (key) {
                        console.log(notifications[key].message);

                        document.getElementById("notifications-message").innerHTML += "<div class='notifi__item'>" +
                            "<div class='bg-c1 img-cir img-40'>" +
                            "<i class='zmdi zmdi-email-open'></i>" +
                            "</div>" +
                            "<div class='content'>" +
                            "<p>" + notifications[key].message + "</p>" +
                            "</div>" +
                            "</div>"

                    });

                    // chats.forEach(function (item, index) {
                    //     console.log("1");
                    // });
                });
        }
        else if (user_type == "buyer") {
            firebase.database().ref("notification").orderByChild("receiver").equalTo("buyer")
                .on("value", snap => {
                    // console.log(snap.val());
                    notifications = snap.val();
                    console.log(notifications);
                    var checkReceiverId = Object.values(notifications);
                    console.log(checkReceiverId[0]['receiver_id']);
                    // console.log(Object.keys(notifications).length);
                    var receiver_id = "{{ $user_id }}";
                    if(checkReceiverId[0]['receiver_id'] == "{{ $user_id }}") {
                     // console.log("goes");
                        document.getElementById("notifications-count").innerHTML = Object.keys(notifications).length;
                        document.getElementById("notifications-count-2").innerHTML = "You have " + Object.keys(notifications).length + " Notifications";
                        document.getElementById("notifications-message").innerHTML = "";
                        Object.keys(notifications).forEach(function (key) {
                            console.log(notifications[key].message);

                            document.getElementById("notifications-message").innerHTML += "<div class='notifi__item'>" +
                                "<div class='bg-c1 img-cir img-40'>" +
                                "<i class='zmdi zmdi-email-open'></i>" +
                                "</div>" +
                                "<div class='content'>" +
                                "<p>" + notifications[key].message + "</p>" +
                                "</div>" +
                                "</div>"

                        });
                    }
                });
        }
        else if (user_type == "seller") {
            firebase.database().ref("notification").orderByChild("receiver").equalTo("seller")
                .on("value", snap => {
                    // console.log(snap.val());
                    notifications = snap.val();
                    console.log(notifications);
                    var checkReceiverId = Object.values(notifications);
                    console.log(checkReceiverId[0]['receiver_id']);
                    // console.log(Object.keys(notifications).length);
                    var receiver_id = "{{ $user_id }}";
                    if(checkReceiverId[0]['receiver_id'] == "{{ $user_id }}") {
                        // console.log("goes");
                        document.getElementById("notifications-count").innerHTML = Object.keys(notifications).length;
                        document.getElementById("notifications-count-2").innerHTML = "You have " + Object.keys(notifications).length + " Notifications";
                        document.getElementById("notifications-message").innerHTML = "";
                        Object.keys(notifications).forEach(function (key) {
                            console.log(notifications[key].message);

                            document.getElementById("notifications-message").innerHTML += "<div class='notifi__item'>" +
                                "<div class='bg-c1 img-cir img-40'>" +
                                "<i class='zmdi zmdi-email-open'></i>" +
                                "</div>" +
                                "<div class='content'>" +
                                "<p>" + notifications[key].message + "</p>" +
                                "</div>" +
                                "</div>"

                        });
                    }
                });
        }

    });


</script>

<header class="header-desktop admin-panel-color shadow">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap pull-right">

                <div class="header-button">
                    <div class="noti-wrap">
                        <div class="noti__item js-item-menu">
                            <i class="zmdi zmdi-notifications text-white"></i>
                            <span class="quantity" id="notifications-count"></span>
                            <div class="notifi-dropdown js-dropdown" style="height: 500px; overflow: scroll">
                                <div class="notifi__title">

                                    <p id="notifications-count-2"></p>
                                </div>
                                <div id="notifications-message">
{{--                                @foreach($notifications as $notification)--}}
{{--                                <div class="notifi__item">--}}
{{--                                    <div class="bg-c1 img-cir img-40">--}}
{{--                                        <i class="zmdi zmdi-email-open"></i>--}}
{{--                                    </div>--}}
{{--                                    <div class="content">--}}
{{--                                        <p>{{ $notification->message }}</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                @endforeach--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="image">
                                <a href="#">
                                    <img class="image" style="border-radius: 50px"  src="{{ $user_picture }}" alt="FreeLauncePlus">
                                </a>
                            </div>
                            <div class="content">
                                <a class="js-acc-btn text-white" href="#" style="font-size: 20px">{{ $user_name }}</a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <a href="#">
                                            <img class="image" style="border-radius: 50px"  src="{{ $user_picture }}" alt="FreeLauncePlus">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="name ml-2 mt-2">
                                            <a href="#" style="font-size: 20px">{{ $user_name }}</a>
                                        </h5>
                                    </div>
                                </div>
                                @if($user_type == 'buyer')
                                    <div class="account-dropdown__footer">
                                        <a href="{{ route('buyerLogout') }}">
                                            <i class="zmdi zmdi-power"></i>Logout</a>
                                    </div>
                                @elseif($user_type == 'seller')
                                    <div class="account-dropdown__footer">
                                        <a href="{{ route('sellerLogout') }}">
                                            <i class="zmdi zmdi-power"></i>Logout</a>
                                    </div>
                                @elseif($user_type == 'admin')
                                <div class="account-dropdown__footer">
                                    <a href="{{ route('adminLogout') }}">
                                        <i class="zmdi zmdi-power"></i>Logout</a>
                                </div>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- HEADER DESKTOP-->
