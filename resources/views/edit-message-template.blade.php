@extends('layouts.app')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <div class="px-5">
        <div class="container">
            <h5 class="mt-4 mb-3">Edit Message Template</h5>
            <form method="post" action="{{url("/save-edited-message-template")}}" style="width: 400px">
                {{csrf_field()}}
                <input hidden name="messageTemplateId" id="messageTemplateId" value="{{$messageTemplate->id}}">
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" class="form-control" placeholder="Enter Title" name="title" id="title"
                           value="{{$messageTemplate->title}}">
                </div>
                <div class="form-group">
                    <label>Message:</label>
                    <textarea type="text" class="form-control" placeholder="Enter Email" name="message"
                              id="message">{{$messageTemplate->message}}</textarea>
                </div>
                <button type="submit" id="btnFetch" class="btn btn-primary spinner-border">Update</button>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var notification = new Notification('Notification title', {
                icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
                body: "Hey there! You've been notified!",
            });

            notification.onclick = function () {
                window.open("http://stackoverflow.com/a/13328397/1269037");
            };
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
