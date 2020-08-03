<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use function GuzzleHttp\Promise\all;


class FirebaseController extends Controller
{
    public function index(){

        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ .'/FirebaseKey.json');

        $database = $firebase->createDatabase();
        $ref = $database->getReference('chat');
        $key = $ref->push()->getKey();

        $ref->getChild($key)->set([
           'test'=>'test'
        ]);
        return $key;
    }

    public function sendMessage(Request $request, $order_id, $buyer_id, $buyer_name, $seller_id, $seller_name, $sender){
//        return $request['input_message'];
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ .'/FirebaseKey.json');
        $database = $firebase->createDatabase();
        $ref = $database->getReference('chat');
        $key = $ref->push()->getKey();
        $ref->getChild($key)->set([
            'order_id'=>$order_id,
            'buyer_id'=>$buyer_id,
            'buyer_name'=>$buyer_name,
            'seller_id'=>$seller_id,
            'seller_name'=>$seller_name,
            'message'=> $request['input_message'],
            'sender'=>$sender,
        ]);
        return "saved";
    }

    public function getChat($order_id){

        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ .'/FirebaseKey.json');
        $database = $firebase->createDatabase();
//        $ref = $database->getReference('chat');

        $all_chat = [];

        $chats = $database->getReference('chat')
            ->orderByChild('order_id')
            ->equalTo("13")
            ->getValue();

        foreach ($chats as $chat){
            $all_chat = $chat;
        }

        return json_encode($all_chat);

    }

}
