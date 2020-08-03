
<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block bg-light">
    <div class="logo admin-panel-color p-0 m-0">
        <a href="{{ route('adminDashboard') }}">
            <img class="image " style="height: 50% !important; width: 200% !important;" src="{{ asset('images/freelance_white.png') }}" alt="FreeLauncePlus">
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1 ps">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="has-sub">
{{--                    @php--}}
{{--                    dd($check)--}}
{{--                    @endphp--}}
                    <a class="js-arrow sidebar-text {{$check=='dashboard' ? 'text-secondary' : ''}}"
                       href="{{ route('adminDashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                </li>

                        <li>
                            <a class="sidebar-text {{$check=='newRequests' ? 'text-secondary' : ''}}" href="{{ route('newRequests') }}">
                                <i class="zmdi zmdi-calendar-note"></i>
                                New Requests
                            </a>
                        </li>
                        <li>
                            <a class="sidebar-text {{$check=='inProgress' ? 'text-secondary' : ''}}" href="{{ route('onGoingProjectsAdmin') }}">
                                <i class="fa fa-tasks" aria-hidden="true"></i>In Progress</a>
                        </li>
                        <li>
                            <a class="sidebar-text {{$check=='completed' ? 'text-secondary' : ''}}" href="{{ route('completedProjectsAdmin') }}">
                                <i class="fa fa-check" aria-hidden="true"></i>Completed</a>
                        </li>
                        <li>
                            <a class="sidebar-text {{$check=='forRevision' ? 'text-secondary' : ''}}" href="{{ route('inRevisionProjectsAdmin') }}">
                                <i class="fa fa-circle-o-notch" aria-hidden="true"></i>For Revision</a>
                        </li>
                        <li>
                            <a class="sidebar-text {{$check=='approved' ? 'text-secondary' : ''}}" href="{{ route('approvedProjectsAdmin') }}">
                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>Approved</a>
                        </li>
                        <li>
                            <a class="sidebar-text {{$check=='accepted' ? 'text-secondary' : ''}}" href="{{ route('acceptedProjectsAdmin') }}">
                                <i class="fa fa-check-square" aria-hidden="true"></i>Accepted</a>
                        </li>
                        <hr>
                        <li>
                            <a class="sidebar-text {{$check=='developers' ? 'text-secondary' : ''}}" href="{{ route('developers') }}">
                                <i class="fa fa-users" aria-hidden="true"></i>Developers</a>
                        </li>
                        <li>
                            <a class="sidebar-text {{$check=='questions' ? 'text-secondary' : ''}}" href="{{ route('getQuestions') }}">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>Questions</a>
                        </li>
                        <li>
                            <a class="sidebar-text {{$check=='skills' ? 'text-secondary' : ''}}" href="{{ route('getSkills') }}">
                                <i class="fa fa-question-circle" aria-hidden="true"></i>Skills</a>
                        </li>
{{--                    </ul>--}}
{{--                </li>--}}

            </ul>
        </nav>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
</aside>
<!-- END MENU SIDEBAR-->
