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

class CustomerController extends Controller
{
    public function getCustomerListView()
    {
//        $customerCount = Customer::all()->count();
        return view('customer');
    }


    public function getAll(Request $request)
    {
        $columns = array(
            0 => 'select',
            1 => 'id',
            2 => 'number',
            3 => 'name',
            4 => 'options',
        );
        $totalData = Customer::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        if (empty($request->input('search.value'))) {
            if ($request->type == "all"){
                $customers = Customer::offset($start)->limit($limit)->get();
            }elseif ($request->type == "messagesent" ){
                $customers = DB::table('customers')
                    ->whereExists( function ($query) use ($limit) {
                        $query->select(DB::raw(1))
                            ->from('chat_parents')
                            ->whereRaw('customers.number = chat_parents.number');
                    })
                    ->offset($start)->limit($limit)->get();

                $totalData =  DB::table('customers')
                    ->whereExists( function ($query) use ($limit) {
                        $query->select(DB::raw(1))
                            ->from('chat_parents')
                            ->whereRaw('customers.number = chat_parents.number');
                    })->count();
                $totalFiltered = $totalData;
            }elseif ($request->type == "messagenotsent" ){
                $customers = DB::table('customers')
                    ->whereNotExists( function ($query) use ($limit) {
                        $query->select(DB::raw(1))
                            ->from('chat_parents')
                            ->whereRaw('customers.number = chat_parents.number');
                    })
                    ->offset($start)->limit($limit)->get();

                $totalData =  DB::table('customers')
                    ->whereNotExists( function ($query) use ($limit) {
                        $query->select(DB::raw(1))
                            ->from('chat_parents')
                            ->whereRaw('customers.number = chat_parents.number');
                    })->count();
                $totalFiltered = $totalData;
            }

        } else {
            $search = $request->input('search.value');
            $customers = Customer::where('id', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%")->orWhere('number', 'LIKE', "%{$search}%")->offset($start)->limit($limit)->get();
            $totalFiltered = Customer::where('id', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%")->orWhere('number', 'LIKE', "%{$search}%")->count();
        }
        $data = array();
        if (!empty($customers)) {
            foreach ($customers as $key => $customer) {
                $appUrl = env('APP_URL');
                if ($key == 0) {
                    $chatCount = count($customers);
                    $nestedData['select'] = "<input type=\"checkbox\" name=\"chat$key\" id=\"chat$key\" class=\"$customer->id\" onclick=\"rowSelected()\"><input type=\"hidden\" id=\"chatCount\" value='$chatCount'>";
                }else{
                    $nestedData['select'] = "<input type=\"checkbox\" name=\"chat$key\" id=\"chat$key\" class=\"$customer->id\" onclick=\"rowSelected()\">";

                }
                $nestedData['id'] = $key + 1;
                $nestedData['number'] =  $customer->number;
                $nestedData['name'] =  $customer->name;
                $nestedData['options'] = '<a href="'.url("/edit-customer").'/'.$customer->id.'">
                                <button class="btn btn-secondary">Edit</button>
                            </a>
                            <a href="'.url("/delete-customer/").'/'.$customer->id.'">
                                <button class="btn btn-danger">Delete</button>
                            </a>';
//                if ($request->type == "all"){
//                    $data[] = $nestedData;
//                }elseif ($request->type == "messagesent" && \App\ChatParent::where('number', $customer->number)->exists()){
//                    $data[] = $nestedData;
//                }elseif ($request->type == "messagenotsent" && !\App\ChatParent::where('number', $customer->number)->exists()){
//                    $data[] = $nestedData;
//                }
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "currentDataCount" => count($data),
        );

        echo json_encode($json_data);
    }

    public function getAllChats(Request $request)
    {
        $columns = array(
            0 => 'select',
            1 => 'id',
            2 => 'name',
            3 => 'number',
            4 => 'Unread Messages',
            5 => 'Customer Replied',
            6 => 'options',
        );
        $totalData = ChatParent::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        if (empty($request->input('search.value'))) {

            if ($request->type == "all"){
                $chats = ChatParent::offset($start)->limit($limit)->get();
            }elseif ($request->type == "replied"){
                $chats = DB::table('chat_parents')
                    ->whereExists( function ($query) use ($limit) {
                        $query->select(DB::raw(1))
                            ->from('chats')
                            ->whereRaw('chat_parents.id = chats.id_chat')
                            ->whereRaw('chat_parents.number = chats.sender');
                    })
                    ->offset($start)->limit($limit)->get();

                $totalData =  DB::table('chat_parents')
                    ->whereExists( function ($query) use ($limit) {
                        $query->select(DB::raw(1))
                            ->from('chats')
                            ->whereRaw('chat_parents.id = chats.id_chat')
                            ->whereRaw('chat_parents.number = chats.sender');
                    })->count();
                $totalFiltered = $totalData;
            }elseif ($request->type == "notreplied"){
                $chats = DB::table('chat_parents')
                    ->whereNotExists( function ($query) use ($limit) {
                        $query->select(DB::raw(1))
                            ->from('chats')
                            ->whereRaw('chat_parents.id = chats.id_chat')
                            ->whereRaw('chat_parents.number = chats.sender');
                    })
                    ->offset($start)->limit($limit)->get();

                $totalData =  DB::table('chat_parents')
                    ->whereNotExists( function ($query) use ($limit) {
                        $query->select(DB::raw(1))
                            ->from('chats')
                            ->whereRaw('chat_parents.id = chats.id_chat')
                            ->whereRaw('chat_parents.number = chats.sender');
                    })->count();
                $totalFiltered = $totalData;
            }
        } else {
            $search = $request->input('search.value');
            $customers = Customer::where('name', 'LIKE', "%{$search}%")->get();
            $customerNumbers = [];
            foreach ($customers as $customer){
                array_push($customerNumbers, $customer->number);
            }
            $chats = ChatParent::where('id', 'LIKE', "%{$search}%")->orWhere('number', 'LIKE', "%{$search}%")->orWhereIn('number', $customerNumbers)->offset($start)->limit($limit)->get();
            $totalFiltered = ChatParent::where('id', 'LIKE', "%{$search}%")->orWhere('number', 'LIKE', "%{$search}%")->orWhereIn('number', $customerNumbers)->count();
        }
        $data = array();
        if (!empty($chats)) {
            foreach ($chats as $key => $chat) {
                if ($key == 0){
                    $chatCount = count($chats);
                    $nestedData['select'] = "<input type=\"checkbox\" name=\"chat$key\" id=\"chat$key\" class=\"$chat->id\" onclick=\"rowSelected()\"><input type=\"hidden\" id=\"chatCount\" value='$chatCount'>";

                }else{
                    $nestedData['select'] = "<input type=\"checkbox\" name=\"chat$key\" id=\"chat$key\" class=\"$chat->id\" onclick=\"rowSelected()\">";
                }
//                $appUrl = env('APP_URL');
//                $nestedData['select'] = "<input type=\"checkbox\" name=\"chat$key\" id=\"chat$key\" class=\"$chat->id\" onclick=\"rowSelected()\">";
                $nestedData['id'] = $key + 1;
                $nestedData['name'] = "";
                if (\App\Customer::where('number', $chat->number)->exists()){
                    $nestedData['name'] = \App\Customer::where('number', $chat->number)->first()['name'];
                }
                $nestedData['number'] =  $chat->number;
                $nestedData['Unread Messages'] =  \App\Chat::where('id_chat', $chat->id)->where('status', 0)->get()->count();
                if (\App\Chat::where('id_chat', $chat->id)->where('sender', $chat->number)->exists()){
                    $nestedData['Customer Replied'] = "<span class='text-success'>Customer Replied</span>";
                }else{
                    $nestedData['Customer Replied'] =  "<span class='text-danger'>Not Replied Yet</span>";
                }

                $nestedData['options'] = ' <a href="'.url("/chat-details").'/'.$chat->id.'">
                                <button class="btn btn-secondary">Open Chat</button>
                            </a>';
//                if ($request->type == "all"){
//                    $data[] = $nestedData;
//                }elseif ($request->type == "replied" && \App\Chat::where('id_chat', $chat->id)->where('sender', $chat->number)->exists()){
//                    $data[] = $nestedData;
//                }elseif ($request->type == "notreplied" && !\App\Chat::where('id_chat', $chat->id)->where('sender', $chat->number)->exists()){
//                    $data[] = $nestedData;
//                }
                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "currentDataCount" => count($data),
        );

        echo json_encode($json_data);
    }



    public function getAddCustomerView()
    {
        return view('add-customer');
    }

    public function saveCustomer(Request $request)
    {
        set_time_limit(360000);
        if(substr($request->number, 0, 2) != '+1')
        {
            if(substr($request->number, 0, 1) != '1')
            {
                $request->number = '+1'. $request->number;
            }else{
                $request->number = '+'. $request->number;
            }
        }

        if (Customer::where('number', $request->number)->exists()){
            return redirect()->back()->withErrors('Phone number already Exists');
        }
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
                $chat->sender = Staff::where('id', Session::get('id'))->first()['name'];
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
            set_time_limit(360000);
            if (!empty($request->custom_message)){
                $request->messageTemplate = $request->custom_message;
            }
            if (!empty($request->allSelected) && $request->allSelected == 'all'){
                $chatParents = ChatParent::all();
                foreach ($chatParents as $chatParent){
                    $number = $chatParent->number;
                    try {
                        $account_sid = getenv("TWILIO_SID");
                        $auth_token = getenv("TWILIO_AUTH_TOKEN");
                        $twilio_number = getenv("TWILIO_NUMBER");
                        $client = new Client($account_sid, $auth_token);
                        $client->messages->create( $number, ['from' => $twilio_number, 'body' => $request->messageTemplate]);

                    }catch (\Exception $exception){
//                        continue;
                    }

                    $chat = new Chat();
                    if (!empty(Session::get('isAdmin'))){
                        $chat->sender = Admin::where('id', Session::get('id'))->first()['email'];
                    }
                    else {
                        $chat->sender = Staff::where('id', Session::get('id'))->first()['name'];
                    }
                    $chat->message = $request->messageTemplate;
                    $chat->id_chat = $chatParent->id;
                    $chat->save();
                }
            }else{
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
                        $chat->sender = Staff::where('id', Session::get('id'))->first()['name'];
                    }
                    $chat->message = $request->messageTemplate;
                    $chat->id_chat = $item;
                    $chat->save();
                }
            }

            return json_encode(['status' => true, 'message' => "SMS Send successully"]);
        }catch (\Exception $exception){
            return json_encode(['status' => false, 'message' => "Server Error! Please try again", 'error' => $exception->getMessage()]);
        }




    }


      public function sendSmsToCheckedCustomer(Request $request){
        try {
            set_time_limit(360000);
            if (!empty($request->custom_message)){
                $request->messageTemplate = $request->custom_message;
            }
            $limit = 5;
            if (!empty($request->allSelected) && $request->allSelected == 'all'){
                if ($request->filterType == "all") {
                    $customers = Customer::all();
                } elseif ($request->type == "messagesent") {
                    $customers = DB::table('customers')
                        ->whereExists( function ($query) use ($limit) {
                            $query->select(DB::raw(1))
                                ->from('chat_parents')
                                ->whereRaw('customers.number = chat_parents.number');
                        })->get();
                } elseif ($request->type == "messagenotsent") {
                    $customers = DB::table('customers')
                        ->whereNotExists( function ($query) use ($limit) {
                            $query->select(DB::raw(1))
                                ->from('chat_parents')
                                ->whereRaw('customers.number = chat_parents.number');
                        })->get();
                }

                foreach ($customers as $customer){

                    $number = Customer::where('id', $customer->id)->first()['number'];
                    try {
                        $account_sid = getenv("TWILIO_SID");
                        $auth_token = getenv("TWILIO_AUTH_TOKEN");
                        $twilio_number = getenv("TWILIO_NUMBER");
                        $client = new Client($account_sid, $auth_token);
                        $client->messages->create( $number, ['from' => $twilio_number, 'body' => $request->messageTemplate]);

                    }catch (\Exception $exception){
//                        continue;
                    }

                    $chatParentId = 0;
                    if (!ChatParent::where('number', $number)->exists()){
                        $chatparent = new ChatParent();
                        $chatparent->number = $number;
                        $chatparent->save();
                        $chatParentId = $chatparent->id;
                    }else{
                        $chatParentId = ChatParent::where('number', $number)->first()['id'];
                    }

                    $chat = new Chat();
                    if (!empty(Session::get('isAdmin'))){
                        $chat->sender = Admin::where('id', Session::get('id'))->first()['email'];
                    }
                    else {
                        $chat->sender = Staff::where('id', Session::get('id'))->first()['name'];
                    }
                    $chat->message = $request->messageTemplate;
                    $chat->id_chat = $chatParentId;
                    $chat->save();
                }
            }else{
                $checkedList = json_decode($request->finalCheckedArray, true);
                foreach ($checkedList as $item){

                    $number = Customer::where('id', $item)->first()['number'];
                    try {
                        $account_sid = getenv("TWILIO_SID");
                        $auth_token = getenv("TWILIO_AUTH_TOKEN");
                        $twilio_number = getenv("TWILIO_NUMBER");
                        $client = new Client($account_sid, $auth_token);
                        $client->messages->create( $number, ['from' => $twilio_number, 'body' => $request->messageTemplate]);

                    }catch (\Exception $exception){
                        continue;
                    }
                    $chatParentId = 0;
                    if (!ChatParent::where('number', $number)->exists()){
                        $chatparent = new ChatParent();
                        $chatparent->number = $number;
                        $chatparent->save();
                        $chatParentId = $chatparent->id;
                    }else{
                        $chatParentId = ChatParent::where('number', $number)->first()['id'];
                    }

                    $chat = new Chat();
                    if (!empty(Session::get('isAdmin'))){
                        $chat->sender = Admin::where('id', Session::get('id'))->first()['email'];
                    }
                    else {
                        $chat->sender = Staff::where('id', Session::get('id'))->first()['name'];
                    }
                    $chat->message = $request->messageTemplate;
                    $chat->id_chat = $chatParentId;
                    $chat->save();
                }
            }
            return json_encode(['status' => true, 'message' => "SMS Send successully"]);
        }catch (\Exception $exception){
            return json_encode(['status' => false, 'message' => "Server Error! Please try again", 'error' => $exception->getMessage()]);
        }
    }

    public function deleteCheckedCustomer(Request $request){
        try {
            set_time_limit(360000);
            if (!empty($request->allSelected) && $request->allSelected == 'all'){
                $customers = Customer::all();
                foreach ($customers as $customer) {
                    $number = $customer->number;
                    Customer::where('id', $customer->id)->first()->delete();
                    if (ChatParent::where('number', $number)->exists()) {
                        ChatParent::where('number', $number)->first()->delete();
                    }
                }
            }else{
                $checkedList = json_decode($request->finalCheckedArray, true);
                foreach ($checkedList as $item) {
                    $number = Customer::where('id', $item)->first()['number'];
                    Customer::where('id', $item)->first()->delete();
                    if (ChatParent::where('number', $number)->exists()) {
                        ChatParent::where('number', $number)->first()->delete();
                    }
                }
            }

            return json_encode(['status' => true, 'message' => "SMS Send successully"]);
        }catch (\Exception $exception){
            return json_encode(['status' => false, 'message' => "Server Error! Please try again", 'error' => $exception->getMessage()]);
        }
    }

    public function deleteCheckedChats(Request $request)
    {
        try {
            set_time_limit(360000);
            if (!empty($request->allSelected) && $request->allSelected == 'all'){
                $checkedList = json_decode($request->finalCheckedArray, true);
                $chatParent = ChatParent::all();
                foreach ($chatParent as $chatP) {
                    $number = ChatParent::where('id', $chatP->id)->first()->delete();
                }
            }else{
                $checkedList = json_decode($request->finalCheckedArray, true);
                foreach ($checkedList as $item) {
                    $number = ChatParent::where('id', $item)->first()->delete();
                }
            }
            return json_encode(['status' => true, 'message' => "SMS Send successully"]);
        } catch (\Exception $exception) {
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
