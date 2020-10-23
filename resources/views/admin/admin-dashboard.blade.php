@extends('layouts.admin-layout')
@section('content')
    <div class="py-3 px-5">
        <button class="btn btn-primary" id="client" disabled onclick="changeMenu('websites')">Client Websites</button>
        <button class="btn btn-primary" id="reg" onclick="changeMenu('user')">Registered Users</button>
        <h4 id="heading-text" class="mt-3">Client Websites</h4>
        <div id="domain-list">
            @foreach($domains as $domainsData)
                <div class="d-flex mt-2" style="border: 2px solid lightgrey; padding: 10px">
                    <div style="width: 200px">
                        @if(!empty($domainsData->image_domain))
                            <img class="card-img-top" src="{{ asset('landing-page-styles/domains/' . $domainsData->image_domain) }}" alt="Card image" style="width: 100px;height: 100px;object-fit: contain; text-align: center">
                        @else
                            <img class="card-img-top" src="{{asset('landing-page-styles/images/undraw_secure_login_pdn4.svg')}}" alt="Card image" style="width: 100px;height: 100px;object-fit: contain;">
                        @endif
                    </div>
                    <div style="width: 150px; padding-right: 10px;padding-left: 10px" class="mt-3">
                        <h5>{{$domainsData->name}}</h5>
                    </div>
                    <div style="width: 150px;padding-right: 10px;padding-left: 10px" class="mt-3 ml-2">
                        <a target="_blank" href="{{$domainsData->redirect}}">{{$domainsData->redirect}}</a>
                    </div>
                    <div style="width: 150px;margin-left: 100px;padding-right: 10px;padding-left: 10px" class="mt-2">
                        <p type="text" id="secret-{{$domainsData->id}}" style="display: none;">{{$domainsData->secret}}</p>
                        <button class="btn btn-primary" onclick="copyKey({{$domainsData->id}})">Copy Secret Key</button>
                    </div>
                </div>
                <form method="post" action="{{url("/domain/delete")}}" id="delete-form">
                    @csrf
                    <input type="hidden" value="{{$domainsData->id}}" name="id">
                </form>
            @endforeach
        </div>

        <div id="user-list" style="display: none">
            @foreach($users as $user)
                <div class="d-flex mt-2" style="border: 2px solid lightgrey; padding: 10px">
                    <div style="width: 150px; padding-right: 10px;padding-left: 10px" class="mt-3">
                        <h5>{{$user->name}}</h5>
                    </div>
                    <div style="width: 150px; padding-right: 10px;padding-left: 10px" class="mt-3">
                        <h5>{{$user->email}}</h5>
                    </div>
                </div>
                <form method="post" action="{{url("/domain/delete")}}" id="delete-form">
                    @csrf
                    <input type="hidden" value="{{$domainsData->id}}" name="id">
                </form>
            @endforeach
        </div>
    </div>
    <script>
        function changeMenu(type){
            if (type === "websites"){
                document.getElementById('client').setAttribute('disabled', true);
                document.getElementById('reg').removeAttribute('disabled');
                document.getElementById('heading-text').innerHTML = "Client Websites";
                document.getElementById('domain-list').style.display = "inline";
                document.getElementById('user-list').style.display = "none";
            }else {
                document.getElementById('client').removeAttribute('disabled');
                document.getElementById('reg').setAttribute('disabled', true);
                document.getElementById('heading-text').innerHTML = "Users";
                document.getElementById('domain-list').style.display = "none";
                document.getElementById('user-list').style.display = "inline";
            }
        }
    </script>
@endsection
