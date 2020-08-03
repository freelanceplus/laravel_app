<div class="container-fluid bg-white">

    <div class="row" style="margin: 0.5% !important; margin-top: 6% !important;">
        <div class="col-12 mt-4">
            <div class="au-card  au-card--no-pad m-b-40 shadow">

                <div class="au-task js-list-load ">

                    <div class="row">
                        <div class="au-task__item col-12 text-center" style="height: 25% !important;">
                            <div class="au-task__item-inner"
                                 style="border-style: solid; border-left-color: #00a2e3;
                                        border-right-color: #00a2e3; border-top-color: white; border-bottom-color: white    ">
                                <h5 class="task">
                                    <a href="#" class="text-danger"><h1 style="color: #00a2e3">{{ $sellers_data['name'] }}</h1></a>
                                </h5>
                            </div>
                        </div>
                        <div class="au-task__item au-task__item--danger col-4" style="height: 25% !important;">
                            <div class="au-task__item-inner">
                                <h5 class="task">
                                    <a href="#" class="text-danger">Email</a>
                                </h5>
                                <span class="time font-weight-bold">{{ $sellers_data['email'] }}</span>
                            </div>
                        </div>
                        <div class="au-task__item au-task__item--danger col-4" style="height: 25% !important;">
                            <div class="au-task__item-inner">
                                <h5 class="task">
                                    <a href="#" class="text-danger">Skills</a>
                                </h5>
                                <span class="time font-weight-bold">{{ $sellers_data['skills'] }}</span>
                            </div>
                        </div>
                        <div class="au-task__item au-task__item--danger col-4">
                            <div class="au-task__item-inner">
                                <h5 class="task">
                                    <a href="#" class="text-danger">Total Projects</a>
                                </h5>
                                <span class="time font-weight-bold">{{ $sellers_data['projects'] }}</span>
                            </div>
                        </div>
                        <div class="au-task__item au-task__item--success col-4">
                            <div class="au-task__item-inner">
                                <h5 class="task">
                                    <a href="#" class="text-success">Total Earnings</a>
                                </h5>
                                <span class="time font-weight-bold">{{ $total_earnings . " rs" }}</span>
                            </div>
                        </div>
                        <div class="au-task__item au-task__item--success col-4">
                            <div class="au-task__item-inner">
                                <h5 class="task">
                                    <a href="#" class="text-success">Pending Payments</a>
                                </h5>
                                <span class="time font-weight-bold">{{ $pending_payment . " rs" }}</span>
                            </div>
                        </div>
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
{{--                        </div>--}}
                    </div>

                </div>
            </div>
{{--            <div>--}}
{{--                <a href="{{ route('downloadBuyerFiles', $orders_data['order_id']) }}" class="btn btn-danger">Download Files</a>--}}
{{--                <span class="ml-3">From Buyer</span>--}}
{{--            </div>--}}
{{--            <div class="mt-3">--}}
{{--                <a href="{{ route('downloadSellerFiles', $orders_data['order_id']) }}" class="btn btn-danger">Download Files</a>--}}
{{--                <span class="ml-3">From Seller</span>--}}
{{--            </div>--}}
        </div>
    </div>

    <div class="row mt-5 ml-2 mr-2">
        <div class="col-12">

            <div class="table-responsive table--no-card m-b-40">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                    <tr>
                        <th class="admin-panel-color">title</th>
                        <th class="admin-panel-color">budget</th>
                        <th class="admin-panel-color">project type</th>
                        <th class="admin-panel-color">status</th>
                        <th class="admin-panel-color">buyer name</th>
                        <th class="admin-panel-color"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($orders_data[0] != null)
                        @foreach($orders_data as $od)
                            <tr>
                                <td class="font-weight-bold">{{ $od['title'] }}</td>
                                <td class="text-right text-info">{{ $od['budget'] }}</td>
                                <td class="text-right">{{ $od['project_type'] }}</td>
{{--                                @if($od['status'] == 'accepted')--}}
                                    <td class="font-weight-bold">{{ $od['status'] }}</td>
{{--                                @elseif($od['status'] == 'approved')--}}
{{--                                    <td class="text-primary">{{ $od['status'] }}</td>--}}
{{--                                @endif--}}
                                <td class="">{{ $od['buyer_name'][0] }}</td>
                                <td class="" style="width: 15%">
                                    <a href="{{ route('getProjectDetailsAdmin', $od['order_id']) }}" data-toggle="modal" class="btn btn-primary btn-sm btnEdit"
                                       id=""><i class="mr-1 zmdi zmdi-calendar-note"></i>Details</a>
                                </td>
                            </tr>
                        @endforeach

                    @else
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-danger">"No Data Available"</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

