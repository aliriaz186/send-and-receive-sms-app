<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Chat;
use App\ChatParent;
use App\Customer;
use App\Staff;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $totalChats = ChatParent::all()->count();
        $totalStaff = Staff::all()->count();
        $totalCustomers = Customer::all()->count();
        $totalMessages = Chat::all()->count();
        return view('home')->with(['totalMessages' => $totalMessages,'totalChats' => $totalChats,'totalStaff' => $totalStaff,'totalCustomers' => $totalCustomers]);
    }
    public function chat(){
        $chats = ChatParent::all();
        return view('chat')->with(['chats' => $chats]);
    }

    public function chatDetails($id){
        $chat = Chat::where('id_chat', $id)->get();
        foreach ($chat as $item)
        {
            if($item->status == 0)
            {
                $item->status = 1;
                $item->update();
            }
        }
        $chatMembers = Chat::where('id_chat', $id)->distinct()->get(['sender']);
        $customerNumber = ChatParent::where('id', $id)->first()['number'];
        $customerName = Customer::where('number', $customerNumber)->first()['name'];
        return view('chat-details')->with(['customerNumber' => $customerNumber,'customerName' => $customerName,'chatMembers' => $chatMembers, 'chats' => Chat::where('id_chat', $id)->get(), 'parentId' => $id]);
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
            $chat->sender = Staff::where('id', Session::get('id'))->first()['name'];
        }

        $chat->message = $request->message;
        $chat->id_chat = $parentId;
        $chat->save();
        return redirect()->back();
    }

    public function icomingSms(Request $request){
        try {
            $chatParentId = ChatParent::where('number', $request->From)->first()['id'];
            $chat = new Chat();
            $chat->sender = $request->From;
            $chat->message = $request->Body;
            $chat->id_chat = $chatParentId;
            $chat->status = 0;
            $chat->ping_status = 0;
            $chat->save();
            print "<Response></Response>";
        }catch (\Exception $exception){
            print "<Response></Response>";
        }

    }
}
