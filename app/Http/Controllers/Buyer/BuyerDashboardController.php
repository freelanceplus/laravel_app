<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Order;
use App\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuyerDashboardController extends Controller
{
    public function dashboard(){
        $orders_after_check = [];
        if(session('buyer') == null){
            return redirect('buyer/login');
        }
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $notifications = Notification::where('receiver', 'buyer')->where('receiver_id', $buyer_id)->get()->all();
        $new_requests = Order::where('status', 'requested')->where('buyer_id', $buyer_id)->get()->all();
        $in_progress = DB::table('orders')->where('buyer_id', $buyer_id)->get();
//        $orders_after_check = "";
        $count = 0;
//        dd(sizeof($in_progress));
        if(sizeof($in_progress) != 0){
            foreach ($in_progress as $in){
//                dd($in);
                if($in->status == "OnWorking" || $in->status == "assignToSeller" || $in->status == "completed"
                    || $in->status == "revisionFromAdmin" || $in->status == "revisionFromBuyer"){

                    $orders_after_check[$count] = $in;
                    $count++;
                }
            }
        }else{
            $orders_after_check = [];
        }
//        $files = $files . "\\" . $filename . ",";
        $profile_pic = Person::where('id', session('buyer')->getPerson()->id)->pluck('profile_pic')->all();
//        $profile_pic = storage_path()."\images"."\\".$profile_pic[0];
        $profile_pic = storage_path()."\app\public\users\black.jpg";

        $in_progress = $orders_after_check;
        $completed = Order::where('status', 'approved')->where('buyer_id', $buyer_id)->get()->all();
        $approved = Order::where('status', 'accepted')->where('buyer_id', $buyer_id)->get()->all();
        $buyer_info = Person::where('id', session('buyer')->getPerson()->id)->get(['profile_pic'])->all();
        return view('buyer.buyerDashboard')
            ->with('notifications', $notifications)
            ->with('user_name', session('buyer')->getPerson()->name)
            ->with('user_type', 'buyer')
            ->with('user_id', $buyer_id[0])
            ->with('profile_pic', $profile_pic)
            ->with('new_requests', $new_requests)
            ->with('in_progress', $in_progress)
            ->with('completed', $completed)
            ->with('approved', $approved)
            ->with('user_picture', $buyer_info[0]->profile_pic)

            ->with('check', 'dashboard');
    }
}
