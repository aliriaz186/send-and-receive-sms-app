@extends('layouts.app')
@section('content')


    <div class="p-4 ml-3"  style="margin-left: 20px">
        <div class="row">
            <div class="col-md-8 mt-2">
                <h2>Chats</h2>
            </div>
        </div>
    </div>
    <div style="margin-left: 25px;padding: 15px;">
        <h3>Filter Chats</h3>
        <div class="row">
            <div class="col-md-3">
                    <button class="btn btn-success" id="all-chats" style="width: 90%" onclick="getChats('all')">All Chats</button>
            </div>
            <div class="col-md-3">
                    <button  style="width: 90%" id="replied-chats" class="btn btn-block" onclick="getChats('replied')">Replied</button>
            </div>
            <div class="col-md-3">
                    <button  style="width: 90%" id="notreplied-chats" class="btn btn-block" onclick="getChats('notreplied')">Not Replied Yet</button>
            </div>
        </div>
    </div>

{{--    <input type="hidden" id="chatCount" value="">--}}
    <div>
        <button data-toggle="modal" data-target="#exampleModal111" class="btn btn-primary" id="send-to-selected-chats" style="margin-left: 25px;display: none">Send SMS to selected Chats</button>
    </div>
    <div style="margin-top: 5px">
        <button onclick="deleteSelected()" class="btn btn-danger" id="send-to-selected-chats-cus" style="margin-left: 25px;display: none">Delete Selected</button>

    </div>
    <div class="px-5"  style="margin-left: 20px">
        <div>
            <h3>Select All <input type="checkbox" name="chat-all" id="chat-all" onchange="checkAll()"></h3>
        </div>
        <table class="table" id="chats-table">
            <thead>
            <tr>
                <th style="width: 10%">Select</th>
                <th style="width: 10%">#</th>
                <th >Name</th>
                <th >Number</th>
                <th >Unread Messages</th>
                <th >Customer Replied</th>
                <th>Options</th>
            </tr>
            </thead>
{{--            <tbody>--}}
{{--            @if(count($chats) != 0)--}}
{{--                @foreach($chats as $key => $chat)--}}
{{--                    <tr>--}}
{{--                        <td><input type="checkbox" name="chat{{$key}}" id="chat{{$key}}" class="{{$chat->id}}" onclick="rowSelected()"></td>--}}
{{--                        <td>{{$key + 1}}</td>--}}
{{--                        <td class="text-center">{{\App\Customer::where('number', $chat->number)->first()['name'] ?? ""}}</td>--}}
{{--                        <td class="text-center">{{$chat->number}}</td>--}}
{{--                        <td class="text-center">{{\App\Chat::where('id_chat', $chat->id)->where('status', 0)->get()->count()}}</td>--}}
{{--                        <td class="text-center">--}}
{{--                            <a href="{{url('/chat-details/'.$chat->id)}}">--}}
{{--                                <button class="btn btn-secondary">Open Chat</button>--}}
{{--                            </a>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--            @else--}}
{{--                <tr>--}}
{{--                    <td></td>--}}
{{--                    <td></td>--}}
{{--                    <td>No chat found!</td>--}}
{{--                    <td></td>--}}
{{--                    <td></td>--}}
{{--                </tr>--}}
{{--            @endif--}}
{{--            </tbody>--}}
        </table>
    </div>
    <div class="modal fade" id="exampleModal111" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Send SMS</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="message-template-div">
                        <label>Select Message Template:</label>
                        <select class="form-control" name="messageTemplate" id="messageTemplate">
                            @foreach(\App\MessageTemplate::all() as $template)
                                <option value="{{$template->message}}">{{$template->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <h2>OR</h2>
                    </div>
                    <div>
                        <label>Write custom message here.</label><br>
                        <input name="custom_message" id="custom_message" class="form-control" type="text">
                    </div><br>
                    <div>
                        <button onclick="sendSMStoselected()" type="button" class="btn btn-secondary" data-dismiss="modal">Send SMS</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // window.onload = function(e){
        //     $('#chats-table').DataTable();
        //
        // }
        let checkAllSelected = 'not';
        window.onload = function(e){
            var table = $('#chats-table').DataTable({
                "autoWidth": true,
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax":{
                    "url": `{{env('APP_URL')}}/chats/all`,
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}", type : 'all'}
                },
                "columns": [
                    { "data": "select" },
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "number" },
                    { "data": "Unread Messages" },
                    { "data": "Customer Replied" },
                    { "data": "options" }
                ],
            });
        }

        function getChats(type) {
            document.getElementById('all-chats').classList.remove('btn-success');
            document.getElementById('replied-chats').classList.remove('btn-success');
            document.getElementById('notreplied-chats').classList.remove('btn-success');
            document.getElementById(type+'-chats').classList.remove('btn-block');
            document.getElementById(type+'-chats').classList.add('btn-success');
            $("#chats-table").DataTable().destroy();
            var table = $('#chats-table').DataTable({
                "autoWidth": true,
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax":{
                    "url": `{{env('APP_URL')}}/chats/all`,
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}", type : type}
                },
                "columns": [
                    { "data": "select" },
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "number" },
                    { "data": "Unread Messages" },
                    { "data": "Customer Replied" },
                    { "data": "options" }
                ],
            });
        }
        function rowSelected() {
            checkAllSelected = 'not';
            let chatCount = document.getElementById('chatCount').value;
            let checked = false;
            for (let i=0;i<chatCount;i++){
                if (document.getElementById('chat'+i).checked === true){
                    checked = true;
                }
            }
            if(checked) {

                document.getElementById('send-to-selected-chats').style.display = 'block';
                document.getElementById('send-to-selected-chats-cus').style.display = 'block';
            }else{
                document.getElementById('send-to-selected-chats').style.display = 'none';
                document.getElementById('send-to-selected-chats-cus').style.display = 'none';

            }
            document.getElementById('chat-all').checked = false;
        }

        function checkAll() {
            let chatCount = document.getElementById('chatCount').value;
            if(document.getElementById('chat-all').checked === true) {
                for (let i=0;i<chatCount;i++){
                    document.getElementById('chat'+i).checked = true;
                }
                document.getElementById('send-to-selected-chats').style.display = 'block';
                document.getElementById('send-to-selected-chats-cus').style.display = 'block';
                checkAllSelected = 'all';
            }else{
                for (let i=0;i<chatCount;i++){
                    document.getElementById('chat'+i).checked = false;
                }
                document.getElementById('send-to-selected-chats').style.display = 'none';
                document.getElementById('send-to-selected-chats-cus').style.display = 'none';
                checkAllSelected = 'not';

            }
        }

        function sendSMStoselected() {
            let formData = new FormData();
            formData.append("messageTemplate", document.getElementById('messageTemplate').value);
            formData.append("custom_message", document.getElementById('custom_message').value);
            formData.append("allSelected",  checkAllSelected);
            let chatCount = document.getElementById('chatCount').value;
            let finalCheckedArray = [];
            for (let i=0;i<chatCount;i++){
               if (document.getElementById('chat'+i).checked){
                   finalCheckedArray.push(document.getElementById('chat'+i).classList[0]);
               }
            }
            formData.append("finalCheckedArray", JSON.stringify(finalCheckedArray));
            formData.append("_token", "{{ csrf_token() }}");
            $.ajax
            ({
                type: 'POST',
                beforeSend: function(){
                    $('.ajax-loader').css("visibility", "visible");
                },
                complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                },
                url: `{{env('APP_URL')}}/send-sms-to-checked`,
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    data = JSON.parse(data);
                    if (data.status === true) {
                        swal.fire({
                            "title": "",
                            "text": "SMS Sent Successfully!",
                            "type": "success",
                            "showConfirmButton": true,
                            "onClose": function (e) {
                                window.location.reload();
                            }
                        })
                    } else {
                        alert(data.message);
                    }
                },
                error: function (data) {
                    swal.fire({
                        "title": "",
                        "text": "Maximum execution reached on server. Please try again with other contacts",
                        "type": "success",
                        "showConfirmButton": true,
                        "onClose": function (e) {
                            window.location.reload();
                        }
                    })
                    console.log("data", data);
                }
            });
        }

        function deleteSelected() {
            let formData = new FormData();
            let chatCount = document.getElementById('chatCount').value;
            let finalCheckedArray = [];
            for (let i=0;i<chatCount;i++){
                if (document.getElementById('chat'+i).checked){
                    finalCheckedArray.push(document.getElementById('chat'+i).classList[0]);
                }
            }
            formData.append("finalCheckedArray", JSON.stringify(finalCheckedArray));
            formData.append("allSelected",  checkAllSelected);
            formData.append("_token", "{{ csrf_token() }}");
            $.ajax
            ({
                type: 'POST',
                beforeSend: function(){
                    $('.ajax-loader').css("visibility", "visible");
                },
                complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                },
                url: `{{env('APP_URL')}}/delete-checked-chats`,
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    data = JSON.parse(data);
                    if (data.status === true) {
                        swal.fire({
                            "title": "",
                            "text": "Deleted Successfully!",
                            "type": "success",
                            "showConfirmButton": true,
                            "onClose": function (e) {
                                window.location.reload();
                            }
                        })
                    } else {
                        alert(data.message);
                    }
                },
                error: function (data) {
                    alert(data.message);
                    console.log("data", data);
                }
            });
        }
    </script>
@endsection
