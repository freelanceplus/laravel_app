
<div class="main-content bg-white" style="padding-top: 6% !important;">
                <div class="section__content section__content--p0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1 heading-color">Completed Projects</h2>

                                </div>
                            </div>
                        </div>


                        <div class="row mt-5 ">
                            <div class="col-12">

                                <div class="table-responsive table--no-card m-b-40">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                        <tr>
                                            <th class="admin-panel-color">order ID</th>
                                            <th class="admin-panel-color">title</th>
                                            <th class="text-right admin-panel-color">budget</th>
                                            <th class="text-right admin-panel-color">project type</th>
                                            @if($user_type == 'seller' || $user_type == 'admin')
                                                <th class="text-right admin-panel-color">Buyer Name</th>
                                            @elseif($user_type == 'buyer')
                                                <th class="text-right admin-panel-color">Seller Name</th>
                                            @endif
                                            <th class="admin-panel-color"></th>
                                         </tr>
                                        </thead>
                                        <tbody>
                                        @if($orders_data[0] != null)
                                            @foreach($orders_data as $od)
                                                <tr>
                                                    <td>{{ $od['orderId'] }}</td>
                                                    <td>{{ $od['title'] }}</td>
                                                    <td class="text-right text-info">{{ $od['budget'] }}</td>
                                                    <td class="text-right">{{ $od['project_type'] }}</td>
                                                    @if($user_type == 'seller' || $user_type == 'admin')
                                                        <td class="text-right">{{ $od['buyer_name'][0] }}</td>
                                                    @elseif($user_type == 'buyer')
                                                        <td class="text-right">{{ $od['seller_name'][0] }}</td>
                                                    @endif
                                                    <td class="" style="width: 25%">
                                                        @if($user_type == 'seller')
                                                            <a href="{{ route('getProjectDetails', $od['orderId']) }}" class="ml-5 btn btn-primary btn-sm btnEdit"
                                                               id=""><i class="zmdi zmdi-calendar-note mr-1"></i>Details</a>
                                                        @elseif($user_type == 'admin')
                                                            <a href="{{ route('getProjectDetailsAdmin', $od['orderId']) }}" class="btn btn-primary btn-sm btnEdit"
                                                               id=""><i class="mr-1 zmdi zmdi-calendar-note"></i>Details</a>
                                                            <a href="{{ route('approveProject', $od['orderId']) }}" class="btn btn-info btn-sm btnEdit"
                                                               id=""><i class="fa fa-check mr-1" aria-hidden="true"></i>Approve</a>
                                                            <a href="{{ route('adminReviseProject', $od['orderId']) }}" class="btn btn-warning btn-sm btnEdit"
                                                               id=""><i class="mr-1 fa fa-circle-o-notch" aria-hidden="true"></i>Revise</a>
                                                        @elseif($user_type == 'buyer')
                                                            <a href="{{ route('getProjectDetailsBuyer', $od['orderId']) }}" class="btn btn-primary btn-sm btnEdit"
                                                               id=""><i class="zmdi zmdi-calendar-note mr-1"></i>Details</a>
                                                            <a href="{{ route('buyerApproveProject', $od['orderId']) }}" class="btn btn-info btn-sm btnEdit"
                                                               id=""><i class="fa fa-check mr-1" aria-hidden="true"></i>Approve</a>
                                                            <a href="{{ route('buyerReviseProject', $od['orderId']) }}" class="btn btn-warning btn-sm btnEdit"
                                                               id=""><i class="fa fa-circle-o-notch mr-1" aria-hidden="true"></i>Revise</a>
                                                        @endif
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
                </div>
            </div>


