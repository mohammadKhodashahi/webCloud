<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container">
                    <div class="col-md-8 section offset-md-2">
                        <div class="panel panel-primary">

                            <div class="panel-body">

                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success alert-block">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @endif
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> There were some problems with your input.
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{ route('file.upload.post') }}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input type="file" name="file" class="form-control">
                                        </div>

                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success">Upload</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="message" class="text-center" style="display: none;">

    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table">
                    <thead>
                    <tr>
                        <td>Name</td>
                        <td>Format</td>
                        <td>Size</td>
                        <td>Uploaded</td>
                        <td>Download</td>
                        <td>Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($userFiles as $userFile)
                        <tr id="{{$userFile->id}}">
                            <td>
                                <div id="name-{{$userFile->id}}">{{$userFile->name}}</div>
                            </td>
                            <td>{{$userFile->format}}</td>
                            <td>{{$userFile->getFileSize(true)}}</td>
                            <td>{{$userFile->created_at}}</td>
                            <td><a href="/download/file/{{$userFile->id}}">Link</a></td>
                            <td>
                                <button onclick="deleteFile('{{$userFile->id}}')" class="btn btn-danger">
                                    Delete
                                </button>
                                <button type="button" class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#editModal" data-id="{{$userFile->id}}">Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit name</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="name">
                            <input type="hidden" id="id">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-dismiss="modal">
                        Cancel
                    </button>
                    <button onclick="editName()" type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <script>

        function deleteFile(id) {
            var result = confirm("Want to delete?");
            if (result) {
                $('#message').empty();
                $.ajax({
                    type: "DELETE",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: '/api/file/' + id,
                    success: function (data) {
                        $('#' + id).hide();
                        $('#message').show();
                        $('#message').append('<div class="alert">' + data.message + '</div>');
                        window.setTimeout(function () {
                            $('#message').hide();
                        }, 5000);
                    }
                });
            }

        }

        function editName() {

            var id = $('#id').val();
            var name = $('#name').val();
            $.ajax({
                type: "PUT",
                data: {'name': name},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/api/file/' + id,
                success: function (data) {
                    $('#message').empty();
                    $('#message').show();
                    $('#message').append('<div class="alert alert-success">' + data.message + '</div>');
                    window.setTimeout(function () {
                        $('#message').hide();
                    }, 5000);
                    document.getElementById('name-' + id).innerText = name;
                    $('#editModal').hide();
                    $('.modal-backdrop').remove();
                }
            });

        }


        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = document.getElementById('name-' + id).innerText;
            var modal = $(this);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #id').val(id);
        })


    </script>


</x-app-layout>

