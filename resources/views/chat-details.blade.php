@extends('layouts.app')
@section('content')
    <h1 style="text-align: center">Chat</h1>
    <h4 style="text-align: center">Customer: <span style="font-weight: bold">{{$customerName ?? $customerNumber}}</span></h4>
    <h4 style="text-align: center">Chat Staff: @foreach($chatMembers as $members) <span style="font-weight: bold">{{$members->sender}}</span>, @endforeach</h4>
    <div style="margin-left: 20px;height: 400px;overflow-y: scroll; border: 1px solid lightgray;padding: 10px">
            @if(count($chats) != 0)
                @foreach($chats as $key => $chat)
                    <div style="padding: 10px; border: 1px solid lightgray">
                        From : <span style="color: blue;font-size: 12px">

                            {{\App\Customer::where('number', $chat->sender)->first()['name'] ?? $chat->sender}}

                        </span><br><br>
                        <span style="margin-left: 0px;font-size: 15px;font-weight: bold">{{$chat->message}}</span>
                        <br>
                        <br>
                        <span style="font-size: 12px;">Date: {{$chat->created_at}} </span>
                    </div>
                @endforeach
            @else
                    <div>No chat found!</div>
            @endif

    </div>
    <div  class="px-5"  style="margin-left: 20px; border: 1px solid lightgray;padding: 10px">
        <form action="{{url('send-sms')}}/{{$parentId}}" method="post">
            @csrf
            <input type="text" class="form-control" name="message" required placeholder="type here...">
            <div style="margin-top: 15px">
                <button class="btn btn-primary" type="submit">Send</button>
            </div>
        </form>

    </div>

@endsection
