<?php

namespace App\Http\Controllers\buyer;

use App\Buyer;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Order;
use App\Person;
use App\Seller;
use App\Skill;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\File;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use function GuzzleHttp\Promise\all;

class BuyerProjectController extends Controller
{
    public function addProjectStep1(){
        if(session('buyer') == null){
            return redirect('buyer/login');
        }
        $skills = Skill::all();
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $notifications = Notification::where('receiver', 'buyer')->where('receiver_id', $buyer_id)->get()->all();
        $buyer_info = Person::where('id', session('buyer')->getPerson()->id)->get(['profile_pic'])->all();
        return view('buyer.addProjectStep1')
            ->with('skills', $skills)
            ->with('notifications', $notifications)
            ->with('user_type', 'buyer')
            ->with('user_name', session('buyer')->getPerson()->name)
            ->with('user_picture', $buyer_info[0]->profile_pic)
            ->with('user_id', $buyer_id[0])
            ->with('check', '');
    }

    public function postProjectStep1(Request $request){

        $project_type = implode (",", $request->project_type);

        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();

        Order::create
        ([
            'project_type' => $project_type,
            'buyer_id' => $buyer_id[0],
        ]);

        return redirect('/buyer/addProject/step2');
    }

    public function addProjectStep2(){
        if(session('buyer') == null){
            return redirect('buyer/login');
        }
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $notifications = Notification::where('receiver', 'buyer')->where('receiver_id', $buyer_id)->get()->all();
        $buyer_info = Person::where('id', session('buyer')->getPerson()->id)->get(['profile_pic'])->all();

        return view('/buyer/addProjectStep2')
            ->with('notifications', $notifications)
            ->with('user_type', 'buyer')
            ->with('user_name', session('buyer')->getPerson()->name)
            ->with('user_picture', $buyer_info[0]->profile_pic)
            ->with('user_id', $buyer_id[0])
            ->with('check', '');
    }

    public function postProjectStep2(Request $request){

//        dd($request->firebase_images_url);
        $this->validate($request, [
            'project_title' => 'required',
            'deadline' => 'required',
            'budget' => 'required',
        ]);
//        $files = "";
//        if($request->hasFile('file')){
//            foreach ($request->file as $file){
//                $filename = $file->getClientOriginalName();
//                $file->storeAs('public/upload', $filename);
//                $files = $files . "\\" . $filename . ",";
//            }
//        }
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $order_id = Order::where('buyer_id', $buyer_id)
            ->where('budget', null)
            ->where('title', null)
            ->where('deadline', null)
            ->get([
                'id'
            ]);
//        dd($order_id[0]->id);
        $update_order = Order::where('buyer_id', $buyer_id)
            ->where('budget', null)
            ->where('title', null)
            ->where('deadline', null)
            ->update([
                'title' => $request->project_title,
                'deadline' => $request->deadline,
                'budget' => $request->budget,
                'description' => $request->description,
                'files' => $request->firebase_images_url,
                'status' => 'requested'
            ]);
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ .'./FirebaseKey.json');
        $database = $firebase->createDatabase();
        $ref = $database->getReference('notification');
        $key = $ref->push()->getKey();
        $ref->getChild($key)->set([
            'key' => $key,
            'receiver' => 'admin',
            'receiver_id' => "1",
            'order_id' => "".$order_id[0]->id,
            'message' => 'you received a new project request',
        ]);
//        Notification::create([
//            'receiver' => 'admin',
//            'receiver_id' => 1,
//            'order_id' => $order_id[0]->id,
//            'message' => 'you received a new project request',
//        ]);

