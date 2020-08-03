<div class="container-fluid bg-white">

    <div class="row" style="margin: 0.5% !important; margin-top: 6% !important;">
        <div class="col-12">
            <div class="au-card  au-card--no-pad m-b-40 shadow">
{{--                <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">--}}
{{--                    <div class="bg-overlay bg-overlay--blue"></div>--}}
{{--                    <h3>--}}
{{--                        <i class="zmdi zmdi-account-calendar"></i>{{ $orders_data['title'] }}</h3>--}}
{{--                    <button class="au-btn-plus">--}}
{{--                        <span class="text-white">{{ $orders_data['order_id'] }}</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
                <div class="au-task js-list-load ">


                    <div class="row">
                        <div class="au-task__item col-12 text-center" style="height: 25% !important;">
                            <div class="au-task__item-inner"
                                 style="border-style: solid; border-left-color: #00a2e3;
                                        border-right-color: #00a2e3; border-top-color: white; border-bottom-color: white    ">
                                <h5 class="task">
                                    <a href="#" class="text-danger"><h1 style="color: #00a2e3">{{ $orders_data['title'] }}</h1></a>
                                </h5>
                            </div>
                        </div>
                        <div class="au-task__item au-task__item--danger col-4" style="height: 25% !important;">
                            <div class="au-task__item-inner">
                                <h5 class="task">
                                    <a href="#" class="text-danger">Deadline</a>
                                </h5>
                                <span class="time font-weight-bold">{{ $orders_data['deadline'] }}</span>
                            </div>
                        </div>
                        <div class="au-task__item au-task__item--danger col-4" style="height: 25% !important;">
                            <div class="au-task__item-inner">
                                <h5 class="task">
                                    <a href="#" class="text-danger">Technologies</a>
                                </h5>
                                <span class="time font-weight-bold">{{ $orders_data['project_type'] }}</span>
                            </div>
                        </div>
                        <div class="au-task__item au-task__item--danger col-4">
                            <div class="au-task__item-inner">
                                <h5 class="task">
                                    <a href="#" class="text-danger">Budget</a>
                                </h5>
                                <span class="time font-weight-bold">{{ $orders_data['budget'] . " pkr" }}</span>
                            </div>
                        </div>
                        <div class="au-task__item au-task__item--success col-4">
                            <div class="au-task__item-inner">
                                <h5 class="task">
                                    <a href="#" class="text-success">Assigned By</a>
                                </h5>
                                <span class="time font-weight-bold">{{ $orders_data['buyer_name'][0] }}</span>
                            </div>
                        </div>
                        <div class="au-task__item au-task__item--success col-4">
                            <div class="au-task__item-inner">
                                <h5 class="task">
                                    <a href="#" class="text-success">Assigned to</a>
                                </h5>
                                <span class="time font-weight-bold">{{ $orders_data['seller_name'][0] }}</span>
                            </div>
                        </div>
                        <div class="col-4">
                        </div>
                        <div class="au-task__item au-task__item--primary col-12">
                            <div class="au-task__item-inner">
                                <h5 class="task">
                                    <a href="#" class="text-primary">Description</a>
                                </h5>
                                <span class="time font-weight-bold">{{ $orders_data['description'] }}</span>
                            </div>
                        </div>
                        <div class="au-task__item au-task__item--primary col-12">
                            <div class="au-task__item-inner">
                                <h5 class="task">
                                    <a href="#" class="text-primary">Remarks</a>
                                </h5>
                                <span class="time font-weight-bold">{{ $orders_data['remarks'] }}</span>
                            </div>
                        </div>

                        <div class="au-task__item au-task__item--danger col-12">
                            <div class="au-task__item-inner">
                                <h5 class="task mb-5">
                                    <a href="#" class="text-danger">Files From Buyer</a>
                                </h5>
                                @php
                                    $count = 1;
                                @endphp
                                @if($buyer_files_array[0] != "")
                                    @foreach($buyer_files_array as $bfa)
                                    <div class="time font-weight-bold mt-1 text-uppercase">Picture {{ $count++ }}
                                        <a href="{{ $bfa }}" class="ml-2 text-danger text-lowercase">
                                            Click to download
                                        </a>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="time font-weight-bold mt-1 text-uppercase">
                                        No Picture Attached
                                    </div>
                                @endif
                            </div>
                            <div class="au-task__item-inner">
                                <h5 class="task mb-5">
                                    <a href="#" class="text-danger">Files From Seller</a>
                                </h5>
                                @php
                                    $count = 1;
                                @endphp
                                @if($seller_files_array[0] != "")
                                    @foreach($seller_files_array as $sfa)
                                        <div class="time font-weight-bold mt-1 text-uppercase">Picture {{ $count++ }}
                                            <a href="{{ $sfa }}" class="ml-2 text-danger text-lowercase">
                                                Click to download
                                            </a>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="time font-weight-bold mt-1 text-uppercase">
                                            No Picture Attached
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
{{--            @if($user_type == 'seller')--}}
{{--            <input id="buyer_files" name="buyer_files" type="hidden"--}}
{{--                   class="form-control" aria-required="true"--}}
{{--                   aria-invalid="false"--}}
{{--                   data-files="{{ $buyer_files_array }}"--}}
{{--            >--}}
{{--            <input id="seller_files" name="seller_files" type="hidden"--}}
{{--                   class="form-control" aria-required="true"--}}
{{--                   aria-invalid="false"--}}
{{--                   data-files="{{ $seller_files_array }}"--}}
{{--            >--}}
{{--                <div>--}}
{{--                    <button id="buyerFiles" name="buyerFiles" class="btn btn-danger" onclick="buyerFiles()">Download Files</button>--}}
{{--                    <span class="ml-3">From Buyer</span>--}}
{{--                </div>--}}
{{--                <div class="mt-3">--}}
{{--                    <button id="sellerFiles" name="sellerFiles" class="btn btn-danger" onclick="sellerFiles()">Download Files</button>--}}
{{--                    <span class="ml-3">From Seller</span>--}}
{{--                </div>--}}
{{--            @if($user_type == 'buyer')--}}
{{--                <div>--}}
{{--                    <a href="{{ route('downloadBuyerFiles', $orders_data['order_id']) }}" class="btn btn-danger">Download Files</a>--}}
{{--                    <span class="ml-3">From Buyer</span>--}}
{{--                </div>--}}
{{--                <div class="mt-3">--}}
{{--                    <a href="{{ route('downloadSellerFiles', $orders_data['order_id']) }}" class="btn btn-danger">Download Files</a>--}}
{{--                    <span class="ml-3">From Seller</span>--}}
{{--                </div>--}}
{{--            @endif--}}
        </div>
    </div>

</div>

<script type="text/javascript">

    function buyerFiles(){
        var buyer_files = document.getElementById("buyer_files");
        var files_array = JSON.parse(buyer_files.dataset.files);
        totalFiles = files_array.length;
        // console.log(totalFiles);

        for (i=0; i<totalFiles; i++) {
            window.open(files_array[i], '_new'+i);
            // window.focus();
            // console.log(files_array[i]);

            // chrome.tabs.create({
            //     url: files_array[i]
            // });



            // window.open(files_array[1]);
            // console.log(files_array[i]);

        }
            // window.open(files_array[0]);
        // console.log(buyer_files);
        // This can be downloaded directly:
    }


    function sellerFiles(){
        var buyer_files = document.getElementById("seller_files");
        var files_array = JSON.parse(buyer_files.dataset.files);
        totalFiles = files_array.length;
        // console.log(totalFiles);

        for (i=0; i<totalFiles; i++) {
            window.open(files_array[i], '_new'+i);
        }
    }

</script>
