<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\Controller;
use App\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BuyerLoginSignupController extends Controller
{
    public function getBuyerByPersonId($user_id){
        $buyer=Buyer::updateOrCreate(['account_balance'=>0, 'user_id' => $user_id]);
        return $buyer;
    }

    public function login(){
        if(session()->has('buyer')){
            return redirect('buyer/dashboard');
        }
        session()->forget('buyer_message');
        return view('buyer.login')->with('user_type', 'buyer');
    }

    public function validateBuyer(Request $request){
        session_start();
        $person=Person::where('email', $request['email'])->first();

        if($person){
            if(Hash::check($request['password'],$person->password)){
                $buyer=Buyer::where('user_id',$person->id)->get()[0];
                session(['buyer'=>$buyer]);
                return redirect('buyer/dashboard');
            }
            else{
                session(['buyer_message_login'=>'Wrong Password']);
            }
        }
        else{
            session(['buyer_message_login'=>'Email Does not Exist']);
        }
        return redirect('/buyer/login');
    }

    public function logout(){
        session()->forget('user');
        session()->forget('verified');
        return redirect('/buyer/login');
    }
    public function buyerSignup(){
        session()->forget('buyer_message_login');
        return view('buyer.buyerRegister')->with('user_type', 'buyer');
    }

    public function postBuyerSignup(Request $request)
    {
//        dd($request);
        if (strcmp($request['password'], $request['password_confirmation']) != 0) {
            session(['buyer_message' => 'Password and Confirm Password doesnt match']);
            return redirect('/buyer/signup');
        } else {
            try {
                $person = Person::create
                (['name' => $request['name'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password'])]);
            } catch (\Illuminate\Database\QueryException $e) {
                session(['buyer_message' => 'Email Already Exists']);
                return redirect('/buyer/signup');
            }
            $buyer = $this->getBuyerByPersonId($person->id);
            session(['buyer' => $buyer]);
            return redirect('/buyer/dashboard');
        }
    }
    public function buyerLogout(){
        session()->forget('buyer');
        return redirect('/buyer/login');
    }
}