        return redirect()->route('buyerDashboard');
    }

    public function newRequests(){
        if(session('buyer') == null){
            return redirect('buyer/login');
        }
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $orders_data[] = null;
        $count = 0;
        $orders = Order::where('status', 'requested')->where('buyer_id', $buyer_id[0])->get();
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
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $notifications = Notification::where('receiver', 'buyer')->where('receiver_id', $buyer_id)->get()->all();
        $buyer_info = Person::where('id', session('buyer')->getPerson()->id)->get(['profile_pic'])->all();
        return view('buyer.newRequests')->with('orders_data', $orders_data)
            ->with('user_type', 'buyer')
            ->with('notifications', $notifications)
            ->with('user_name', session('buyer')->getPerson()->name)
            ->with('user_id', $buyer_id)
            ->with('user_picture', $buyer_info[0]->profile_pic)
            ->with('user_id', $buyer_id[0])
            ->with('check', 'newRequests');
    }

    public function deleteProject($order_id){
        Order::where('id',$order_id)->delete();
        return redirect()->route('buyerNewRequests');
    }

    public function inProgress(){
        $orders_after_check = [];
        if(session('buyer') == null){
            return redirect('buyer/login');
        }
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $orders_data = [];
        $count = 0;
//        dd($buyer_id[0]);
//        $orders1 = Order::where('buyer_id', '4')->get();
//        dd($orders1);

        $orders = DB::table('orders')->where('buyer_id', $buyer_id[0])->get();
//        $orders_after_check = "";
        $count = 0;
//        dd($orders);
        if(sizeof($orders) != 0){
            foreach ($orders as $in){

                if($in->status == "OnWorking" || $in->status == "assignToSeller" || $in->status == "completed"
                    || $in->status == "revisionFromAdmin" || $in->status == "revisionFromBuyer"){

                    $orders_after_check[$count] = $in;
                    $count++;
                }
            }
        }else{
            $orders_after_check = [];
        }

        $orders = $orders_after_check;
//        dd($orders);

        $now = new DateTime(null, new DateTimeZone('Asia/Karachi'));
        $today_date = $now->format('Y-m-d');
        if(sizeof($orders) > 0) {
            foreach ($orders as $order) {
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
                    'seller_id' => $order->seller_id,
                    'seller_name' => DB::table('persons')
                        ->where('id', $seller_id)
                        ->pluck('name')->all()
                ];
                $count++;
            }
        }
        $orders_data = array_values($orders_data);
        if(sizeof($orders_data) == 0){
            $orders_data[0] = null;
        }
//        dd();
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $notifications = Notification::where('receiver', 'buyer')->where('receiver_id', $buyer_id)->get()->all();
        $buyer_info = Person::where('id', session('buyer')->getPerson()->id)->get(['profile_pic'])->all();
        return view('buyer.onGoingProjects')->with('orders_data', $orders_data)
            ->with('user_type', 'buyer')
            ->with('notifications', $notifications)
            ->with('user_name', session('buyer')->getPerson()->name)
            ->with('user_picture', $buyer_info[0]->profile_pic)
            ->with('user_id', $buyer_id[0])
            ->with('check', 'inProgress');
    }

    public function completedProjects(){
        if(session('buyer') == null){
            return redirect('buyer/login');
        }
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $orders_data[] = null;
        $count = 0;
        $orders = Order::where('status', 'approved')->where('buyer_id', $buyer_id[0])->get();
        if(sizeof($orders) > 0) {
            foreach ($orders as $order) {
                $seller_id = Seller::where('id', $order->seller_id)->pluck('user_id')->all();
                $orders_data[$count] = [
                    'orderId' => $order->id,
                    'title' => $order->title,
                    'project_type' => implode(',', DB::table('skills')
                        ->whereIn('id', explode(',', $order->project_type))
                        ->pluck('title')->all()),
                    'deadline' => $order->deadline,
                    'budget' => $order->budget,
                    'seller_name' => DB::table('persons')
                        ->where('id', $seller_id)
                        ->pluck('name')->all()
                ];
                $count++;
            }
        }
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $notifications = Notification::where('receiver', 'buyer')->where('receiver_id', $buyer_id)->get()->all();
        $buyer_info = Person::where('id', session('buyer')->getPerson()->id)->get(['profile_pic'])->all();
        return view('buyer.completedProjects')->with('orders_data', $orders_data)
            ->with('user_type', 'buyer')
            ->with('notifications', $notifications)
            ->with('user_name', session('buyer')->getPerson()->name)
            ->with('user_picture', $buyer_info[0]->profile_pic)
            ->with('user_id', $buyer_id[0])
            ->with('check', 'completed');
    }

    public function reviseProject($order_id){
        if(session('buyer') == null){
            return redirect('buyer/login');
        }
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $notifications = Notification::where('receiver', 'buyer')->where('receiver_id', $buyer_id)->get()->all();
        $order_details = Order::where('id', $order_id)->get(['title'])->all();
        $buyer_info = Person::where('id', session('buyer')->getPerson()->id)->get(['profile_pic'])->all();
        return view('buyer.sendForRevision')->with('order_details', $order_details[0])
            ->with('order_id', $order_id)
            ->with('user_type', 'buyer')
            ->with('notifications', $notifications)
            ->with('user_name', session('buyer')->getPerson()->name)
            ->with('user_picture', $buyer_info[0]->profile_pic)
            ->with('user_id', $buyer_id[0])
            ->with('check', '');
    }

    public function postReviseProject(Request $request, $order_id){
        Order::where('id', $order_id)
            ->update([
                'remarks' => $request->remarks,
                'status' => "revisionFromBuyer",
            ]);
        $order_name = Order::where('id', $order_id)->pluck('title')->all();


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
            "message" => 'you received project '. $order_name[0] .' for revision',
            "order_id" => $order_id,
            "receiver" => 'admin',
            "receiver_id" => "1"
        ];
        $set = $database->getReference($update_ref)->update($updates);

