<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Message;
use App\Notification;
use App\Person;
use App\Seller;
use Illuminate\Http\Request;

class BuyerChatsController extends Controller
{

//    public function _construct(){
//        $this->middleware('auth');
//    }

    public function index(){

        return view('chat');

    }

    public function fetchMessages(){
        $messages = Message::all();
        return $messages;
    }

    public function sendMessage(Request $request){
        $message = Message::create([
            'buyer_id' => 2,
            'seller_id' => 31,
            'sender' => 0,
            'message' => $request->message,
        ]);
        broadcast(new MessageSent($message))->toOthers();
        return ['status' => 'success'];
    }

    public function getChat(){
//        $messages = Message::where('buyer_id', 2)->where('seller_id', 31)->get()->all();
        $messages = Message::all();
//        $messages = [
//            'message' => 'a messae'
//        ];
        return $messages;
    }

//    public function getChat($sender, $seller_id, $buyer_id){
////        if($sender == 0){
////            $messages = Message::where('buyer_id', session('buyer'))->where('seller_id', $id)->get()->all();
//            $messages = Message::where('buyer_id', $buyer_id)->where('seller_id', $seller_id)->get()->all();
////        }
////        if($sender == 1){
////            $messages = Message::where('buyer_id', session('buyer'))->where('seller_id', $id)->get()->all();
//            $messages = Message::where('buyer_id', $buyer_id)->where('seller_id', $seller_id)->get()->all();
////        }
//        return $messages;
//    }

    public function sendChat(Request $request){
        $message = Message::create([
           'buyer_id' => 2,
           'seller_id' => 31,
           'sender' => 0,
           'message' => $request->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return [];
    }

//    public function sendMessages(Request $request){
//        dd($request);
//        return ['status' => 'success'];
//    }
}
