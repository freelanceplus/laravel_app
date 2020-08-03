<?php

namespace App\Http\Controllers\Seller;

use App\Notification;
use App\Order;
use App\Person;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerDashboardController extends Controller
{
    public function showDashboard(){

        if(session()->has('seller')){
            if(session()->get('seller')->isVerified()){
                $seller_id = Seller::where('user_id', session('seller')->getPerson()->id)->pluck('id')->all();
                $seller_name = Person::where('id', session('seller')->getPerson()->id)->pluck('name');
                $notifications = Notification::where('receiver', 'seller')->where('receiver_id', $seller_id)->get();
                $new_requests = Order::where('status', 'assignToSeller')->where('seller_id', $seller_id)->get()->all();
                $in_progress = Order::where('status', 'onWorking')->where('seller_id', $seller_id)->get()->all();
                $completed = Order::where('status', 'completed')->where('seller_id', $seller_id)->get()->all();
                $for_revision = Order::where('status', 'revisionFromBuyer')->where('seller_id', $seller_id)->get()->all();
                $accepted = Order::where('status', 'accepted')->where('seller_id', $seller_id)->get()->all();
                $revision_from_buyer = Order::where('status', 'revisionFromBuyer')->where('seller_id', $seller_id)->get()->all();
                $approved = Order::where('status', 'approved')->where('seller_id', $seller_id)->get()->all();

//                if(!$new_requests){
//                    $new_requests = "";
//                }
//                if(!$in_progress){
//                    $in_progress = "";
//                }
//                if(!$completed){
//                    $completed = "";
//                }
//                if(!$for_revision){
//                    $for_revision = "";
//                }
//                if(!$approved){
//                    $approved = "";
//                }
//                dd($approved);
                $seller_info = Person::where('id', session('seller')->getPerson()->id)->get(['profile_pic'])->all();
                return view('sellerDashboard')
                    ->with('user_name', $seller_name[0])
                    ->with('user_id', $seller_id[0])
                    ->with('user_type', 'seller')
                    ->with('notifications', $notifications)
                    ->with('new_requests', $new_requests)
                    ->with('in_progress', $in_progress)
                    ->with('completed', $completed)
                    ->with('for_revision', $for_revision)
                    ->with('accepted', $accepted)
                    ->with('revision_from_buyer', $revision_from_buyer)
                    ->with('approved', $approved)
                    ->with('user_picture', $seller_info[0]->profile_pic)
                    ->with('check', 'dashboard');
            }
            else{
                return redirect('seller/skills');
            }
        }
        return redirect('seller/login');

    }
}
