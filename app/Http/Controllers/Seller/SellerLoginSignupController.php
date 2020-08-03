<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Person;
use App\Skill;
use App\Seller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class SellerLoginSignupController extends Controller
{
    public function getSellerByPersonId($user_id){
        $seller=Seller::updateOrCreate(['varified' => 0,'account_balance'=>0, 'user_id' => $user_id]);
        return $seller;
    }
    public function loadSkills(){
        $skills=Skill::all('id','title');
        return $skills;
    }
    public function login(){
        session()->forget('message');
        if(session()->has('seller')){
            return redirect('seller/dashboard');
        }
        return view('auth.login')->with('user_type', 'seller');
    }
    public function validateSeller(Request $request){
        session_start();
        $person=Person::where('email', $request['email'])->first();
        $skills=Skill::all();
        if($person){
            if(Hash::check($request['password'],$person->password)){
                $seller=Seller::where('user_id',$person->id)->get()[0];
                session(['seller'=>$seller]);
                return redirect('seller/dashboard')->with('skills',$skills);
            }
            else{
                session(['message_seller'=>'Wrong Password']);
            }
        }
        else{
            session(['message_seller'=>'Email Does not Exist']);
        }
        return redirect('/seller/login');
    }
    public function addSkills()
    {
        if(session()->has('seller')){
            if(session('seller')->isVerified()){
                return redirect('seller/dashboard');
            }
            else{
                $skills=$this->loadSkills();
                return view('sellerSkills')->with("skills",$skills)
                    ->with('user_type', 'seller');
            }
        }
        return redirect('seller/login');
    }

    public function logout(){
        session()->forget('seller');
        return redirect('/seller/login');
    }

    public function signup(){
        session()->forget('message_seller');
        return view('auth.register')->with('user_type', 'seller');
    }

    public function register(Request $request){

        if(strcmp($request['password'],$request['password_confirmation'])!=0){
            session(['message'=>'Password and Confirm Password doesnt match']);
            return redirect('/seller/signup');
        }
        else{
            try {
            $person=Person::create
                (['name'=>$request['name'],
                'email'=>$request['email'],
                'password'=> Hash::make($request['password'])]);
            } catch (\Illuminate\Database\QueryException $e) {
                session(['message'=>'Email Already Exists']);
                return redirect('seller/signup');
            }
            $seller=$this->getSellerByPersonId($person->id);
            session(['seller'=>$seller]);
            return redirect('/seller/skills');
        }
    }

    public function sellerLogout(){
        session()->forget('seller');
        return redirect('/seller/login');
    }
}
