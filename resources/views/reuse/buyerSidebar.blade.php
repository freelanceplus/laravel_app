
<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo admin-panel-color p-0 m-0">
        <a href="{{ url('/buyer/dashboard') }}">
            <img class="image " style="height: 50% !important; width: 200% !important;" src="{{ asset('images/freelance_white.png') }}" alt="FreeLauncePlus">
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1 ps bg-light" style="border-right-color: black !important;">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="has-sub" >
                    <a class="js-arrow sidebar-text {{$check=='dashboard' ? 'text-secondary' : ''}}" href="{{ url('/buyer/dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                </li>

                <li class="active has-sub">
{{--                    <a class="js-arrow sidebar-text" href="#">--}}
{{--                        <i class="fas fa-desktop"></i>Projects</a>--}}
{{--                    <ul class="list-unstyled navbar__sub-list js-sub-list">--}}
                        <li>

                            <a class="sidebar-text {{$check=='newRequests' ? 'text-secondary' : ''}}" href="{{ route('buyerNewRequests') }}">
                                <i class="zmdi zmdi-calendar-note"></i>Pending Requests</a>
                        </li>
                        <li>
                            <a class="sidebar-text {{$check=='inProgress' ? 'text-secondary' : ''}}" href="{{ route('buyerInProgress') }}">
                                <i class="fa fa-tasks" aria-hidden="true"></i>In Progress</a>
                        </li>
                        <li>
                            <a class="sidebar-text {{$check=='completed' ? 'text-secondary' : ''}}" href="{{ route('buyerCompletedProjects') }}">
                                <i class="fa fa-check" aria-hidden="true"></i>Completed</a>
                        </li>
                        <li>
                            <a class="sidebar-text {{$check=='approved' ? 'text-secondary' : ''}}" href="{{ route('buyerApprovedProjects') }}">
                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>Approved</a>
                        </li>
                        <hr>
                        <li>
                            <a class="sidebar-text {{$check=='my_account' ? 'text-secondary' : ''}}" href="{{ route('buyerAccount') }}">
                                <i class="fa fa-users" aria-hidden="true"></i>My Account</a>
                        </li>
{{--                        <li>--}}
{{--                            <a href="{{ route('inRevisionProjects') }}">For Revision</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="{{ route('inRevisionProjects') }}">For Revision</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}

            </ul>
        </nav>


        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
</aside>
<!-- END MENU SIDEBAR-->


