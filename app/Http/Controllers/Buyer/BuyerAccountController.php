<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Order;
use App\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BuyerAccountController extends Controller
{
    public function buyerAccount(){
        session()->forget('password_mismatch_message');
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $orders = Order::where('buyer_id', $buyer_id[0])->get();
        $total_money_spend = Order::where('buyer_id', $buyer_id[0])->sum('budget');
//        DB::table('data')->sum('balance');
        $buyer_info = Person::where('id', session('buyer')->getPerson()->id)->get(['email', 'profile_pic'])->all();
        $notifications = Notification::where('receiver', 'buyer')->where('receiver_id', $buyer_id)->get()->all();
//        dd($buyer_id);
        return view('buyer.myAccount')
            ->with('notifications', $notifications)
            ->with('user_type', 'buyer')
            ->with('total_orders', $orders)
            ->with('total_money_spend', $total_money_spend)
            ->with('user_name', session('buyer')->getPerson()->name)
            ->with('user_email', $buyer_info[0]->email)
            ->with('user_picture', $buyer_info[0]->profile_pic)
            ->with('user_id', $buyer_id[0])
            ->with('check', 'myAccount');
    }

    public function editProfileBuyer(){
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $buyer_email = Person::where('id', session('buyer')->getPerson()->id)->pluck('email')->all();
        $notifications = Notification::where('receiver', 'buyer')->where('receiver_id', $buyer_id)->get()->all();
        $buyer_info = Person::where('id', session('buyer')->getPerson()->id)->get(['email', 'profile_pic'])->all();

        return view('buyer.editAccount')
            ->with('notifications', $notifications)
            ->with('user_type', 'buyer')
            ->with('user_id', session('buyer')->getPerson()->id)
            ->with('user_name', session('buyer')->getPerson()->name)
            ->with('user_email', $buyer_email[0])
            ->with('user_picture', $buyer_info[0]->profile_pic)
            ->with('check', '');
    }

    public function postEditProfileBuyer(Request $request){
//        dd($request);
        if($request->firebase_images_url == null){
            Person::where('id', session('buyer')->getPerson()->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
        }else{
            Person::where('id', session('buyer')->getPerson()->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'profile_pic' => $request->firebase_images_url,
                ]);
        }

        return redirect()->route('buyerAccount');
    }

    public function changeBuyerPassword(){
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $notifications = Notification::where('receiver', 'buyer')->where('receiver_id', $buyer_id)->get()->all();
        $buyer_info = Person::where('id', session('buyer')->getPerson()->id)->get(['email', 'profile_pic'])->all();

        return view('buyer.changePassword')
            ->with('notifications', $notifications)
            ->with('user_type', 'buyer')
            ->with('user_name', session('buyer')->getPerson()->name)
            ->with('user_id', session('buyer')->getPerson()->id)
            ->with('user_picture', $buyer_info[0]->profile_pic)
            ->with('check', '');

    }

    public function postChangeBuyerPassword(Request $request){
        $this->validate($request, [
            'password' => 'required',
            'confirm_password' => 'required',
        ]);
        session_start();
        if (strcmp($request['password'], $request['confirm_password']) != 0) {
            session(['password_mismatch_message' => 'Password and Confirm Password doesnt match']);
            return redirect()->route('changeBuyerPassword');
        } else {
            Person::where('id', session('buyer')->getPerson()->id)
                ->update([
                    'password' => Hash::make($request['password']),
                ]);
            return redirect()->route('buyerAccount');
        }
    }



}
