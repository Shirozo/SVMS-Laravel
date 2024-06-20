@extends('base.base')

@section("title")
Voters
@endsection

@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat">
                            <i class="fa fa-plus"></i> Add New
                        </a>
                        <a href="#uploaduser" data-toggle="modal" class="btn btn-success btn-sm btn-flat">
                            <i class="fa fa-plus"></i> Upload File
                        </a>
                        <a href="#deactivate" data-toggle="modal" class="btn btn-danger btn-sm btn-flat">
                            <i class="fa fa-ban"></i> Deactivate All User
                        </a>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-hover table-striped">
                            <thead style="background-color: #222D32; color:white;">
                                <th>Fullname</th>
                                <th>Course</th>
                                <th>College</th>
                                <th>Username</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                {{-- TODO: Voter list will be rendered here. Change the user_id in data-id --}}
                                <tr>
                                    <td>Sample</td>
                                    <td>Data</td>
                                    <td>Sample</td>
                                    <td>Sample</td>
                                    <td>
                                        <button class="btn btn-success btn-sm edit btn-flat" data-id="user_id">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm delete btn-flat" data-id="user_id">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


{{-- TODO: Add user add url in form --}}
@section('modal')
    <div class="modal fade" id="addnew">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><b>Add New Voter</b></h4>
                </div>
                <div class="modal-body">
                    <form action="#" class="form-horizontal" method="POST">
                        @csrf
                        <div class="modal-body">
                            {{-- *: This is the form template. Uncomment the span tag to add error message --}}
                            <div class="form-group has-feedback">
                                <span class="text-danger">Error Message will be here!</span>
                                <label for="sample_id">Username</label>
                                <input type="text" name="" id="sample_id" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger  btn-flat" data-dismiss="modal">
                                <i class="fa fa-close"></i> Close
                            </button>
                            <button type="button" class="btn btn-success  btn-flat" name="add" onclick="enableform()">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploaduser">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><b>Upload User</b></h4>
                </div>
                <div class="modal-body">
                    <form action="#" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div style="align-items: center; width:fit-content; margin:0% auto;">
                            <label for="voter_file">
                                <div class="voter-upload" ondrop="handleDrop(event)" ondragover="handleDragOver(event)">
                                    <img src="images/upload.png" width="100px" height="100px" id="np_upload">
                                    <img src="images/uploaded.png" width="100px" height="100px" id="uploaded"
                                        style="display: none">
                                </div>
                            </label>
                            <input type="file" accept=".csv, .xlsx" name="" id="voter_file" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger  btn-flat" data-dismiss="modal">
                                <i class="fa fa-close"></i> Close
                            </button>
                            <button type="button" class="btn btn-success  btn-flat" name="add"
                                onclick="enableform()">
                                <i class="fa fa-save"></i> Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><b>Edit Voter</b></h4>
                </div>
                <div class="modal-body">
                    <form action="#" class="form-horizontal" method="POST">
                        @csrf
                        <div class="modal-body">
                            {{-- *: This is the form template. Uncomment the span tag to add error message --}}
                            <div class="form-group has-feedback">
                                <span class="text-danger">Error Message will be here!</span>
                                <label for="sample_id">Username</label>
                                <input type="text" name="" id="sample_id" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger  btn-flat" data-dismiss="modal">
                                <i class="fa fa-close"></i> Close
                            </button>
                            <button type="button" class="btn btn-success  btn-flat" name="edit">
                                <i class="fa fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><b>Deleting...</b></h4>
                </div>
                <div class="modal-body">
                    <form action="#" class="form-horizontal" method="POST">
                        @csrf
                        <input type="hidden" class="id" name="id">
                        <div class="text-center">
                            <p>DELETE VOTER</p>
                            <h2 class="bold fullname"></h2>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger  btn-flat" data-dismiss="modal">
                                <i class="fa fa-close"></i> Close
                            </button>
                            <button type="button" class="btn btn-success  btn-flat" name="add">
                                <i class="fa fa-save"></i> Delete
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deactivate">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><b>Deactivate....</b></h4>
                </div>
                <div class="modal-body">
                    <form action="#" class="form-horizontal" method="POST">
                        @csrf
                        <input type="hidden" class="id" name="id">
                        <div class="text-center">
                            <p>DEACTIVATE ALL USER?</p>
                            <h2 class="bold fullname"></h2>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger  btn-flat" data-dismiss="modal">
                                <i class="fa fa-close"></i> Close
                            </button>
                            <button type="button" class="btn btn-success  btn-flat" name="add">
                                <i class="fa fa-save"></i> Confirm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('custom_script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var table = $("#example1").DataTable()

            table.order([
                [1, 'asc'],
                [0, 'asc']
            ]).draw()

            $(document).on("click", ".edit", function(e) {
                e.preventDefault()
                $("#edit").modal("show")
                var id = $(this).data('id')
                getRow(id)
            })

            $(document).on("click", ".delete", function(e) {
                e.preventDefault()
                $("#delete").modal("show")
                var id = $(this).data('id')
                getRow(id)
            })

        })


        function enableform() {
            /*enable the form. sample*/
            $("#id_username").prop("disabled", false)
        }

        // Add url here for API
        function getRow(id) {
            $.ajax({
                type: "GET",
                url: "#",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Do logic here if request if")
                }
            })
        }

        function handleDragOver(event) {
            event.preventDefault()
            event.dataTransfer.dropEffect = "copy"
        }


        function handleDrop(event) {
            event.preventDefault()
            const file = event.dataTransfer.files;

            for (let i = 0; i < file.length; i++) {
                console.log("Dropped file", file[i])
            }

            const fileInput = document.getElementById("voter_file");
            fileInput.files = file;
        }
    </script>
@endsection
