<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Notification;
use App\Order;
use App\Person;
use App\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SellerAccountController extends Controller
{
    public function sellerAccount(){
        session()->forget('password_mismatch_message_seller');
        $seller_id = Seller::where('user_id', session('seller')->getPerson()->id)->pluck('id')->all();
        $orders = Order::where('seller_id', $seller_id[0])->get();
        $total_money_spend = Order::where('seller_id', $seller_id[0])->sum('budget');
//        DB::table('data')->sum('balance');
        $seller_info = Person::where('id', session('seller')->getPerson()->id)->get(['email', 'profile_pic'])->all();
        $notifications = Notification::where('receiver', 'seller')->where('receiver_id', $seller_id)->get()->all();
//        dd($buyer_email);
        return view('seller.myAccount')
            ->with('notifications', $notifications)
            ->with('user_type', 'seller')
            ->with('total_orders', $orders)
            ->with('total_money_spend', $total_money_spend)
            ->with('user_name', session('seller')->getPerson()->name)
            ->with('user_email', $seller_info[0]->email)
            ->with('user_picture', $seller_info[0]->profile_pic)
            ->with('user_id', $seller_id[0])
            ->with('check', 'myAccount');
    }

    public function editProfileSeller(){
        $seller_id = Seller::where('user_id', session('seller')->getPerson()->id)->pluck('id')->all();
        $seller_email = Person::where('id', session('seller')->getPerson()->id)->pluck('email')->all();
        $notifications = Notification::where('receiver', 'seller')->where('receiver_id', $seller_id)->get()->all();
        $seller_info = Person::where('id', session('seller')->getPerson()->id)->get(['email', 'profile_pic'])->all();

        return view('seller.editAccount')
            ->with('notifications', $notifications)
            ->with('user_type', 'seller')
            ->with('user_id', session('seller')->getPerson()->id)
            ->with('user_name', session('seller')->getPerson()->name)
            ->with('user_email', $seller_email[0])
            ->with('user_picture', $seller_info[0]->profile_pic)
            ->with('user_id', $seller_id[0])
            ->with('check', '');
    }

    public function postEditProfileSeller(Request $request){
        if($request->firebase_images_url == null){
            Person::where('id', session('seller')->getPerson()->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
        }else{
            Person::where('id', session('seller')->getPerson()->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'profile_pic' => $request->firebase_images_url,
                ]);
        }

        return redirect()->route('sellerAccount');
    }

    public function changeSellerPassword(){
        $seller_id = Seller::where('user_id', session('seller')->getPerson()->id)->pluck('id')->all();
        $notifications = Notification::where('receiver', 'seller')->where('receiver_id', $seller_id)->get()->all();
        $seller_info = Person::where('id', session('seller')->getPerson()->id)->get(['email', 'profile_pic'])->all();

        return view('seller.changePassword')
            ->with('notifications', $notifications)
            ->with('user_type', 'seller')
            ->with('user_name', session('seller')->getPerson()->name)
            ->with('user_id', session('seller')->getPerson()->id)
            ->with('check', '')
            ->with('user_id', $seller_id[0])
        ->with('user_picture', $seller_info[0]->profile_pic);

    }
    public function postChangeSellerPassword(Request $request){
        $this->validate($request, [
            'password' => 'required',
            'confirm_password' => 'required',
        ]);
        session_start();
        if (strcmp($request['password'], $request['confirm_password']) != 0) {
            session(['password_mismatch_message_seller' => 'Password and Confirm Password doesnt match']);
            return redirect('changeSellerPassword');
        } else {
            Person::where('id', session('seller')->getPerson()->id)
                ->update([
                    'password' => Hash::make($request['password']),
                ]);
            return redirect()->route('sellerAccount');
        }
    }
}
