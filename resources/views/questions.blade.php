@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 style="text-align:center;margin-bottom:30px">Freelance Plus</h2>
                <div class="card border">
                    <div class="card-body">
                        <b style="color:#000" class="card-text">{{$question->question}}</b>
                        <br>
                        @php
                            $options = explode(",", $question->options);
                        @endphp    
                        @foreach ($options as $option)
                        <input type="radio" id="{{$option}}" name="option" value="{{$option}}">
                        <label for="{{$option}}">{{$option}}</label><br>
                        @endforeach
                    </div>
                </div>
                <button style="margin-left:45%" class="btn btn-lg btn-primary">Next Question</button>
            </div>
        </div>
    </div>
</div>
@endsection