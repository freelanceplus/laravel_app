<div class="main-content">
    <div class="section__content section__content--p0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">{{ $projects_title }}</h2>

                    </div>
                </div>
            </div>


            <div class="row mt-5 ">
                <div class="col-12">

                    <div class="table-responsive table--no-card m-b-40">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                            <tr>
                                <th>deadline</th>
                                <th>order ID</th>
                                <th>title</th>
                                <th class="text-right">budget</th>
                                <th class="text-right">project type</th>
                                <th class="text-right">Buyer Name</th>
                                <th class=""></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($orders_data[0] != null)
                                @foreach($orders_data as $od)
                                    <tr>
                                        <td class="text-danger">{{ $od['deadline'] }}</td>
                                        <td>{{ $od['orderId'] }}</td>
                                        <td>{{ $od['title'] }}</td>
                                        <td class="text-right">{{ $od['budget'] }}</td>
                                        <td class="text-right">{{ $od['project_type'] }}</td>
                                        <td class="text-right">{{ $od['buyer_name'][0] }}</td>
                                        <td class="" style="width: 15%">

                                            @if($projects_page == "newRequests")
                                            <a href="{{ route('sellerAcceptProject', $od['orderId']) }}" class="btn btn-info btn-sm btnEdit"
                                               id=""><i class="fa fa-check" aria-hidden="true"></i>Accept</a>

                                            <a href="{{ route('sellerRejectProject', $od['orderId']) }}" class="btn btn-danger btn-sm btnEdit"
                                               id=""><i class="mr-1 fas fa-trash"></i>Reject</a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>"No Data Available"</td>
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

            <div class="row">
                <div class="col-md-12">
                    <div class="copyright">
                        <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
