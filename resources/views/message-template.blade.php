@extends('layouts.app')
@section('content')
    <div class="p-4 ml-3"  style="margin-left: 20px">
        <div class="row">
            <div class="col-md-8 mt-2">
                <h2>Message Template</h2>
            </div>
            <div class="col-md-3 text-right mt-2 ml-5">
                <a class="btn btn-primary float-right" href="{{url('/add-message-template')}}">+ Add Message Template</a>
            </div>
        </div>
    </div>
    <div class="px-5"  style="margin-left: 20px">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th class="text-center">Title</th>
                <th class="text-center">Message</th>
                <th class="text-center">Options</th>
            </tr>
            </thead>
            <tbody>
            @if(count($messageTemplate) != 0)
                @foreach($messageTemplate as $key => $item)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td class="text-center">{{$item->title}}</td>
                        <td class="text-center">{{$item->message}}</td>
                        <td class="text-center">
                            <a href="{{url('/edit-message-template/'.$item->id)}}">
                                <button class="btn btn-secondary">Edit</button>
                            </a>
                            <a href="{{url('/delete-message-template/'.$item->id)}}">
                                <button class="btn btn-danger">Delete</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td></td>
                    <td></td>
                    <td>No Message Template Found Yet!</td>
{{--                    <td></td>--}}
                    <td></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