//        Notification::where('order_id', $order_id)->where('receiver', 'buyer')
//            ->update([
//                'receiver' => 'admin',
//                'receiver_id' => 1,
//                'message' => 'you received project '. $order_name[0] .' for revision',
//            ]);
        return redirect()->route('buyerCompletedProjects');
    }

    public function getProjectDetails($order_id){
        if(session('buyer') == null){
            return redirect('buyer/login');
        }
        $count = 0;
        $seller_id = "";
        $orders = Order::where('id', $order_id)->get()->all();
//        dd($orders);
        foreach ($orders as $order) {
            if($order->seller_id != null) {
                $seller_id = DB::table('sellers')
                    ->where('id', $order->seller_id)
                    ->pluck('user_id')->all();
            }
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
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();

        if(!isset($orders_data[0]['seller_name'][0])){
            $orders_data[0]['seller_name'][0] = "";
        }

        $orders_1 = Order::where('id', $order_id)->get()->all();
        $seller_files_array = explode(',', $orders_1[0]->seller_files);
        $buyer_files_array = explode(',', $orders_1[0]->files);
//        dd($orders[0]);
//        foreach ($files_array as $file){
//            $download= storage_path("app\public\upload".$file);
//            return response()->download($download);
//        }
        $buyer_info = Person::where('id', session('buyer')->getPerson()->id)->get(['profile_pic'])->all();
        $notifications = Notification::where('receiver', 'buyer')->where('receiver_id', $buyer_id)->get()->all();
        return view('buyer.projectDetails')
            ->with('orders_data', $orders_data[0])
            ->with('notifications', $notifications)
            ->with('user_type', 'buyer')
            ->with('order_id', $orders[0]->id)
            ->with('buyer_id', $buyer_id[0])
            ->with('buyer_name', $orders_data[0]['buyer_name'][0])
            ->with('seller_id', $orders[0]->seller_id)
            ->with('seller_name', $orders_data[0]['seller_name'][0])
            ->with('user_name', session('buyer')->getPerson()->name)
            ->with('check', '')
            ->with('user_id', $buyer_id[0])
            ->with('user_picture', $buyer_info[0]->profile_pic)
            ->with('buyer_files_array', $buyer_files_array)
            ->with('seller_files_array', $seller_files_array);
    }

//    public function downloadBuyerFiles($order_id)
//    {
//        dd("bueyr");
//        $orders = Order::where('id', $order_id)->get()->all();
//        $files_array = explode(',', $orders[0]->files);
//        dd($files_array);
////        foreach ($files_array as $file){
////            $download= storage_path("app\public\upload".$file);
////            return response()->download($download);
////        }
//
//    }
//
//    public function downloadSellerFiles($order_id)
//    {
//        dd($order_id);
//        $orders = Order::where('id', $order_id)->get()->all();
//        $files_array = explode(',', $orders[0]->seller_files);
////        foreach ($files_array as $file){
////            $download= storage_path("app\public\upload".$file);
////            return response()->download($download);
////        }
//    }

    public function approveProject($order_id){
        Order::where('id', $order_id)
            ->update([
                'status' => "accepted",
            ]);
        $order_name = Order::where('id', $order_id)->pluck('title')->all();
//        Notification::where('order_id', $order_id)->where('receiver', 'buyer')
//        ->update([
//            'receiver' => 'admin',
//            'receiver_id' => 1,
//            'message' => 'project '. $order_name[0] .' is accepted',
//        ]);

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
            "message" => "project ". $order_name[0] ." is accepted",
            "order_id" => $order_id,
            "receiver" => 'admin',
            "receiver_id" => "1"
        ];
        $set = $database->getReference($update_ref)->update($updates);

        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $update_ref = 'notification/' . $array[1]['key'];
        $updates = [
            "key" => $array[1]['key'],
            "message" => "project ". $order_name[0] ." is completed",
            "order_id" => $order_id,
            "receiver" => 'buyer',
            "receiver_id" => $buyer_id[0]
        ];
        $set = $database->getReference($update_ref)->update($updates);

        return redirect()->route('buyerCompletedProjects');
    }

    public function approvedProjects(){
        if(session('buyer') == null){
            return redirect('buyer/login');
        }
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $orders_data[] = null;
        $count = 0;
        $orders = Order::where('status', 'accepted')->where('buyer_id', $buyer_id)->get();
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
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $notifications = Notification::where('receiver', 'buyer')->where('receiver_id', $buyer_id)->get()->all();
        $buyer_info = Person::where('id', session('buyer')->getPerson()->id)->get(['profile_pic'])->all();
        return view('buyer.approvedProjects')
            ->with('orders_data', $orders_data)
            ->with('user_type', 'buyer')
            ->with('notifications', $notifications)
            ->with('user_name', session('buyer')->getPerson()->name)
            ->with('user_picture', $buyer_info[0]->profile_pic)
            ->with('user_id', $buyer_id[0])
            ->with('check', 'approved');
    }

    public function editProject($order_id){
        if(session('buyer') == null){
            return redirect('buyer/login');
        }
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $notifications = Notification::where('receiver', 'buyer')->where('receiver_id', $buyer_id)->get()->all();
        $buyer_info = Person::where('id', session('buyer')->getPerson()->id)->get(['profile_pic'])->all();
        $order_details = Order::where('id', $order_id)->get();
//        dd($order_details[0]->id);

        return view('/buyer/editProject')
            ->with('notifications', $notifications)
            ->with('order_details', $order_details)
            ->with('user_type', 'buyer')
            ->with('user_name', session('buyer')->getPerson()->name)
            ->with('user_picture', $buyer_info[0]->profile_pic)
            ->with('user_id', $buyer_id[0])
            ->with('check', '');
    }

    public function postEditProject(Request $request){
//dd($request->order_id);
        $this->validate($request, [
            'project_title' => 'required',
            'deadline' => 'required',
            'budget' => 'required',
        ]);
        $buyer_id = Buyer::where('user_id', session('buyer')->getPerson()->id)->pluck('id')->all();
        $update_order = Order::where('buyer_id', $buyer_id)
            ->where('id', $request->order_id)
            ->update([
                'title' => $request->project_title,
                'deadline' => $request->deadline,
                'budget' => $request->budget,
                'description' => $request->description,
                'files' => $request->firebase_images_url,
            ]);
        return redirect()->back();
    }

}

