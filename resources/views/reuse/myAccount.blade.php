<div class="container-fluid bg-white">

    <div class="row" style="margin: 0.5% !important; margin-top: 6% !important;">

        <div class="col-12">
            <div class="overview-wrap mb-3 float-right">
                @if($user_type == 'buyer')
                <a class="au-btn au-btn-icon au-btn--blue admin-panel-color"
                   href="{{ route('editProfileBuyer') }}">
                    <i class="zmdi zmdi-plus"></i>Edit Profile</a>
                @elseif($user_type == 'seller')
                    <a class="au-btn au-btn-icon au-btn--blue admin-panel-color"
                       href="{{ route('editProfileSeller') }}">
                        <i class="zmdi zmdi-plus"></i>Edit Profile</a>
                @endif

            </div>
        </div>

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
                <div class="col-md-12">

                </div>
                <div class="au-task js-list-load ">


                    <div class="row">
                        <div class="au-task__item col-12 text-center" style="height: 25% !important;">
                            <div class="au-task__item-inner"
                                 style="border-style: solid; border-left-color: #00a2e3;
                                        border-right-color: #00a2e3; border-top-color: white; border-bottom-color: white    ">
                                <div class="row">
                                    <div class="col-2">

                                        <img class="image pb-2 bg-dark" style="height: 100% !important; width: 100% !important;" src="{{ $user_picture }}" alt="FreeLauncePlus">
                                    </div>
                                    <h5 class="task col-4">
                                        <a href="#" class="mt-4"><h1 style="color: #111111">{{ $user_name }}</h1></a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="au-task__item au-task__item--danger col-6" style="height: 25% !important;">
                            <div class="au-task__item-inner">
                                <h5 class="task">
                                    <a href="#" class="text-danger">Email</a>
                                </h5>
                                <span class="time font-weight-bold">{{ $user_email }}</span>
                            </div>
                        </div>
                        <div class="au-task__item au-task__item--danger col-6" style="height: 25% !important;">
                            <div class="au-task__item-inner">
                                <h5 class="task">
                                    <a href="#" class="text-danger">Total Projects</a>
                                </h5>
                                <span class="time font-weight-bold">{{ sizeof($total_orders) }}</span>
                            </div>
                        </div>
                        @if($user_type == 'buyer')
                        <div class="au-task__item au-task__item--danger col-4">
                            <div class="au-task__item-inner">
                                <h5 class="task">
                                    <a href="#" class="text-danger">Total Money Spent</a>
                                </h5>
                                <span class="time font-weight-bold">{{ $total_money_spend . " pkr" }}</span>
                            </div>
                        </div>
                        @elseif($user_type == 'seller')
                            <div class="au-task__item au-task__item--danger col-4">
                                <div class="au-task__item-inner">
                                    <h5 class="task">
                                        <a href="#" class="text-danger">Total Earnings</a>
                                    </h5>
                                    <span class="time font-weight-bold">{{ $total_money_spend . " pkr" }}</span>
                                </div>
                            </div>
                        @endif

                        {{--                        <div class="au-task__item au-task__item--success col-4">--}}
{{--                            <div class="au-task__item-inner">--}}
{{--                                <h5 class="task">--}}
{{--                                    <a href="#" class="text-success">Assigned By</a>--}}
{{--                                </h5>--}}
{{--                                <span class="time font-weight-bold">{{ $orders_data['buyer_name'][0] }}</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="au-task__item au-task__item--success col-4">--}}
{{--                            <div class="au-task__item-inner">--}}
{{--                                <h5 class="task">--}}
{{--                                    <a href="#" class="text-success">Assigned to</a>--}}
{{--                                </h5>--}}
{{--                                <span class="time font-weight-bold">{{ $orders_data['seller_name'][0] }}</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-4">--}}
{{--                        </div>--}}
{{--                        <div class="au-task__item au-task__item--primary col-12">--}}
{{--                            <div class="au-task__item-inner">--}}
{{--                                <h5 class="task">--}}
{{--                                    <a href="#" class="text-primary">Description</a>--}}
{{--                                </h5>--}}
{{--                                <span class="time font-weight-bold">{{ $orders_data['description'] }}</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="au-task__item au-task__item--primary col-12">--}}
{{--                            <div class="au-task__item-inner">--}}
{{--                                <h5 class="task">--}}
{{--                                    <a href="#" class="text-primary">Remarks</a>--}}
{{--                                </h5>--}}
{{--                                <span class="time font-weight-bold">{{ $orders_data['remarks'] }}</span>--}}
{{--                            </div>--}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

