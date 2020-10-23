<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Chat;
use App\ChatParent;
use App\Customer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;
use Twilio\TwiML\MessagingResponse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showDashboard()
    {
//        $thirtyDays = date("Y-m-d", strtotime("+32 days"));
//        $eventsList = Event::where('user_id', Auth::user()->id)->where('start', '<' ,$thirtyDays)->where('start', '>=' ,date("Y-m-d"))->get();
        return view('home');
    }
    public function chat(){
        $chats = ChatParent::all();
        return view('chat')->with(['chats' => $chats]);
    }

    public function chatDetails($id){
        return view('chat-details')->with(['chats' => Chat::where('id_chat', $id)->get(), 'parentId' => $id]);
    }

    public function sendSMS($parentId, Request $request){
        $number = ChatParent::where('id', $parentId)->first()['number'];
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($number,
            ['from' => $twilio_number, 'body' => $request->message] );

        $chat = new Chat();
        if (!empty(Session::get('isAdmin'))){
            $chat->sender = Admin::where('id', Session::get('id'))->first()['email'];
        }
        else {
            $chat->sender = User::where('id', Session::get('userId'))->first()['name'];
        }

        $chat->message = $request->message;
        $chat->id_chat = $parentId;
        $chat->save();
        return redirect()->back();
    }

    public function icomingSms(){

        $response = new MessagingResponse();
        $response->message("The Robots are coming! Head for the hills!");

        $chat = new Chat();
        $chat->sender = 'unknown';
        $chat->message = 'ok';
        $chat->id_chat = '1';
        $chat->save();
        print $response;
    }
}
