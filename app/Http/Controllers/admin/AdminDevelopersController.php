<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Notification;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDevelopersController extends Controller
{
    public function developers(){
        $sellers_data = [];
        $count = 0;

        $sellers = DB::table('sellers')->get(['id', 'user_id']);
        foreach ($sellers as $seller){
            $skills_ids = DB::table('seller_skills')->where('seller_id', $seller->id)->pluck('skill_id');
            $skills_names_array = DB::table('skills')->whereIn('id', $skills_ids)->pluck('title')->all();
            $skills_name = implode(',', $skills_names_array);
            $seller_info = DB::table('persons')->where('id', $seller->user_id)->get(['name', 'email'])->first();
            $orders = sizeof(Order::where('seller_id', $seller->id)->get()->all());
            $sellers_data[$count] = [
                'id' => $seller->id,
                'name' => $seller_info->name,
                'email' => $seller_info->email,
                'skills' => $skills_name,
                'projects' => $orders
            ];
            $count++;
        }
        $notifications = Notification::where('receiver', 'admin')->get()->all();
        return view('admin.developers')
            ->with('sellers_data', $sellers_data)
            ->with('notifications', array_reverse($notifications))
            ->with('user_name', 'admin')
            ->with('user_type', 'admin')
            ->with('check', 'developers')
            ->with('user_id', 1)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");
        ;
    }
    public function developerDetails($id){
        $orders_data[] = null;
        $seller_id = DB::table('sellers')->where('id', $id)->get('user_id')->all();
//        dd($seller_id[0]->user_id);
        $skills_ids = DB::table('seller_skills')->where('seller_id', $id)->pluck('skill_id');
        $skills_names_array = DB::table('skills')->whereIn('id', $skills_ids)->pluck('title')->all();
        $skills_name = implode(',', $skills_names_array);
        $seller_info = DB::table('persons')->where('id', $seller_id[0]->user_id)->get(['name', 'email'])->first();
        $orders = Order::where('seller_id', $id)->get()->all();
        $sellers_data = [
            'id' => $id,
            'name' => $seller_info->name,
            'email' => $seller_info->email,
            'skills' => $skills_name,
            'projects' => sizeof($orders)
        ];
        $count = 0;
        $total_earnings = 0;
        $pending_payment = 0;
        foreach ($orders as $order) {
            $buyer_id = DB::table('buyers')
                ->where('id', $order->buyer_id)
                ->pluck('user_id')->all();
            $orders_data[$count] = [
                'order_id' => $order->id,
                'title' => $order->title,
                'project_type' => implode(',', DB::table('skills')
                    ->whereIn('id', explode(',', $order->project_type))
                    ->pluck('title')->all()),
                'budget' => $order->budget,
                'status' => $order->status,
//            'description' => $order->description,
//            'remarks' => $order->remarks,
                'buyer_name' => DB::table('persons')
                    ->where('id', $buyer_id[0])
                    ->pluck('name')->all(),
            ];
            if($order->status == 'accepted'){
                $total_earnings = $total_earnings + $order->budget;
            }
            else{
                $pending_payment = $pending_payment + $order->budget;
            }
            $count++;
        }

        $notifications = Notification::where('receiver', 'admin')->get()->all();
        return view('admin.developersDetails')
            ->with('sellers_data', $sellers_data)
            ->with('notifications', array_reverse($notifications))
            ->with('user_name', 'admin')
            ->with('user_type', 'admin')
            ->with('orders_data', $orders_data)
            ->with('total_earnings', $total_earnings)
            ->with('pending_payment', $pending_payment)
            ->with('check', 'developers')
            ->with('user_id', 1)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");

    }

}
