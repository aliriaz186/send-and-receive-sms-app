@extends('layouts.app')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <div class="container">
        <h5 class="mt-4">Edit App</h5>
        <form method="post" action="{{url("/domain/update")}}" enctype="multipart/form-data" style="width: 400px">
            {{csrf_field()}}
            <div class="form-group">
                <label for="email">App Name:</label>
                <input type="text" class="form-control" value="{{$editDomain['name']}}" placeholder="Enter Name" name="name" id="name">
            </div>
            <div class="form-group">
                <label for="pwd">Redirect URL</label>
                <input type="text" class="form-control"  value="{{$editDomain['redirect']}}" id="url" placeholder="Enter redirect Url" name="url">
                <input type="hidden" class="form-control"  value="{{$editDomain['id']}}" id="id" name="id">
            </div>
            <button type="submit" id="btnFetch" class="btn btn-primary spinner-border">Submit</button>
        </form>
    </div>
    <script type="text/javascript">
        function uploadImage() {
            document.getElementById("photo").click();
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
// Prepare the preview for profile picture
            $("#photo").change(function(){
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
        $('form').submit(function(){
            let name = document.getElementById('name').value;
            let url = document.getElementById('url').value;
            regexp =  /^(?:(?:https?|ftp):\/\/)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/;
            if(name === ''){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Invalid Name!',
                });
                return false;
            }
            if(url === ''){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Invalid Url!',
                });
                return false;
            }
            if (regexp.test(url) !==true) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Invalid Url!',
                });
                return false;
            }
            $("#btnFetch").html(
                `<span class="spinner-border spinner-border-sm" role="status"></span> Loading...`
            );
        });
    </script>
@endsection
