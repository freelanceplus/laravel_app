<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Notification;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionsController extends Controller
{
    public function getQuestions(){

        $questions = DB::table('questions')
            ->join('skills', 'skills.id', 'questions.skill_id')
            ->select(['skills.title', 'questions.id', 'questions.question', 'questions.options', 'questions.answer'])
            ->get();
//        dd($questions);
        $notifications = Notification::where('receiver', 'admin')->get()->all();
        return view('admin.questions')->with('user_type', 'admin')
            ->with('notifications', array_reverse($notifications))
            ->with('questions', $questions)
            ->with('user_name', 'admin')
            ->with('check', 'questions')
            ->with('user_id', 1)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");

    }

    public function editQuestion($id){

        $questions = DB::table('questions')
            ->join('skills', function ($join) use ($id) {
                $join->on('skills.id', '=', 'questions.skill_id')
                    ->where('questions.id', '=', $id);
        })
            ->select(['skills.title', 'questions.id', 'questions.question', 'questions.options', 'questions.answer'])
            ->get();

        $skills = DB::table('skills')->get(['id', 'title']);
        $notifications = Notification::where('receiver', 'admin')->get()->all();
        $options = explode(',', $questions[0]->options);

        return view('admin.editQuestion')
            ->with('options', $options)
            ->with('questions', $questions)
            ->with('user_name', 'admin')
            ->with('user_type', 'admin')
            ->with('skills', $skills)
            ->with('user_id', 1)
            ->with('check', 'questions')
            ->with('notifications', array_reverse($notifications))
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");

    }

    public function postEditQuestion(Request $request, $id){
        $this->validate($request, [
            'skill' => 'required',
            'question' => 'required',
            'option1' => 'required',
            'option1' => 'required',
            'option2' => 'required',
            'option3' => 'required',
            'option4' => 'required',
            'answer_option' => 'required',
        ]);

        $options = $request->option1.",".$request->option2.",".$request->option3.",".$request->option4;
        Question::where('id', $id)
            ->update([
                'question' => $request->question,
                'options' => $options,
                'answer' => $request->answer_option,
                'skill_id' => $request->skill
            ]);
        return redirect()->route('getQuestions');
    }

    public function addQuestion(Request $request){
        $notifications = Notification::where('receiver', 'admin')->get()->all();
        $skills = DB::table('skills')->get(['id', 'title']);

        return view('admin.addQuestion')
            ->with('user_name', 'admin')
            ->with('user_type', 'admin')
            ->with('skills', $skills)
            ->with('notifications', array_reverse($notifications))
            ->with('check', 'questions')
            ->with('user_id', 1)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");

    }

    public function postAddQuestion(Request $request){
        $this->validate($request, [
            'skill' => 'required',
            'question' => 'required',
            'option1' => 'required',
            'option1' => 'required',
            'option2' => 'required',
            'option3' => 'required',
            'option4' => 'required',
            'answer_option' => 'required',
        ]);

        $options = $request->option1.",".$request->option2.",".$request->option3.",".$request->option4;
        DB::table('questions')->insert([
                'question' => $request->question,
                'options' => $options,
                'answer' => $request->answer_option,
                'skill_id' => $request->skill,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        return redirect()->route('getQuestions');
    }

    public function deleteQuestion($id){
        Question::where('id',$id)->delete();
        return redirect()->route('getQuestions');
    }

}
