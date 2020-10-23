@extends('layouts.app')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <div class="container">
        <h5 class="mt-4 mb-3">Add Category</h5>
        <form method="post" action="{{url("/save-category")}}" style="width: 400px">
            {{csrf_field()}}
            <div class="form-group">
                <label for="email">Name:</label>
                <input type="text" class="form-control" placeholder="Enter Category" name="name" id="name">
            </div>
            <button type="submit" id="btnFetch" class="btn btn-primary spinner-border">Save</button>
        </form>
    </div>
    <script type="text/javascript">
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
