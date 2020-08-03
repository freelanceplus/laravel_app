<?php

namespace App\Http\Controllers\admin;

use App\Buyer;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Skill;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
    public function getSkills(){
        $notifications = $notifications = Notification::where('receiver', 'admin')->get()->all();;
        $skills = Skill::all();
        return view('admin.skills')
            ->with('notifications', $notifications)
            ->with('user_type', 'admin')
            ->with('user_name', 'admin')
            ->with('skills', $skills)
            ->with('check', 'skills')
            ->with('user_id', 1)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");

    }

    public function addSkill(){
        $notifications = $notifications = Notification::where('receiver', 'admin')->get()->all();
        return view('admin.addSkill')
            ->with('notifications', $notifications)
            ->with('user_type', 'admin')
            ->with('user_name', 'admin')
            ->with('check', '')
            ->with('user_id', 1)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");

    }

    public function postAddSkill(Request $request){
        Skill::create([
            'title' => $request->skill
        ]);
        return redirect()->route('getSkills');
    }

    public function deleteSkill($id){
        Skill::where('id', $id)->delete();
        return redirect()->route('getSkills');
    }

}
