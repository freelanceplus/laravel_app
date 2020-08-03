@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 style="text-align:center;margin-bottom:30px">Freelance Plus</h2>
                <div class="card border border-primary">
                    <div class="card-body" id="info_container">
                        <p style="color:#000" class="card-text">
                            Based on your selected skills there will be a test. After That you will be getting projects for that skills.
                            <br><br>
                            <strong>Following are the rules for test.</strong></p>
                            <ol style="margin-left:15px">
                                <li>
                                This will be an MCQ based test consisting 20 MCQs
                                </li>    
                                <li>
                                Overall time for the test will be 30 minutes
                                </li>    
                                <li>
                                Once the test is started, there is no going back
                                </li>    
                                <li>
                                Once a question is marked it cannot be undo/redone
                                </li>    
                            </ol>    
                    </div>
                    <div class="card-body" style="display:none" id="question_container">
                        <b style="color:#000" class="card-text" id="question">question</b>
                        <br>
                        {{-- @php
                            $options = explode(",", $question->options);
                        @endphp     --}}
                        {{-- @foreach ($options as $option)
                        <input type="radio" id="{{$option}}" name="option" value="{{$option}}">
                        <label for="{{$option}}">{{$option}}</label><br>
                        @endforeach --}}
                    </div>
                </div>
                <form method="POST" action="{{URL::to('seller/submitResult')}}" id="resultForm" style="display:none">
                    @csrf
                    <input type="hidden" id="result" name="result">
                    <input type="submit" id="resultbtn" style="margin-left:45%;color:white;" value="Continue" class="btn btn-sm btn-primary"/>
                </form>
                <button onclick=startTest(this) style="margin-left:45%;color:white" class="btn btn-lg btn-primary">Start Test</button>
                <span id="questions" style="display:none">{{$questions}}</span>
                <button onclick=nextQuestion() id="nextQ" style="float:right;color:white;display:none" class="btn btn-lg btn-primary">Next</button>
            </div>
            
            <div class="col-md-8" id="message" style="margin-top:20px;display:none">
                <div class="card bg-danger">
                    <div class="card-body">
                        <p style="color:#fff">Please Select An Option, You Have to Attempt This Question to go to next one</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var questions;
    var index=0;
    var answers=[];
    function ifAnswerIsChecked() {
    return ($('input[type=radio]:checked').length > 0);
    }
    function loadQuestion(){
        if(index>=questions.length){
            $("#info_container").css('display','block');
            $("#question_container").css('display','none');
            $("#info_container").html("<b>Test is Finished</b>");
            $("#nextQ").css('display','none');
            $("#resultForm").css('display','block');
            score=0;
            for(var i=0;i<questions.length;i++){
                console.log(questions[i]['answer']+"shs"+answers[i]);
                if(questions[i]['answer']==answers[i]){
                    score++;
                }
            }
            
            $("#info_container").html("<b>Test is Finished</b><br><p>You Gave <b>"+score+" </b>Correct Answers Out of <b> "+questions.length+" </b> Questions");
            if(score >= questions.length/2){
                $("#info_container").append("<h4 style='color:green'>Congratulations, You have passed the Test</h4>");
                $("#result").attr('value',1);
            }
            else{
                $("#info_container").append("<h4 style='color:red'>We appreciate your attempt but it was not enough as per our criteria, Please try again later</h4>");
                $("#result").attr('value',0);
                }
        }
        else{
            options=questions[index]['options'].split(',');
            optionsHTML="";
            count=1;
            options.forEach(option => {
                optionsHTML=optionsHTML+"<input type='radio' id="+option+" name='option' value="+count+">"+
                            "<label for="+option+">"+option+"</label><br>";
                count++;
            });
            $("#question_container").html("<b style='color:#000' class='card-text'>"+questions[index]['question']+"</b><br>"+optionsHTML);
            
        }
    }
    function startTest(button){
        questions=JSON.parse($("#questions").text());
        $("#info_container").css('display','none');
        $(button).css('display','none');
        $("#nextQ").css('display','block');
        loadQuestion();
        $("#question_container").css('display','block');
    }
    function nextQuestion(){
        if(ifAnswerIsChecked()){
            answer=$('input[type=radio]:checked').val();
            answers[index]=answer;
            $("#message").css('display','none');
            index++;
            loadQuestion(); 
        }
        else{
            $("#message").css('display','block');
        }
        
    }

</script>
@endsection