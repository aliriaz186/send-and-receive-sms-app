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
use Maatwebsite\Excel\Facades\Excel;
use services\CSVModal;
use Twilio\Rest\Client;

class ImportExcelController extends Controller
{
    function import(Request $request)
    {
        $csvModal = new CSVModal();
        \Excel::import($csvModal, request()->file('select_file'));
        $dataList = $csvModal->getData();

        foreach ($dataList as $data) {
            $customer = new Customer();
            $customer->name = $data['name'];
            if(substr($data['number'], 0, 1) != '+')
            {
                $customer->number = '+'. $data['number'];
            }
//            $customer->number = "+" . $data['number'];
            $customer->save();
            if ($request->type == 'sms-also'){
                try {
                    $account_sid = getenv("TWILIO_SID");
                    $auth_token = getenv("TWILIO_AUTH_TOKEN");
                    $twilio_number = getenv("TWILIO_NUMBER");
                    $client = new Client($account_sid, $auth_token);
                    $client->messages->create( $customer->number, ['from' => $twilio_number, 'body' => $request->messageTemplate]);

                }catch (\Exception $exception){
                    continue;
                }
                $chatParent = new ChatParent();
                $chatParent->number = $customer->number;
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
            }
        }
        return json_encode(['status' => true, 'message' => 'Excel Data Imported successfully.']);
    }
}
