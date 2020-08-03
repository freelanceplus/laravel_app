@extends('app')

@section('content')

    <body class="animsition" style="animation-duration: 900ms; opacity: 1;">
    <div class="page-wrapper bg-white">

        @include('reuse.adminSidebar');

        <!-- PAGE CONTAINER-->
        <div class="page-container bg-white">

            @include('reuse.navbarDesktopBuyer');

            <div class="main-content bg-white" style="padding-top: 6% !important;">
                <div class="section__content section__content--p0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1 heading-color">Skills</h2>
                                    <a class="au-btn au-btn-icon au-btn--blue admin-panel-color"
                                       href="{{ route('addSkill') }}">
                                        <i class="zmdi zmdi-plus"></i>add skill</a>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-5 ">
                            <div class="col-12">

                                <div class="table-responsive table--no-card m-b-40">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                        <tr>
                                            <th class="admin-panel-color">Skills</th>
{{--                                            <th class="admin-panel-color">Question</th>--}}
{{--                                            <th class="text-right admin-panel-color">Options</th>--}}
{{--                                            <th class="text-right admin-panel-color">Answer</th>--}}
                                            <th class="text-right admin-panel-color"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($skills != null)
                                            @foreach($skills as $skill)
                                                <tr>
                                                    <td class="text-danger">{{ $skill->title }}</td>
{{--                                                    <td>{{ $question->question }}</td>--}}
{{--                                                    <td class="text-right text-info">{{ $question->options }}</td>--}}
{{--                                                    <td class="text-right">{{ $question->answer }}</td>--}}
                                                    <td class="text-right">
                                                        <a href="{{ route('deleteSkill', $skill->id) }}" class="btn btn-danger btn-sm btnEdit"
                                                           id=""><i class="fa fa-trash pr-2" aria-hidden="true"></i>Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        @else
                                            <tr>
                                                <td></td>
{{--                                                <td></td>--}}
                                                <td class="text-danger">"No Data Available"</td>
{{--                                                <td></td>--}}
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


        </div>
        <!-- END PAGE CONTAINER-->

    </div>


    <!-- end document-->
    </body>


@endsection
