<?php

namespace App\Http\Controllers\admin;

use App\Buyer;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Order;
use App\Seller;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use function GuzzleHttp\Promise\all;

class AdminProjectsContoller extends Controller
{
    public function newRequests(){

        $orders_data[] = null;
        $count = 0;
        $orders = Order::where('status', 'requested')->get();

        if(sizeof($orders) > 0) {
            foreach ($orders as $order) {
//dd(session('buyer')->getPerson()->id);
                $buyer_id = Buyer::where('id', $order->buyer_id)->pluck('user_id')->all();

                $orders_data[$count] = [
                    'orderId' => $order->id,
                    'title' => $order->title,
                    'project_type' => implode(',', DB::table('skills')
                        ->whereIn('id', explode(',', $order->project_type))
                        ->pluck('title')->all()),
                    'deadline' => $order->deadline,
                    'budget' => $order->budget,
                    'buyer_name' => DB::table('persons')
                        ->where('id', $buyer_id)
                        ->pluck('name')->all()
                ];
                $count++;
            }
        }
        $notifications = Notification::where('receiver', 'admin')->get()->all();
        return view('admin.newRequests')->with('orders_data', $orders_data)->with('user_type', 'admin')
            ->with('notifications', array_reverse($notifications))
            ->with('user_name', 'admin')
            ->with('check', 'newRequests')
            ->with('user_id', 1)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");

    }

    public function assignProject($id){

        $sellers_data = [];
        $count = 0;
        $order_details = Order::where('id', $id)->get(['title', 'budget', 'deadline', 'project_type'])->all();
//        dd($order_details[0]->project_type);
        $project_type = $order_details[0]->project_type;

        $sellers = DB::table('seller_skills')
            ->where('skill_id', $project_type)
            ->join('sellers', 'seller_skills.seller_id', '=', 'sellers.id')
            ->select('sellers.*')
            ->get();

//        $sellers = DB::table('sellers')->whereIn('id', (array)$sellers_ids_2)->get(['id', 'user_id']);
//        dd($sellers);
        foreach ($sellers as $seller){
            $skills_ids = DB::table('seller_skills')
                ->where('seller_id', $seller->id)
//                ->where('skill_id', $project_type)
                ->pluck('skill_id');
            $skills_names_array = DB::table('skills')->whereIn('id', $skills_ids)->pluck('title')->all();
            $skills_name = implode(',', $skills_names_array);
            $seller_info = DB::table('persons')->where('id', $seller->user_id)->get(['name', 'email'])->first();
            $sellers_data[$count] = [
                'id' => $seller->id,
                'name' => $seller_info->name,
                'email' => $seller_info->email,
                'skills' => $skills_name
            ];
            $count++;
        }
        $notifications = Notification::where('receiver', 'admin')->get()->all();
        return view('admin.assignProject')->with('order_details', $order_details[0])
            ->with('order_id', $id)
            ->with('sellers_data', $sellers_data)
            ->with('notifications', array_reverse($notifications))
            ->with('user_name', 'admin')
            ->with('user_type', 'admin')
            ->with('check', 'newRequests')
            ->with('user_id', 1)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");

    }

    public function reviseProjectDetails($order_id, $seller_id){
        $order_details = Order::where('id', $order_id)->get(['title', 'budget', 'deadline'])->all();

        $user_id = DB::table('sellers')->where('id', $seller_id)->get('user_id')->first();
        $seller_name = DB::table('persons')->where('id', $user_id->user_id)->get('name')->first();
        session(['order_id' => ""]);
        session(['seller_id' => ""]);
        session(['order_id' => $order_id]);
        session(['seller_id' => $seller_id]);
        $notifications = Notification::where('receiver', 'admin')->get()->all();
        return view('admin.reviseProjectDetails')
            ->with('seller_name', $seller_name->name)
            ->with('order_details', $order_details[0])
            ->with('notifications', array_reverse($notifications))
            ->with('user_name', 'admin')
            ->with('check', 'forRevision')
            ->with('user_type', 'admin')
            ->with('user_id', 1)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");

    }

    public function assignProjectToSeller(Request $request){
//        dd(__DIR__ .'\FirebaseKey.json');
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ .'./FirebaseKey.json');

