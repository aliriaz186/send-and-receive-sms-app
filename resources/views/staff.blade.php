@extends('layouts.app')
@section('content')
    <div class="p-4 ml-3" style="margin-left: 20px">
        <div class="row">
            <div class="col-md-8 mt-2">
                <h2>Staff</h2>
            </div>
            <div class="col-md-3 text-right mt-2 ml-5">
                <a class="btn btn-primary float-right" href="{{url('/add-staff')}}">+ Add Staff</a>
            </div>
        </div>
    </div>
    <div class="px-5" style="margin-left: 20px">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th class="text-center">Name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Password</th>
{{--                <th class="text-center">Description</th>--}}
                <th class="text-center">Options</th>
            </tr>
            </thead>
            <tbody>
            @if(count($staff) != 0)
                @foreach($staff as $key => $item)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td class="text-center">{{$item->name}}</td>
                        <td class="text-center">{{$item->email}}</td>
                        <td class="text-center">{{$item->password}}</td>
{{--                        <td class="text-center">{{$item->description}}</td>--}}
                        <td class="text-center">
                            <a href="{{url('/edit-staff/'.$item->id)}}">
                                <button class="btn btn-secondary">Edit</button>
                            </a>
                            <a href="{{url('/delete-staff/'.$item->id)}}">
                                <button class="btn btn-danger">Delete</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
{{--                    <td></td>--}}
                    <td>No Staff Found Yet!</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
