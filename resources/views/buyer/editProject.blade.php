@extends('app')

@section('content')

    <body class="animsition " style="animation-duration: 900ms; opacity: 1;">
    <div class="page-wrapper bg-white">

        @include('reuse.buyerSidebar');

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
                                            <h3 class="text-center title-2 mt-1 font-weight-bold">Edit Project</h3>
                                        </div>
                                        <hr>
                                        <form action="{{ url('/buyer/editProject') }}" method="POST" enctype="multipart/form-data"
                                              novalidate="novalidate">
                                            <input id="order_id" name="order_id" value="{{ $order_details[0]->id }}" type="hidden">
                                            <div class="form-group">
                                                <label for="project_title" class="control-label mb-1 mt-2 font-weight-bold">Project Title</label>
                                                <input id="project_title" name="project_title" type="text"
                                                       class="form-control {{ $errors->has('project_title') ? ' is-invalid' : '' }}" aria-required="true"
                                                       aria-invalid="false"
                                                       value="{{ $order_details[0]->title }}"
                                                >
                                                @if ($errors->has('project_title'))
                                                    <span class="text-danger">
                                                        <small>{{ $errors->first('project_title') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group has-success">
                                                <label for="deadline" class="control-label mb-1 mt-1 font-weight-bold">Deadline</label>
                                                <input id="deadline" name="deadline" type="date"
                                                       class="form-control cc-name valid {{ $errors->has('deadline') ? ' is-invalid' : '' }}"
                                                       value="{{ $order_details[0]->deadline }}"
                                                       required >
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                                                @if ($errors->has('deadline'))
                                                    <span class="text-danger">
                                                        <small>{{ $errors->first('deadline') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="budget" class="control-label mb-1 mt-1 font-weight-bold">Budget</label>
                                                <input id="budget" name="budget" type="tel"
                                                       class="form-control cc-number identified visa {{ $errors->has('budget') ? ' is-invalid' : '' }}"
                                                       placeholder="in rupees" value="{{ $order_details[0]->budget }}">
                                                <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                                                @if ($errors->has('budget'))
                                                    <span class="text-danger">
                                                        <small>{{ $errors->first('budget') }}</small>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="description" class="control-label mb-1 mt-1 font-weight-bold">Description</label>
                                                <textarea name="description" id="description" rows="4" placeholder="" class="form-control">{{ $order_details[0]->description }}</textarea>
                                                <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
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
                                                    <label for="file" class="form-control-label mt-1 mb-1 font-weight-bold">Multiple File input</label>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <input type="file" id="file" name="file[]" multiple="" class="form-control-file">
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <button type="button" class="btn btn-sm mr-3" onclick="uploadImages()"
                                                            style="width: 50%; height: 110%; border-radius: 12px; background-color: #111111; color:white">
                                                        UPLOAD
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="" style="margin-top: 6% !important;">
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

        </div>

    </div>
    <!-- end document-->
    </body>

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


            // console.log($("input:file")[0].files.length);
            totalFiles = $("input:file")[0].files.length;
            var i;
            var j;
            var count = 0;
            var check = 0;
            var images;
            var imageName;
            var storageRef = new Array(totalFiles);
            var uploadImage = new Array(totalFiles);
            var uploadImageUrl = new Array();
            // var uploadImageUrl = "";
            var progress;

            for (i=0; i<totalFiles; i++){

                images = document.getElementById("file").files[i];
                imageName = images.name;
                storageRef[i] = firebase.storage().ref('image/'+imageName);
                // console.log(storageRef[0]);
                uploadImage[i] = storageRef[i].put(images);
                uploadImage[i].on('state_changed', function (snapshot) {

                    progress = (snapshot.bytesTransferred/snapshot.totalBytes)*100;
                    console.log("upload is "+ progress +" done");

                },function (error) {
                    console.log(error.message);
                },function complete () {
                    // console.log(i);
                    check++;
                    if(check == totalFiles){
                        for(j=0; j<totalFiles; j++) {
                            // console.log(storageRef[0]);
                            uploadImage[j].snapshot.ref.getDownloadURL().then(function (downloadURL) {
                                uploadImageUrl[count] = downloadURL;
                                // uploadImageUrl = uploadImageUrl+","+downloadURL+",";
                                console.log(downloadURL);
                                console.log(uploadImageUrl);
                                count++;
                                $("#firebase_images_url").val(uploadImageUrl);
                                // firebase_images_url
                            });
                        }
                    }
                });
            }

            // console.log(uploadImageUrl);

        }

    </script>

@endsection