        $database = $firebase->createDatabase();
        $ref = $database->getReference('notification')->orderByChild("order_id")->equalTo(session('order_id'))->getValue();
        $array = array_values($ref);
        $update_ref = 'notification/' . $array[0]['key'];
        $updates = [
            "key" => $array[0]['key'],
            "message" => "you received a new project request",
            "order_id" => session('order_id'),
            "receiver" => 'seller',
            "receiver_id" => "".session('seller_id')
        ];
        $set = $database->getReference($update_ref)->update($updates);
//        Notification::where('order_id', session('order_id'))
//            ->where('receiver', 'admin')
//            ->update([
//                'receiver' => 'seller',
//                'receiver_id' => session('seller_id'),
//                'message' => 'you received a new project request',
//            ]);

        $buyer_id = Order::where('id', session('order_id'))->pluck('buyer_id')->all();
        $order_name = Order::where('id', session('order_id'))->get('title')->all();
//        Notification::create([
//            'receiver' => 'buyer',
//            'receiver_id' => $buyer_id[0],
//            'order_id' => session('order_id'),
//            'message' => 'working is started on your project '.$order_name[0]->title,
//        ]);

        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ .'./FirebaseKey.json');

        $database = $firebase->createDatabase();
        $ref = $database->getReference('notification');
        $key = $ref->push()->getKey();

        $ref->getChild($key)->set([
            'key' => $key,
            'receiver' => 'buyer',
            'receiver_id' => $buyer_id[0],
            'order_id' => session('order_id'),
            'message' => 'working is started on your project '.$order_name[0]->title,
        ]);

        Order::where('id', session('order_id'))
            ->update([
                'seller_id' => session('seller_id'),
                'deadline' => $request->deadline,
                'budget' => $request->budget,
                'status' => "assignToSeller",
            ]);
        session(['order_id' => ""]);
        session(['seller_id' => ""]);
        return redirect()->route('newRequests');
    }

    public function getProjectDetails($order_id){

        $count = 0;
        $orders = Order::where('id', $order_id)->get()->all();

        foreach ($orders as $order) {
            $seller_id = DB::table('sellers')
                ->where('id', $order->seller_id)
                ->pluck('user_id')->all();
            $buyer_id = DB::table('buyers')
                ->where('id', $order->buyer_id)
                ->pluck('user_id')->all();
            if(!$seller_id){
                $orders_data[$count] = [
                    'order_id' => $order->id,
                    'title' => $order->title,
                    'project_type' => implode(',', DB::table('skills')
                        ->whereIn('id', explode(',', $order->project_type))
                        ->pluck('title')->all()),
                    'deadline' => $order->deadline,
                    'budget' => $order->budget,
                    'description' => $order->description,
                    'remarks' => $order->remarks,
                    'buyer_name' => DB::table('persons')
                        ->where('id', $buyer_id[0])
                        ->pluck('name')->all(),
                    'seller_name' => [""]
                ];
            }
            elseif ($seller_id) {
                $orders_data[$count] = [
                    'order_id' => $order->id,
                    'title' => $order->title,
                    'project_type' => implode(',', DB::table('skills')
                        ->whereIn('id', explode(',', $order->project_type))
                        ->pluck('title')->all()),
                    'deadline' => $order->deadline,
                    'budget' => $order->budget,
                    'description' => $order->description,
                    'remarks' => $order->remarks,
                    'buyer_name' => DB::table('persons')
                        ->where('id', $buyer_id[0])
                        ->pluck('name')->all(),
                    'seller_name' => DB::table('persons')
                        ->where('id', $seller_id[0])
                        ->pluck('name')->all()
                ];
            }
            $count++;
        }

        $orders_1 = Order::where('id', $order_id)->get()->all();
        $seller_files_array = explode(',', $orders_1[0]->seller_files);
        $buyer_files_array = explode(',', $orders_1[0]->files);

        $notifications = Notification::where('receiver', 'admin')->get()->all();
        return view('admin.projectDetails')
            ->with('orders_data', $orders_data[0])
            ->with('notifications', array_reverse($notifications))
            ->with('user_name', 'admin')
            ->with('user_type', 'admin')
            ->with('order_id', $orders_data[0]['order_id'])
            ->with('seller_id', '1')
            ->with('seller_name', 'admin')
            ->with('buyer_id', $buyer_id[0])
            ->with('buyer_name', $orders_data[0]['buyer_name'][0])
            ->with('check', '')
            ->with('user_id', 1)
            ->with('buyer_files_array', $buyer_files_array)
            ->with('seller_files_array', $seller_files_array)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");

    }

    public function onGoingProjects(){
        $orders_data[] = null;
        $count = 0;
        $orders = Order::where('status', 'OnWorking')->orWhere('status', 'revisionFromAdmin')->get()->all();
        $now = new DateTime(null, new DateTimeZone('Asia/Karachi'));
        $today_date = $now->format('Y-m-d');

        if(sizeof($orders) > 0) {

            foreach ($orders as $order) {
                $buyer_id = DB::table('buyers')
                    ->where('id', $order->buyer_id)
                    ->pluck('user_id')->all();
                $seller_id = DB::table('sellers')
                    ->where('id', $order->seller_id)
                    ->pluck('user_id')->all();
                $deadline=date('Y-m-d', strtotime($order->deadline));
                $date_difference = strtotime($deadline) - strtotime($today_date);
                $remaining_days =  round( $date_difference / (60 * 60 * 24) );
                $orders_data[$count] = [
                    'orderId' => $order->id,
                    'title' => $order->title,
                    'project_type' => implode(',', DB::table('skills')
                        ->whereIn('id', explode(',', $order->project_type))
                        ->pluck('title')->all()),
                    'remaining_days' => $remaining_days,
                    'budget' => $order->budget,
                    'buyer_name' => DB::table('persons')
                        ->where('id', $buyer_id)
                        ->pluck('name')->all(),
                    'seller_name' => DB::table('persons')
                        ->where('id', $seller_id)
                        ->pluck('name')->all()
                ];
                $count++;
            }
        }
        $notifications = Notification::where('receiver', 'admin')->get()->all();
        return view('admin.onGoingProjects')->with('orders_data', $orders_data)->with('user_type', 'admin')
            ->with('notifications', array_reverse($notifications))
            ->with('user_name', 'admin')
            ->with('check', 'inProgress')
            ->with('user_id', 1)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");

    }

    public function completedProjectsAdmin(){
        $orders_data[] = null;
        $count = 0;
        $orders = Order::where('status', 'completed')->get();

        if(sizeof($orders) > 0) {
            foreach ($orders as $order) {
                $buyer_id = Buyer::where('id', $order->buyer_id)->pluck('user_id')->all();
                $orders_data[$count] = [
                    'orderId' => $order->id,
                    'title' => $order->title,
                    'project_type' => implode(',', DB::table('skills')
                        ->whereIn('id', explode(',', $order->project_type))
                        ->pluck('title')->all()),
                    'deadline' => $order->deadline,
                    'budget' => $order->budget,
                    'buyer_name' => DB::table('persons')
                        ->where('id', $buyer_id)
                        ->pluck('name')->all()
                ];
                $count++;
            }
        }
        $notifications = Notification::where('receiver', 'admin')->get()->all();
        return view('admin.completedProjects')->with('orders_data', $orders_data)->with('user_type', 'admin')
            ->with('notifications', array_reverse($notifications))
            ->with('user_name', 'admin')
            ->with('check', 'completed')
            ->with('user_id', 1)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");

    }

    public function approveProject($order_id){
        Order::where('id', $order_id)
            ->update([
                'status' => "approved",
            ]);
        $order_name = Order::where('id', $order_id)->get(['title', 'buyer_id'])->all();
//        Notification::where('order_id', $order_id)->where('receiver', 'admin')
//            ->update([
//                'receiver' => 'buyer',
//                'receiver_id' => $order_name[0]->buyer_id,
//                'order_id' => $order_id,
//                'message' => 'project '.$order_name[0]->title.' is completed',
//            ]);
//        dd($order_name[0]->title, $order_name[0]->buyer_id);
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ .'./FirebaseKey.json');

        $database = $firebase->createDatabase();
//        $ref = $database->getReference('notification')->getKey();
        $ref = $database->getReference('notification')->orderByChild("order_id")->equalTo($order_id)->getValue();
        $array = array_values($ref);
//        dd($array);
        $update_ref = 'notification/' . $array[0]['key'];
        $updates = [
            "key" => $array[0]['key'],
            "message" => 'project '.$order_name[0]->title.' is completed',
            "order_id" => $order_id,
            "receiver" => 'buyer',
            "receiver_id" => $order_name[0]->buyer_id
        ];
        $set = $database->getReference($update_ref)->update($updates);

        return redirect()->route('completedProjectsAdmin');
    }

    public function reviseProject($order_id){
        $order_details = Order::where('id', $order_id)->get(['title', 'seller_id',])->all();
        $user_id = DB::table('sellers')->where('id', $order_details[0]->seller_id)->get('user_id')->first();
        $seller_name = DB::table('persons')->where('id', $user_id->user_id)->get('name')->first();

        $notifications = Notification::where('receiver', 'admin')->get()->all();
        return view('admin.sendForRevision')->with('seller_name', $seller_name->name)->with('order_details', $order_details[0])
            ->with('order_id', $order_id)->with('notifications', array_reverse($notifications))
            ->with('user_name', 'admin')
            ->with('check', 'forRevision')
            ->with('user_type', 'admin')
            ->with('user_id', 1)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");

    }

    public function postReviseProject(Request $request, $order_id){
        Order::where('id', $order_id)
            ->update([
                'remarks' => $request->remarks,
                'status' => "revisionFromAdmin",
            ]);
        $seller_id = Order::where('id', $order_id)->pluck('seller_id')->all();
//        Notification::where('order_id', $order_id)
//            ->where('receiver', 'admin')
//            ->update([
//                'receiver' => 'seller',
//                'receiver_id' => $seller_id,
//                'message' => 'you received a project for revision',
//            ]);
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ .'./FirebaseKey.json');

        $database = $firebase->createDatabase();
//        $ref = $database->getReference('notification')->getKey();
        $ref = $database->getReference('notification')->orderByChild("order_id")->equalTo($order_id)->getValue();
        $array = array_values($ref);
//        dd($array);
        $update_ref = 'notification/' . $array[0]['key'];
        $updates = [
            "key" => $array[0]['key'],
            "message" => "you received a project for revision",
            "order_id" => $array[0]['order_id'],
            "receiver" => 'seller',
            "receiver_id" => "".$seller_id[0]
        ];
        $set = $database->getReference($update_ref)->update($updates);
            return redirect()->route('completedProjectsAdmin');
    }

    public function inRevisionProjects(){
        $orders_data[] = null;
        $count = 0;
        $orders = Order::where('status', 'revisionFromBuyer')->get();

        if(sizeof($orders) > 0) {
            foreach ($orders as $order) {
                $buyer_id = Buyer::where('id', $order->buyer_id)->pluck('user_id')->all();

                $orders_data[$count] = [
                    'orderId' => $order->id,
                    'title' => $order->title,
                    'project_type' => implode(',', DB::table('skills')
                        ->whereIn('id', explode(',', $order->project_type))
                        ->pluck('title')->all()),
                    'deadline' => $order->deadline,
                    'budget' => $order->budget,
                    'buyer_name' => DB::table('persons')
                        ->where('id', $buyer_id)
                        ->pluck('name')->all()
                ];
                $count++;
            }
        }
        $notifications = Notification::where('receiver', 'admin')->get()->all();
        return view('admin.revisedProjects')->with('orders_data', $orders_data)->with('user_type', 'admin')
            ->with('notifications', array_reverse($notifications))
            ->with('user_name', 'admin')
            ->with('check', 'forRevision')
            ->with('user_id', 1)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");

    }

    public function approvedProjectsAdmin(){
        $orders_data[] = null;
        $count = 0;
        $orders = Order::where('status', 'approved')->get();

        if(sizeof($orders) > 0) {
            foreach ($orders as $order) {
                $seller_id = Seller::where('id', $order->seller_id)->pluck('user_id')->all();
                $buyer_id = Buyer::where('id', $order->buyer_id)->pluck('user_id')->all();
                $orders_data[$count] = [
                    'orderId' => $order->id,
                    'title' => $order->title,
                    'project_type' => implode(',', DB::table('skills')
                        ->whereIn('id', explode(',', $order->project_type))
                        ->pluck('title')->all()),
                    'deadline' => $order->deadline,
                    'budget' => $order->budget,
                    'buyer_name' => DB::table('persons')
                        ->where('id', $buyer_id[0])
                        ->pluck('name')->all(),
                    'seller_name' => DB::table('persons')
                        ->where('id', $seller_id[0])
                        ->pluck('name')->all()
                ];
                $count++;
            }
        }
        $notifications = Notification::where('receiver', 'admin')->get()->all();
        return view('admin.approvedProjects')->with('orders_data', $orders_data)->with('user_type', 'admin')
            ->with('notifications', array_reverse($notifications))
            ->with('user_name', 'admin')
            ->with('check', 'approved')
            ->with('user_id', 1)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");

    }

    public function acceptedProjectsAdmin(){
        $orders_data[] = null;
        $count = 0;
        $orders = Order::where('status', 'accepted')->get();

        if(sizeof($orders) > 0) {
            foreach ($orders as $order) {

                $seller_id = Seller::where('id', $order->seller_id)->pluck('user_id')->all();
                $buyer_id = Buyer::where('id', $order->buyer_id)->pluck('user_id')->all();

                $orders_data[$count] = [
                    'orderId' => $order->id,
                    'title' => $order->title,
                    'project_type' => implode(',', DB::table('skills')
                        ->whereIn('id', explode(',', $order->project_type))
                        ->pluck('title')->all()),
                    'deadline' => $order->deadline,
                    'budget' => $order->budget,
                    'buyer_name' => DB::table('persons')
                        ->where('id', $buyer_id[0])
                        ->pluck('name')->all(),
                    'seller_name' => DB::table('persons')
                        ->where('id', $seller_id[0])
                        ->pluck('name')->all()
                ];
                $count++;
            }
        }
        $notifications = Notification::where('receiver', 'admin')->get()->all();
        return view('admin.acceptedProjects')->with('orders_data', $orders_data)
            ->with('notifications', array_reverse($notifications))
            ->with('user_name', 'admin')
            ->with('user_type', 'admin')
            ->with('check', 'accepted')
            ->with('user_id', 1)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");

    }

    public function acceptForRevision($order_id){
        Order::where('id', $order_id)
            ->update([
                'status' => 'revisionFromBuyer',
            ]);
        $seller_id = Order::where('id', $order_id)->pluck('seller_id')->all();
//        Notification::where('order_id', $order_id)
//            ->where('receiver', 'admin')
//            ->update([
//                'receiver' => 'seller',
//                'receiver_id' => $seller_id[0],
//                'message' => 'you received a project for revision',
//            ]);
        $order_name = Order::where('id', $order_id)->get(['title', 'buyer_id'])->all();

        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ .'./FirebaseKey.json');

        $database = $firebase->createDatabase();
