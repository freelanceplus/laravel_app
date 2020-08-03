<div class="main-content" style="padding-top: 6% !important;">
    <div class="section__content section__content--p0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        @if($user_type == 'buyer')
                            <h2 class="title-1 heading-color">Pending Requests</h2>
                        @else
                            <h2 class="title-1 heading-color">New Requests</h2>
                        @endif
                    </div>
                </div>
            </div>


            <div class="row mt-5">
                <div class="col-12">

                    <div class="table-responsive table--no-card m-b-40">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                            <tr>
                                <th class="admin-panel-color">deadline</th>
                                <th class="admin-panel-color">order ID</th>
                                <th class="admin-panel-color">title</th>
                                <th class="text-right admin-panel-color">budget</th>
                                <th class="text-right admin-panel-color">project type</th>
                                <th class="text-right admin-panel-color" >Buyer Name</th>
                                <th class="admin-panel-color" ></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($orders_data[0] != null)
                                @foreach($orders_data as $od)
                                    <tr>
                                        <td>{{ $od['deadline'] }}</td>
                                        <td>{{ $od['orderId'] }}</td>
                                        <td>{{ $od['title'] }}</td>
                                        <td class="text-right">{{ $od['budget'] }}</td>
                                        <td class="text-right">{{ $od['project_type'] }}</td>
                                        <td class="text-right">{{ $od['buyer_name'][0] }}</td>
                                        @if($user_type == 'admin')
                                            <td class="" style="width: 15%">
                                                <a href="{{ route('getProjectDetailsAdmin', $od['orderId']) }}" data-toggle="modal" class="btn btn-primary btn-sm btnEdit"
                                                   id=""><i class="mr-1 zmdi zmdi-calendar-note"></i>Details</a>

                                                <a href="{{ route('assignProject', $od['orderId']) }}" data-toggle="modal" class="btn btn-info btn-sm btnEdit"
                                                   id=""><i class="mr-1 fas fa-edit"></i>Assign</a>

                                                <a href="{{ route('rejectProject', $od['orderId']) }}" data-toggle="modal" class="btn btn-danger btn-sm btnEdit"
                                                   id=""><i class="mr-1 fas fa-trash"></i>Reject</a>
                                            </td>
                                        @elseif($user_type == 'buyer')
                                            <td class="" style="width: 15%">
                                                <a href="{{ route('getProjectDetailsBuyer/'.$od['orderId']) }}" class="btn btn-primary btn-sm btnEdit"
                                                   id=""><i class="zmdi zmdi-calendar-note mr-1"></i>Details</a>
                                                <a href="{{ route('buyerEditProject', $od['orderId']) }}" data-toggle="modal" class="btn btn-primary btn-sm btnEdit"
                                                   id=""><i class="mr-1 fas fa-edit"></i>Edit</a>
                                                <a href="{{ route('buyerDeleteProject', $od['orderId']) }}" data-toggle="modal" class="btn btn-danger btn-sm btnEdit"
                                                   id=""><i class="mr-1 fas fa-trash"></i>Delete</a>
                                            </td>
                                        @elseif($user_type == 'seller')
                                            <td class="" style="width: 15%">
                                                <a href="{{ route('getProjectDetails', $od['orderId']) }}" class="btn btn-primary btn-sm btnEdit"
                                                   id=""><i class="zmdi zmdi-calendar-note mr-1"></i>Details</a>
                                                <a href="{{ route('sellerAcceptProject', $od['orderId']) }}" data-toggle="modal" class="btn btn-info btn-sm btnEdit"
                                                   id=""><i class="mr-1 fas fa-edit"></i>Accept</a>
                                                <a href="{{ route('sellerRejectProject', $od['orderId']) }}" data-toggle="modal" class="btn btn-danger btn-sm btnEdit"
                                                   id=""><i class="mr-1 fas fa-trash"></i>Reject</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="color: red">No Data Available</td>
                                    <td></td>
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
