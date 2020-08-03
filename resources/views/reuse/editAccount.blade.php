

            <!-- MAIN CONTENT-->
            <div class="main-content bg-white" style="padding-top: 6% !important;">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-12">
                                <div class="overview-wrap mb-3 float-right">
                                    @if($user_type == 'buyer')
                                        <a class="au-btn au-btn-icon au-btn--blue admin-panel-color"
                                           href="{{ route('changeBuyerPassword') }}">
                                            <i class="zmdi zmdi-plus"></i>Change Password</a>
                                    @elseif($user_type == 'seller')
                                        <a class="au-btn au-btn-icon au-btn--blue admin-panel-color"
                                           href="{{ route('changeSellerPassword') }}">
                                            <i class="zmdi zmdi-plus"></i>Change Password</a>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12 shadow">
                                <div class="card border-0">
                                    <div class="card-body p-4">
                                        <div class="card-title">
                                            <h3 class="text-center title-2 mt-1 font-weight-bold">Edit Account Details</h3>
                                        </div>
                                        <hr>
                                        @if($user_type == 'buyer')
                                            <form action="{{ route('editProfileBuyer') }}" method="POST" enctype="multipart/form-data"
                                                  novalidate="novalidate">
                                                @elseif($user_type == 'seller')
                                                    <form action="{{ route('editProfileSeller') }}" method="POST" enctype="multipart/form-data"
                                                          novalidate="novalidate">
                                                        @endif

                                                        <div class="form-group">
                                                            <label for="name" class="control-label mb-1 mt-2 font-weight-bold">Name</label>
                                                            <input id="name" name="name" type="text"
                                                                   class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" aria-required="true"
                                                                   aria-invalid="false"
                                                                   value="{{ $user_name }}"
                                                            >
                                                            @if ($errors->has('name'))
                                                                <span class="text-danger">
                                                                    <small>{{ $errors->first('name') }}</small>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="form-group has-success">
                                                            <label for="email" class="control-label mb-1 mt-1 font-weight-bold">Email</label>
                                                            <input id="email" name="email" type="text"
                                                                   class="form-control cc-name valid {{ $errors->has('email') ? ' is-invalid' : '' }}" required
                                                                   value="{{ $user_email }}">
                                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                                                            @if ($errors->has('email'))
                                                                <span class="text-danger">
                                                                    <small>{{ $errors->first('email') }}</small>
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="form-group">
                                                            <input id="firebase_images_url" name="firebase_images_url" type="hidden"
                                                                   class="form-control" aria-required="true"
                                                                   aria-invalid="false"
                                                                   value=""
                                                            >
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col col-md-3">
                                                                <label for="file" class="form-control-label mt-1 mb-1 font-weight-bold">Select image</label>
                                                            </div>
                                                            <div class="col-12 col-md-3">
                                                                <input type="file" id="file" name="file" multiple="" class="form-control-file">
                                                            </div>
                                                            <div class="col-md-4 text-center">
                                                                <button type="button" class="btn btn-sm mr-3" onclick="uploadImages()"
                                                                        style="width: 50%; height: 110%; border-radius: 12px; background-color: #111111; color:white">
                                                                    UPLOAD
                                                                </button>
                                                            </div>
                                                            <span id="pic_message" class="mt-3 ml-3 text-danger">(do not select picture if you want to keep old profile picture)</span>
                                                        </div>

                                                        <div class="mt-5">
                                                            <div class="col-md-12 text-center">
                                                                <button type="submit" class="btn btn-lg"
                                                                        style="width: 50%; border-radius: 12px; background-color: #111111; color:white">SUBMIT
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

            </script>

            <script type="text/javascript">

                function uploadImages(){

                    var image = document.getElementById("file").files[0];
                    var imageName = image.name;
                    var storageRef = firebase.storage().ref('images/'+imageName);
                    var uploadTask = storageRef.put(image);
                    uploadTask.on('state_changed', function (snapshot) {
                        var progress = (snapshot.bytesTransferred/snapshot.totalBytes)*100;
                        console.log("uplaod is "+ progress + " done");
                    },function (error) {
                        console.log(error.message);
                    },function () {
                        uploadTask.snapshot.ref.getDownloadURL().then(function (downloadURL) {
                            console.log(downloadURL);
                            $("#firebase_images_url").val(downloadURL);
                            $("#pic_message").text("Picture uploaded successfully");
                        })
                    })
                    // console.log(uploadImageUrl);

                }



            </script>

