@extends('layouts.app')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <div class="px-5">
        <div class="container">
            <h5 class="mt-4 mb-3">Add Customer</h5>
            @if($errors->any())
                <div class="alert alert-danger">
                    <h4>{{$errors->first()}}</h4>
                </div>
            @endif
            <form name="customerForm" method="post" action="{{url("/save-customer")}}" style="width: 400px">
                {{csrf_field()}}
                <input type="hidden" name="checker" id="checker" value="default">
                <div class="form-group">
                    <label>Name (Optional):</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                </div>
                <div class="form-group">
                    <label>Number:</label>
                    <input type="text" class="form-control" name="number" id="number" placeholder="Enter Number">
                </div>
                <div class="form-group">
                    <label style="position: relative;padding-left: 25px;">Check Box to send SMS<input
                            onclick="enableSmsSending()"
                            style="margin: 6px 0px 0px 0px;position: absolute;top: 0;left: 0;" id="smsCheckBox"
                            type="checkbox"></label>
                </div>
                <div class="form-group" id="message-template-div" style="display: none">
                    <label>Select Message Template:</label>
                    <select class="form-control" name="messageTemplate" id="messageTemplate">
                        @foreach(\App\MessageTemplate::all() as $template)
                            <option value="{{$template->message}}">{{$template->title}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" id="btnFetch" class="btn btn-primary spinner-border">Save</button>
                <button type="submit" id="smsSendButton" class="btn btn-primary spinner-border" disabled>Save and Send SMS</button>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        // document.getElementById('number').value = '+';
        // function plusAdd(){
        //     if(document.getElementById('number').value === ''){
        //         document.getElementById('number').value = '+';
        //     }
        // }


        function addCustomerValidation() {
            var name = document.forms["customerForm"]["name"];
            var number = document.forms["customerForm"]["number"];

            if (name.value === "")
            {
                window.alert("Please enter name.");
                name.focus();
                return false;
            }

            if (number.value === "")
            {
                window.alert("Please enter number.");
                number.focus();
                return false;
            }
            return true;
        }

        function enableSmsSending() {
            if (document.getElementById('smsCheckBox').checked === true) {
                document.getElementById('message-template-div').style.display = "block";
                document.getElementById('checker').value = "sms";
                document.getElementById('smsSendButton').disabled = false;
            } else {
                document.getElementById('message-template-div').style.display = "none";
                document.getElementById('smsSendButton').disabled = true;
                document.getElementById('checker').value = "default";
            }
        }

        $(document).ready(function () {
// Prepare the preview for profile picture
            $("#photo").change(function () {
                readURL(this);
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#photopreview').attr('src', e.target.result).fadeIn('slow');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
