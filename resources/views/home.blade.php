@extends('layouts.app')
@section('content')
    <div class="p-4 ml-3">
        <div class="row">
{{--            <div class="col-md-11 mt-2">--}}
{{--                <h2 class="text-center" style="text-decoration: underline">Upcoming Events</h2>--}}
{{--                <h6 class="text-center">(For Next 30 Days)</h6>--}}
{{--            </div>--}}
        </div>
    </div>
    <div class="px-5">
{{--        <div class="row">--}}
{{--            @if(count($eventsList) != 0)--}}
{{--                @foreach($eventsList as $event)--}}
{{--                    <div class="col-xl-3 col-lg-3 order-lg-3 order-xl-2 ml-3" style="color: #646c9a;">--}}
{{--                        <div--}}
{{--                            style="display: flex;flex-grow: 1;flex-direction: column;box-shadow: 0px 0px 13px 0px rgba(82, 63, 105, 0.05);background-color: #e2e2e257;margin-bottom: 20px;border-radius: 4px;">--}}
{{--                            <div style="padding: 25px;">--}}
{{--                                <h4 class="text-center" style="text-decoration: underline">{{$event->title}}</h4>--}}
{{--                                @if(!empty($event->category))--}}
{{--                                    <div class="mb-3"><h6 class="text-center">({{$event->category}})</h6></div>--}}
{{--                                @else--}}
{{--                                    <div class="mb-3"><h6 class="text-center">(Not Added Yet)</h6></div>--}}
{{--                                @endif--}}
{{--                                <div class="row" style="padding: 15px;text-align: center;">--}}
{{--                                    <div style="margin: 0 auto">--}}
{{--                                        <span style="font-weight: bold">Date:</span> {{explode(" ", $event->start)[0]}}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            @else--}}
{{--                <div class="col-xl-11 col-lg-11 order-lg-11 order-xl-11" style="color: #646c9a;"><h1--}}
{{--                        class="text-center">No Upcoming Events Yet!</h1></div>--}}
{{--            @endif--}}
{{--        </div>--}}
    </div>
@endsection
