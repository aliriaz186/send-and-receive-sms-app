@extends('layouts.app')
@section('content')
    <div class="p-4 ml-3"  style="margin-left: 20px">
        <div class="row">
            <div class="col-md-8 mt-2">
                <h2>Chats</h2>
            </div>
        </div>
    </div>

    <div class="px-5"  style="margin-left: 20px">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th class="text-center">Number</th>
                <th class="text-center">Options</th>
            </tr>
            </thead>
            <tbody>
            @if(count($chats) != 0)
                @foreach($chats as $key => $chat)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td class="text-center">{{$chat->number}}</td>
                        <td class="text-center">
                            <a href="{{url('/chat-details/'.$chat->id)}}">
                                <button class="btn btn-secondary">Open Chat</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td></td>
                    <td></td>
                    <td>No chat found!</td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
