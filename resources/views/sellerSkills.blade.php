@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 style="text-align:center;margin-bottom:30px">Freelance Plus</h2>
                <div class="card border border-primary">
                    <div class="card-body">
                        <p class="card-text">
                            Hello {{ session('seller')->getPerson()->name }}, Welcome to Freelance Plus where you can boost your career by using your skills.<br>
                            We will provide you a workplace where you can make best use of your skills.
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <strong class="card-title">Tell Us What Skills Do you have (Maximum:5)</strong><br><br>
                        <form action="registration" method="POST">
                        @csrf
                            <select id="ss" name="skills_tags[]" class="skills_tags" multiple="multiple">
                                @foreach ($skills as $skill)
                                    <option value={{$skill->id}}>{{$skill->title}}</option>
                                @endforeach
                                </select>
                            <button style="margin-top:20px;float:right" type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection