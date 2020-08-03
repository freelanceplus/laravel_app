<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Notification;
use App\Order;
use App\Person;
use App\Seller;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use function GuzzleHttp\Promise\all;


class SellerProjectsController extends Controller
{
    public function newRequests(){
        if(session('seller') == null){;
            return redirect('seller/login');
        }
        $seller_id = Seller::where('user_id', session('seller')->getPerson()->id)->pluck('id')->all();
        $orders_data[] = null;
        $count = 0;
        $orders = Order::where('status', 'assignToSeller')->where('seller_id', $seller_id[0])->get();
        if(sizeof($orders) > 0) {
            foreach ($orders as $order) {
                $buyer_id = DB::table('buyers')
                    ->where('id', $order->buyer_id)
                    ->pluck('user_id')->all();
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
        $seller_info = Person::where('id', session('seller')->getPerson()->id)->get(['profile_pic'])->all();
        $notifications = Notification::where('receiver', 'seller')->where('receiver_id', $seller_id)->get()->all();
        return view('seller.newRequests')
            ->with('orders_data', $orders_data)
            ->with('user_type', 'seller')
            ->with('notifications', $notifications)
            ->with('user_name', session('seller')->getPerson()->name)
            ->with('user_picture', $seller_info[0]->profile_pic)
            ->with('user_id', $seller_id[0])
            ->with('check', 'newRequests');
    }

    public function sellerAcceptProject($order_id){
//        dd($order_id);
        Order::where('id', $order_id)
            ->update([
                'status' => "OnWorking",
            ]);
        $order_name = Order::where('id', $order_id)->get('title')->all();
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ .'./FirebaseKey.json');
//dd((int)$order_id);
        $database = $firebase->createDatabase();
//        $ref = $database->getReference('notification')->getKey();
        $ref = $database->getReference('notification')->orderByChild("order_id")->equalTo($order_id)->getValue();
        $array = array_values($ref);
//        dd($array[0]);
        $update_ref = 'notification/' . $array[0]['key'];
        $updates = [
            "key" => $array[0]['key'],
            "message" => 'working started on project '.$order_name[0]->title,
            "order_id" => $order_id,
            "receiver" => 'admin',
            "receiver_id" => "1"
        ];
        $set = $database->getReference($update_ref)->update($updates);
//        Notification::where('order_id', $order_id)->where('receiver', 'seller')
//        ->update([
//            'receiver' => 'admin',
//            'receiver_id' => 1,
//            'order_id' => $order_id,
//            'message' => 'working started on project '.$order_name[0]->title,
//        ]);
        return redirect()->route('sellerNewRequests');
    }

    public function sellerRejectProject($order_id){
        Order::where('id', $order_id)
            ->update([
                'status' => "requested",
                'seller_id' => null,
            ]);
        $order_name = Order::where('id', $order_id)->get('title')->all();
//        Notification::where('order_id', $order_id)->where('receiver', 'seller')
//            ->update([
//                'receiver' => 'admin',
//                'receiver_id' => 1,
//                'order_id' => $order_id,
//                'message' => 'project '.$order_name[0]->title.' is rejected',
//            ]);
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ .'./FirebaseKey.json');
//dd((int)$order_id);
        $database = $firebase->createDatabase();
//        $ref = $database->getReference('notification')->getKey();
        $ref = $database->getReference('notification')->orderByChild("order_id")->equalTo($order_id)->getValue();
        $array = array_values($ref);
//        dd($array[0]);
        $update_ref = 'notification/' . $array[0]['key'];
        $updates = [
            "key" => $array[0]['key'],
            "message" => 'project '.$order_name[0]->title.' is rejected',
            "order_id" => $order_id,
            "receiver" => 'admin',
            "receiver_id" => "1"
        ];
        $set = $database->getReference($update_ref)->update($updates);
        return redirect()->route('sellerNewRequests');
    }

    public function onGoingProjects(){
        if(session('seller') == null){;
            return redirect('seller/login');
        }
        $seller_id = Seller::where('user_id', session('seller')->getPerson()->id)->pluck('id')->all();
        $orders_data[] = null;
        $count = 0;
        $orders = Order::where('status', 'OnWorking')->where('seller_id', $seller_id[0])->get();
        $now = new DateTime(null, new DateTimeZone('Asia/Karachi'));
        $today_date = $now->format('Y-m-d');
        if(sizeof($orders) > 0) {
            foreach ($orders as $order) {
                $buyer_id = DB::table('buyers')
                    ->where('id', $order->buyer_id)
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
                    'buyer_id' => $order->buyer_id,
                    'buyer_name' => DB::table('persons')
                        ->where('id', $buyer_id)
                        ->pluck('name')->all()
                ];
                $count++;
            }
        }
        $notifications = Notification::where('receiver', 'seller')->where('receiver_id', $seller_id)->get()->all();
        $seller_info = Person::where('id', session('seller')->getPerson()->id)->get(['profile_pic'])->all();
        return view('seller.onGoingProjects')
            ->with('orders_data', $orders_data)
            ->with('user_type', 'seller')
            ->with('notifications', $notifications)
            ->with('user_name', session('seller')->getPerson()->name)
            ->with('user_picture', $seller_info[0]->profile_pic)
            ->with('user_id', $seller_id[0])
            ->with('check', 'inProgress');
    }

    public function sellerSubmitProject($order_id){

        $order_name = Order::where('id', $order_id)->pluck('title')->all();
        $seller_id = Seller::where('user_id', session('seller')->getPerson()->id)->pluck('id')->all();
        $notifications = Notification::where('receiver', 'seller')->where('receiver_id', $seller_id)->get() ->all();
        $seller_info = Person::where('id', session('seller')->getPerson()->id)->get(['profile_pic'])->all();
        return view('seller.sellerSubmitProject')
            ->with('order_name', $order_name[0])
            ->with('order_id', $order_id)
            ->with('notifications', $notifications)
            ->with('user_name', session('seller')->getPerson()->name)
            ->with('check', '')
            ->with('user_id', $seller_id[0])
            ->with('user_picture', $seller_info[0]->profile_pic)
            ->with('user_type', 'seller');
    }

    public function postSellerSubmitProject(Request $request, $order_id){
//        dd($request->firebase_images_url);
//        $files = "";
//        if($request->hasFile('file')){
//            foreach ($request->file as $file){
//                $filename = $file->getClientOriginalName();
//                $file->storeAs('public/upload', $filename);
//                $files = $files . "\\" . $filename . ",";
//            }
//        }

        $order_name = Order::where('id', $order_id)->pluck('title')->all();

        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ .'./FirebaseKey.json');
//dd((int)$order_id);
        $database = $firebase->createDatabase();
//        $ref = $database->getReference('notification')->getKey();
        $ref = $database->getReference('notification')->orderByChild("order_id")->equalTo($order_id)->getValue();
        $array = array_values($ref);
//        dd($array[0]);
        $update_ref = 'notification/' . $array[0]['key'];
        $updates = [
            "key" => $array[0]['key'],
            "message" => 'project '.$order_name[0].' is completed',
            "order_id" => $order_id,
            "receiver" => 'admin',
            "receiver_id" => "1"
        ];
        $set = $database->getReference($update_ref)->update($updates);

//        Notification::where('order_id', $order_id)->where('receiver', 'admin')
//            ->update([
//                'receiver' => 'admin',
//                'receiver_id' => 1,
//                'order_id' => $order_id,
//                'message' => 'project '.$order_name[0].' is completed',
//            ]);

        Order::where('id', $order_id)
            ->update([
                'seller_files' => $request->firebase_images_url,
                'remarks' => $request->remarks,
                'status' => 'completed',
            ]);

        return redirect()->route('onGoingProjects');
    }

    public function completedProjects(){
        if(session('seller') == null){;
            return redirect('seller/login');
        }
        $seller_id = Seller::where('user_id', session('seller')->getPerson()->id)->pluck('id')->all();
        $orders_data[] = null;
        $count = 0;
        $orders = Order::where('status', 'completed')->where('seller_id', $seller_id[0])->get();
        if(sizeof($orders) > 0) {
            foreach ($orders as $order) {
                $buyer_id = DB::table('buyers')
                    ->where('id', $order->buyer_id)
                    ->pluck('user_id')->all();
                $orders_data[$count] = [
                    'orderId' => $order->id,
                    'title' => $order->title,
                    'project_type' => implode(',', DB::table('skills')
                        ->whereIn('id', explode(',', $order->project_type))
                        ->pluck('title')->all()),
                    'budget' => $order->budget,
                    'buyer_name' => DB::table('persons')
                        ->where('id', $buyer_id[0])
                        ->pluck('name')->all()
                ];
                $count++;
            }
        }
        $notifications = Notification::where('receiver', 'seller')->where('receiver_id', $seller_id)->get()->all();
        $seller_info = Person::where('id', session('seller')->getPerson()->id)->get(['profile_pic'])->all();
        return view('seller.completedProjects')
            ->with('orders_data', $orders_data)
            ->with('user_type', 'seller')
            ->with('user_id', $seller_id[0])
            ->with('notifications', $notifications)
            ->with('user_name', session('seller')->getPerson()->name)
            ->with('user_picture', $seller_info[0]->profile_pic)
            ->with('check', 'completed');
    }

    public function getProjectDetails($order_id){
        if(session('seller') == null){;
            return redirect('seller/login');
        }
        $count = 0;
        $orders = Order::where('id', $order_id)->get()->all();
        foreach ($orders as $order) {
            $seller_id = DB::table('sellers')
                ->where('id', $order->seller_id)
                ->pluck('user_id')->all();
            $buyer_id = DB::table('buyers')
                ->where('id', $order->buyer_id)
                ->pluck('user_id')->all();
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
                    ->where('id', $buyer_id)
                    ->pluck('name')->all(),
                'seller_name' => DB::table('persons')
                    ->where('id', $seller_id)
                    ->pluck('name')->all()
            ];
            $count++;
        }
        $seller_id = Seller::where('user_id', session('seller')->getPerson()->id)->pluck('id')->all();