//        $ref = $database->getReference('notification')->getKey();
        $ref = $database->getReference('notification')->orderByChild("order_id")->equalTo($order_id)->getValue();
        $array = array_values($ref);
//        dd($array);
        $update_ref = 'notification/' . $array[0]['key'];
        $updates = [
            "key" => $array[0]['key'],
            "message" => 'you received a project for revision',
            "order_id" => $order_id,
            "receiver" => 'seller',
            "receiver_id" => $seller_id[0]
        ];
        $set = $database->getReference($update_ref)->update($updates);

        return redirect()->route('inRevisionProjectsAdmin');
    }
    public function rejectProject($order_id){
        $order_details = Order::where('id', $order_id)->get(['buyer_id', 'title'])->all();
//        Notification::where('order_id', $order_id)->where('receiver', 'admin')->delete();
//        Notification::create
//        ([
//            'receiver' => 'buyer',
//            'receiver_id' => $order_details[0]->buyer_id,
//            'message' => 'you project named '. $order_details[0]->title .' is rejected',
//        ]);
        $order_name = Order::where('id', $order_id)->get(['title', 'buyer_id'])->all();
//dd($order_name);
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ .'./FirebaseKey.json');

        $database = $firebase->createDatabase();
//        $ref = $database->getReference('notification')->getKey();
        $ref = $database->getReference('notification')->orderByChild("order_id")->equalTo($order_id)->getValue();
        $array = array_values($ref);
//        dd($array);
        $update_ref = 'notification/' . $array[0]['key'];
//        dd($update_ref);
        $updates = [
            "key" => $array[0]['key'],
            "message" => 'project '.$order_name[0]->title.' is rejected',
            "order_id" => $order_id,
            "receiver" => 'buyer',
            "receiver_id" => $order_name[0]->buyer_id
        ];
        $set = $database->getReference($update_ref)->update($updates);
        Order::where('id', $order_id)->delete();
        return redirect()->route('newRequests');
    }
}
