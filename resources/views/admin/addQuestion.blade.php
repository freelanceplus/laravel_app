@extends('app')

@section('content')

    <body class="animsition " style="animation-duration: 900ms; opacity: 1;">
    <div class="page-wrapper bg-white">

        @include('reuse.adminSidebar');

        <!-- PAGE CONTAINER-->
        <div class="page-container">


            @include('reuse.navbarDesktopBuyer');

            <!-- MAIN CONTENT-->
            <div class="main-content bg-white" style="padding-top: 6% !important;">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 shadow">
                                <div class="card border-0">
                                    <div class="card-body p-4">
                                        <div class="card-title">
                                            <h3 class="text-center title-2 mt-1 font-weight-bold">Add Question</h3>
                                        </div>
                                        <hr>
                                        <form action="{{ route('addQuestion') }}" method="POST" enctype="multipart/form-data"
                                              novalidate="novalidate">
                                            <div class="form-group">
                                                <label for="skill" class="control-label mb-1 mt-2 font-weight-bold">Select Skill</label>
                                                <select class="form-control select2 mt-3 {{ $errors->has('tvseries_id') ? ' is-invalid' : '' }}"
                                                        style="width: 100%;" name="skill">
                                                    <option selected disabled hidden>Select option</option>
                                                    @foreach($skills as $skill)
                                                        <option value="{{$skill->id}}" {{ old('skill')==$skill->title ? 'selected' : '' }}>
                                                            {{ $skill->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('skill'))
                                                    <span class="text-danger">
                                                        <small>{{ $errors->first('skill') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="question" class="control-label mb-1 mt-2 font-weight-bold">Question</label>
                                                <input id="question" name="question" type="text"
                                                       class="form-control {{ $errors->has('question') ? ' is-invalid' : '' }}" aria-required="true"
                                                       aria-invalid="false">
                                                @if ($errors->has('question'))
                                                    <span class="text-danger">
                                                        <small>{{ $errors->first('question') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="option1" class="control-label mb-1 mt-1 font-weight-bold">Option 1</label>
                                                <input id="option1" name="option1" type="tel"
                                                       class="form-control cc-number identified visa {{ $errors->has('option1') ? ' is-invalid' : '' }}"
                                                       >
                                                <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                                                @if ($errors->has('option1'))
                                                    <span class="text-danger">
                                                        <small>{{ $errors->first('option1') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="option2" class="control-label mb-1 mt-1 font-weight-bold">Option 2</label>
                                                <input id="option2" name="option2" type="tel"
                                                       class="form-control cc-number identified visa {{ $errors->has('option2') ? ' is-invalid' : '' }}"
                                                       >
                                                <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                                                @if ($errors->has('option2'))
                                                    <span class="text-danger">
                                                        <small>{{ $errors->first('option2') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="option3" class="control-label mb-1 mt-1 font-weight-bold">Option 3</label>
                                                <input id="option3" name="option3" type="tel"
                                                       class="form-control cc-number identified visa {{ $errors->has('option3') ? ' is-invalid' : '' }}"
                                                       >
                                                <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                                                @if ($errors->has('option3'))
                                                    <span class="text-danger">
                                                        <small>{{ $errors->first('option3') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="option4" class="control-label mb-1 mt-1 font-weight-bold">Option 4</label>
                                                <input id="option4" name="option4" type="tel"
                                                       class="form-control cc-number identified visa {{ $errors->has('option4') ? ' is-invalid' : '' }}"
                                                       >
                                                <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                                                @if ($errors->has('option4'))
                                                    <span class="text-danger">
                                                        <small>{{ $errors->first('option4') }}</small>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="answer_option" class="control-label mb-1 mt-1 font-weight-bold">Answer Option</label>
                                                <input id="answer_option" name="answer_option" type="tel"
                                                       class="form-control cc-number identified visa {{ $errors->has('answer_option') ? ' is-invalid' : '' }}"
                                                       >
                                                <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                                                @if ($errors->has('answer_option'))
                                                    <span class="text-danger">
                                                        <small>{{ $errors->first('answer_option') }}</small>
                                                    </span>
                                                @endif
                                            </div>


                                            <div class="mt-5">
                                                <div class="col-md-12 text-center">
                                                    <button type="submit" class="btn btn-lg"
                                                            style="width: 50%; border-radius: 12px; background-color: #02a8d5; color:white">SUBMIT
                                                    </button>
                                                </div>
                                            </div>

                                            <input type="hidden" name="_token" value={{csrf_token()}}>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTAINER-->

        </div>

    </div>
    <!-- end document-->
    </body>


@endsection


