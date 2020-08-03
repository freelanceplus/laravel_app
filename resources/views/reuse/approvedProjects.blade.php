
<div class="main-content bg-white" style="padding-top: 6% !important;">
    <div class="section__content section__content--p0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1 heading-color">Approved Projects</h2>

                    </div>
                </div>
            </div>


            <div class="row mt-5 ">
                <div class="col-12">

                    <div class="table-responsive table--no-card m-b-40">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                            <tr>
                                <th class="admin-panel-color">Deadline</th>
                                <th class="admin-panel-color">title</th>
                                <th class="text-right admin-panel-color">budget</th>
                                <th class="text-right admin-panel-color">project type</th>
                                @if($user_type == 'admin')
                                    <th class="text-right admin-panel-color">Buyer Name</th>
                                    <th class="text-right admin-panel-color">Seller Name</th>
                                    <th class="text-right admin-panel-color"></th>
                                @elseif($user_type == 'buyer')
                                    <th class="text-right admin-panel-color">Seller Name</th>
                                @elseif($user_type == 'seller')
                                    <th class="text-right admin-panel-color"></th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @if($orders_data[0] != null)
                                @foreach($orders_data as $od)
                                    <tr>
                                        <td class="text-danger">{{ $od['deadline'] }}</td>
                                        <td>{{ $od['title'] }}</td>
                                        <td class="text-right text-info">{{ $od['budget'] }}</td>
                                        <td class="text-right">{{ $od['project_type'] }}</td>
                                        @if($user_type == 'admin')
                                            <td class="text-right">{{ $od['buyer_name'][0] }}</td>
                                            <td class="text-right">{{ $od['seller_name'][0] }}</td>
                                            <td class="text-right">
                                                <a href="{{ route('getProjectDetailsAdmin', $od['orderId']) }}" class="btn btn-primary btn-sm btnEdit"
                                                   id=""><i class="mr-1 zmdi zmdi-calendar-note"></i>Details</a>
                                            </td>
                                        @elseif($user_type == 'buyer')
                                            <td class="text-right">{{ $od['seller_name'][0] }}</td>
                                        @endif
                                    </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td></td>
                                    <td></td>
                                    @if($user_type != 'seller')
                                    <td></td>
                                    @endif
                                    <td class="text-danger">"No Data Available"</td>
                                    <td></td>
                                    @if($user_type == 'admin')
                                        <td></td>
                                    @endif
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



