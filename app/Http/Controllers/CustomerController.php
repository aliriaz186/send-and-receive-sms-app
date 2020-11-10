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

class CustomerController extends Controller
{
    public function getCustomerListView()
    {
        $customer = Customer::all();
        return view('customer')->with(['customer' => $customer]);
    }

    public function getAddCustomerView()
    {
        return view('add-customer');
    }

    public function saveCustomer(Request $request)
    {
        if($request->checker == 'default')
        {
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->number = $request->number;
            $result = $customer->save();
            if ($result == true) {
                return redirect('customer')->with('message', "Customer Saved Successfully");
            } else {
                return redirect()->back()->with('message', $result);
            }
        }else{
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_number = getenv("TWILIO_NUMBER");
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($request->number,
                ['from' => $twilio_number, 'body' => $request->messageTemplate] );

            $customer = new Customer();
            $customer->name = $request->name;
            $customer->number = $request->number;
            $result = $customer->save();

            $chatParent = new ChatParent();
            $chatParent->number = $request->number;
            $chatParent->save();

            $chat = new Chat();
            if (!empty(Session::get('isAdmin'))){
                $chat->sender = Admin::where('id', Session::get('id'))->first()['email'];
            }
            else {
                $chat->sender = User::where('id', Session::get('userId'))->first()['name'];
            }

            $chat->message = $request->messageTemplate;
            $chat->id_chat = $chatParent->id;
            $chat->save();
            if ($result == true) {
                return redirect('customer')->with('message', "Customer Saved Successfully");
            } else {
                return redirect()->back()->with('message', $result);
            }
        }
    }

    public function sendSmsToChecked(Request $request){
        try {
            if (!empty($request->custom_message)){
                $request->messageTemplate = $request->custom_message;
            }
            $checkedList = json_decode($request->finalCheckedArray, true);
            foreach ($checkedList as $item){
                $number = ChatParent::where('id', $item)->first()['number'];
                $account_sid = getenv("TWILIO_SID");
                $auth_token = getenv("TWILIO_AUTH_TOKEN");
                $twilio_number = getenv("TWILIO_NUMBER");
                $client = new Client($account_sid, $auth_token);
                $client->messages->create( $number, ['from' => $twilio_number, 'body' => $request->messageTemplate]);

                $chat = new Chat();
                if (!empty(Session::get('isAdmin'))){
                    $chat->sender = Admin::where('id', Session::get('id'))->first()['email'];
                }
                else {
                    $chat->sender = User::where('id', Session::get('userId'))->first()['name'];
                }
                $chat->message = $request->messageTemplate;
                $chat->id_chat = $item;
                $chat->save();
            }
            return json_encode(['status' => true, 'message' => "SMS Send successully"]);
        }catch (\Exception $exception){
            return json_encode(['status' => false, 'message' => "Server Error! Please try again", 'error' => $exception->getMessage()]);
        }




    }

    public function deleteCustomer($customerId)
    {
        Customer::where('id', $customerId)->delete();
        return redirect()->back();
    }

    public function editCustomer($staffId)
    {
        $customer = Customer::where('id', $staffId)->first();
        return view('edit-customer')->with(['customer' => $customer]);
    }

    public function saveEditedCustomer(Request $request)
    {
        $customer = Customer::where('id', $request->customerId)->first();
        $customer->name = $request->name;
        $customer->number = $request->number;
        $result = $customer->update();
        if ($result == true) {
            return redirect('customer')->with('message', "Customer updated Successfully");
        } else {
            return redirect()->back()->with('message', $result);
        }
    }
}