//dd($orders[0]->id);
//        dd($seller_id[0], $orders_data[0]['seller_name'][0], $orders_data[0]['buyer_name'][0], $orders[0]->buyer_id);

        $orders_1 = Order::where('id', $order_id)->get()->all();
        $seller_files_array = explode(',', $orders_1[0]->seller_files);
        $buyer_files_array = explode(',', $orders_1[0]->files);
        $notifications = Notification::where('receiver', 'seller')->where('receiver_id', $seller_id)->get()->all();

        $seller_info = Person::where('id', session('seller')->getPerson()->id)->get(['profile_pic'])->all();
        return view('seller.projectDetails')
            ->with('user_type', 'seller')
            ->with('orders_data', $orders_data[0])
            ->with('notifications', $notifications)
            ->with('order_id', $orders[0]->id)
            ->with('seller_id', $seller_id[0])
            ->with('seller_name', $orders_data[0]['seller_name'][0])
            ->with('buyer_id', $orders[0]->buyer_id)
            ->with('buyer_name', $orders_data[0]['buyer_name'][0])
            ->with('user_name', session('seller')->getPerson()->name)
            ->with('check', '')
            ->with('user_id', $seller_id[0])
            ->with('user_picture', $seller_info[0]->profile_pic)
            ->with('buyer_files_array', $buyer_files_array)
            ->with('seller_files_array', $seller_files_array);
    }

    public function downloadBuyerFiles($order_id)
    {
//        dd($order_id, "buyer");
        $orders = Order::where('id', $order_id)->get()->all();
        $files_array = explode(',', $orders[0]->files);
//        dd($files_array);
        foreach ($files_array as $file){
//            $download= storage_path("app\public\upload".$file);
            return response()->download($file);
        }
    }

    public function downloadSellerFiles($order_id)
    {
        $orders = Order::where('id', $order_id)->get()->all();
        $files_array = explode(',', $orders[0]->seller_files);
        foreach ($files_array as $file){
            $download= storage_path("app\public\upload".$file);
            return response()->download($download);
        }
    }

    public function inRevisionProjects(){
        if(session('seller') == null){;
            return redirect('seller/login');
        }
        $seller_id = Seller::where('user_id', session('seller')->getPerson()->id)->pluck('id')->all();
        $orders_data[] = null;
        $count = 0;
        $orders = Order::where('status', 'revisionFromAdmin')
            ->orWhere('status', 'revisionFromBuyer')
            ->where('seller_id', $seller_id[0])->get();
        if(sizeof($orders) > 0) {
            foreach ($orders as $order) {
                $buyer_id = DB::table('buyers')
                    ->where('id', $order->buyer_id)
                    ->pluck('user_id')->all();
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
        $notifications = Notification::where('receiver', 'seller')->where('receiver_id', $seller_id)->get()->all();
        $seller_info = Person::where('id', session('seller')->getPerson()->id)->get(['profile_pic'])->all();
        return view('seller.revisedProjects')
            ->with('orders_data', $orders_data)
            ->with('user_type', 'seller')
            ->with('user_id', $seller_id[0])
            ->with('notifications', $notifications)
            ->with('user_name', session('seller')->getPerson()->name)
            ->with('user_picture', $seller_info[0]->profile_pic)
            ->with('check', 'forRevision');
    }

    public function sellerAcceptForRevision($order_id){
        $order_name = Order::where('id', $order_id)->pluck('title')->all();
        Order::where('id', $order_id)
            ->update([
                'status' => 'onWorking',
            ]);
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ .'./FirebaseKey.json');
//dd((int)$order_id);
        $database = $firebase->createDatabase();
//        $ref = $database->getReference('notification')->getKey();
        $ref = $database->getReference('notification')->orderByChild("order_id")->equalTo($order_id)->getValue();
        $array = array_values($ref);
//        dd($array[0]);
        $update_ref = 'notification/' . $array[0]['key'];
        $updates = [
            "key" => $array[0]['key'],
            "message" => 'working started on project '.$order_name[0],
            "order_id" => $order_id,
            "receiver" => 'admin',
            "receiver_id" => "1"
        ];
        $set = $database->getReference($update_ref)->update($updates);
//        Notification::where('order_id', $order_id)->where('receiver', 'seller')
//            ->update([
//                'receiver' => 'admin',
//                'receiver_id' => 1,
//                'order_id' => $order_id,
//                'message' => 'working started on project '.$order_name[0],
//            ]);
        return redirect()->route('inRevisionProjects');
    }

    public function approvedProjects(){
        if(session('seller') == null){;
            return redirect('seller/login');
        }
        $seller_id = Seller::where('user_id', session('seller')->getPerson()->id)->pluck('id')->all();
        $orders_data[] = null;
        $count = 0;
//        dd($seller_id);
        $orders = Order::where('seller_id', $seller_id[0])->get();

        if(sizeof($orders) != 0){
            foreach ($orders as $in){
                if($in->status == "revisionFromBuyer" || $in->status == "approved" || $in->status == "accepted"){
                    $orders_after_check[$count] = $in;
                    $count++;
                }
            }
        }else{
            $orders_after_check = [];
        }
        $orders = $orders_after_check;
//dd(sizeof($orders));
        if(sizeof($orders) > 0) {
            foreach ($orders as $order) {
                $buyer_id = DB::table('buyers')
                    ->where('id', $order->buyer_id)
                    ->pluck('user_id')->all();
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
        $orders_data = array_values(array_filter($orders_data));
        if(sizeof($orders_data) == 0){
            $orders_data[0] = null;
        }
//dd($orders_data[0]);
        $notifications = Notification::where('receiver', 'seller')->where('receiver_id', $seller_id)->get()->all();
        $seller_info = Person::where('id', session('seller')->getPerson()->id)->get(['profile_pic'])->all();
        return view('seller.approveProjects')
            ->with('orders_data', $orders_data)
            ->with('user_type', 'seller')
            ->with('user_id', $seller_id[0])
            ->with('notifications', $notifications)
            ->with('user_name', session('seller')->getPerson()->name)
            ->with('user_picture', $seller_info[0]->profile_pic)
            ->with('check', 'approved');
    }

}
