@extends('layouts.app')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <div class="container">
      <h5 class="mt-4 mb-3">Add Password</h5>
        <form method="post" action="{{url("/add-password")}}" style="width: 400px">
            {{csrf_field()}}
            <div class="form-group">
                <label for="email">Password:</label>
                <input type="text" class="form-control" placeholder="Enter Password or generate it" name="password" id="password">
                <a href="#" style="margin-top: 10px" onclick="generatePassword()">Generate password</a>
            </div>
            <button type="submit" id="btnFetch" class="btn btn-primary spinner-border">Save</button>
        </form>
    </div>
<script type="text/javascript">
    function generatePassword(){
        var length = 10,
            charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
            retVal = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            retVal += charset.charAt(Math.floor(Math.random() * n));
        }
        document.getElementById('password').value = retVal;
    }

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
        let password = document.getElementById('password').value;
        if(password === ''){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter password or genrate it!',
            });
            return false;
        }
            $("#btnFetch").html(
                `<span class="spinner-border spinner-border-sm" role="status"></span> Loading...`
            );
    });
</script>
@endsection
