@extends('layouts.app')
@section('content')
    <div class="p-4 ml-3"  style="margin-left: 20px">
        <div class="row">
            <div class="col-md-8 mt-2">
                <h2>Customer</h2>
            </div>
            <div class="col-md-4 mt-2 row">
                <div style="display: flex">
                    <input type="file" name="select_file" id="select_file" style="display: none" onchange="openModal()"/>
                </div>
                <div>
                    <a class="btn btn-primary" style="color: white" onclick="document.getElementById('select_file').click()">Upload Excel File and Send SMS</a>
                    <a class="btn btn-primary" href="{{url('/add-customer')}}">+ Add Customer</a>
                </div>
            </div>
        </div>
    </div>

    <button id="openModal" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Send SMS</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="message-template-div">
                        <label>Select Message Template:</label>
                        <select class="form-control" name="messageTemplate" id="messageTemplate">
                            @foreach(\App\MessageTemplate::all() as $template)
                                <option value="{{$template->message}}">{{$template->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button onclick="uploadExcelFile('save-only')" type="button" class="btn btn-secondary" data-dismiss="modal">Just Save Contacts</button>
                    <button onclick="uploadExcelFile('sms-also')"  type="button" class="btn btn-primary">Save contacts and also send sms</button>
                </div>
            </div>
        </div>
    </div>

    <div class="px-5"  style="margin-left: 20px">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th class="text-center">Number</th>
                <th class="text-center">Email</th>
                <th class="text-center">Options</th>
            </tr>
            </thead>
            <tbody>
            @if(count($customer) != 0)
                @foreach($customer as $key => $item)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td class="text-center">{{$item->number}}</td>
                        <td class="text-center">{{$item->email}}</td>
                        <td class="text-center">
                            <a href="{{url('/edit-customer/'.$item->id)}}">
                                <button class="btn btn-secondary">Edit</button>
                            </a>
                            <a href="{{url('/delete-customer/'.$item->id)}}">
                                <button class="btn btn-danger">Delete</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td></td>
                    <td></td>
                    <td>No customers found!</td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
<script>
    function openModal() {
        document.getElementById('openModal').click();
    }

    function uploadExcelFile(type) {
        let formData = new FormData();
        formData.append("select_file", document.getElementById('select_file').files[0]);
        formData.append("messageTemplate", document.getElementById('messageTemplate').value);
        formData.append("_token", "{{ csrf_token() }}");
        formData.append("type", type);
        $.ajax
        ({
            type: 'POST',
            url: `{{env('APP_URL')}}/import_excel/import`,
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                data = JSON.parse(data);
                if (data.status === true) {
                    swal.fire({
                        "title": "",
                        "text": "Excel Imported Successfully!",
                        "type": "success",
                        "showConfirmButton": true,
                        "onClose": function (e) {
                            window.location.reload();
                        }
                    })
                } else {
                    alert(data.message);
                }
            },
            error: function (data) {
                alert(data.message);
                console.log("data", data);
            }
        });
    }
</script>
