
<div class="main-content bg-white" style="padding-top: 6% !important;">
    <div class="section__content section__content--p0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1 heading-color">Projects For Revision</h2>

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
                                <th class="text-right admin-panel-color">Buyer Name</th>
                                <th class="admin-panel-color" ></th>
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
                                        <td class="text-right">{{ $od['buyer_name'][0] }}</td>
                                        <td class="" style="width: 15%">
                                            @if($user_type == 'seller')
                                                <a href="{{ route('getProjectDetails', $od['orderId']) }}" class="btn btn-primary btn-sm btnEdit"
                                                   id=""><i class="zmdi zmdi-calendar-note mr-1"></i>Details</a>
                                                <a href="{{ route('sellerAcceptForRevision', $od['orderId']) }}" class="btn btn-info btn-sm btnEdit"
                                                   id=""><i class="fa fa-check mr-1" aria-hidden="true"></i>Accept</a>
                                            @elseif($user_type == 'admin')
                                                <a href="{{ route('getProjectDetailsAdmin', $od['orderId']) }}" class="btn btn-primary btn-sm btnEdit"
                                                   id=""><i class="zmdi zmdi-calendar-note mr-1"></i>Details</a>
                                                <a href="{{ route('adminAcceptForRevision', $od['orderId']) }}" class="btn btn-info btn-sm btnEdit"
                                                   id=""><i class="fa fa-check mr-1" aria-hidden="true"></i>Accept</a>
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


