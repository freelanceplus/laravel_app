<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Skill;
use App\FK\SellerSkill;
use App\Seller;
use App\Question;
use App\Http\Controllers\Controller;

class SellerSkillsController extends Controller
{

    public function getSellerByPersonId($user_id){
        $seller=Seller::where('user_id',$user_id)->get();
        return $seller;
    }

    public function loadSkills(){
        $skills=Skill::all('id','title');
        return $skills;
    }
    public function loadQuestions($skill_tags){
        $questions;
        foreach ($skill_tags as $skill_tag){
            if(isset($questions)){
                $questions->merge(Question::where('skill_id',$skill_tag)->get()->random(3));
            }
            else{
                $questions=Question::where('skill_id',$skill_tag)->get()->random(3);
            }
        }
        return $questions;
    }
    public function registerSkills(Request $request){
        $seller_id=session('seller')->id;
        $skill_tags= $request->input('skills_tags');
        foreach ($skill_tags as $skill_tag){
           SellerSkill::updateOrCreate(['seller_id'=>$seller_id, 'skill_id'=>$skill_tag]);
        }
        $questions=$this->loadQuestions($skill_tags);
        return view('sellerTest')->with('questions',$questions)
            ->with('user_type', 'seller');
    }
    public function sellerTest(Request $request,$qNo){
        $question=Question::find(1)->get();
        return view('questions')->with('question',$question[0])
            ->with('user_type', 'seller');
    }
    public function submitResults(Request $request){
        $user_id=session('seller')->getPerson()->id;
        $result=$request->input('result');
        if($result=='1'){
            $seller=Seller::where('user_id',$user_id)->update(['varified'=>1]);
            session(['seller'=>$this->getSellerByPersonId($user_id)[0]]);
            return redirect('/seller/dashboard');
        }
        else{
            return redirect('/seller/skills');
        }

    }
}
