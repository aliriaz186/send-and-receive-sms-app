<?php

namespace App\Http\Controllers;

use App\MessageTemplate;
use Illuminate\Http\Request;

class MessageTemplateController extends Controller
{
    public function getMessageTemplateListView()
    {
        $messageTemplate = MessageTemplate::all();
        return view('message-template')->with(['messageTemplate' => $messageTemplate]);
    }

    public function getAddMessageTemplateView()
    {
        return view('add-message-template');
    }

    public function saveMessageTemplate(Request $request)
    {
        $messageTemplate = new MessageTemplate();
        $messageTemplate->title = $request->title;
        $messageTemplate->message = $request->message;
        $result = $messageTemplate->save();
        if ($result == true) {
            return redirect('message-template')->with('message', "Message Template Saved Successfully");
        } else {
            return redirect()->back()->with('message', $result);
        }
    }

    public function deleteMessageTemplate($messageTemplateId)
    {
        MessageTemplate::where('id', $messageTemplateId)->delete();
        return redirect()->back();
    }

    public function editMessageTemplate($messageTemplateId)
    {
        $messageTemplate = MessageTemplate::where('id', $messageTemplateId)->first();
        return view('edit-message-template')->with(['messageTemplate' => $messageTemplate]);
    }

    public function saveEditedMessageTemplate(Request $request)
    {
        $messageTemplate = MessageTemplate::where('id', $request->messageTemplateId)->first();
        $messageTemplate->title = $request->title;
        $messageTemplate->message = $request->message;
        $result = $messageTemplate->update();
        if ($result == true) {
            return redirect('message-template')->with('message', "Message Template Updated Successfully");
        } else {
            return redirect()->back()->with('message', $result);
        }
    }
}
