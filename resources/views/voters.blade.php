@extends('base.base')

@section('title')
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
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-hover table-striped">
                            <thead style="background-color: #222D32; color:white;">
                                <th>Fullname</th>
                                <th>Username</th>
                                <th>Course</th>
                                <th>College</th>
                                <th style="width: 25% !important">Action</th>
                            </thead>
                            <tbody>
                                @foreach ($voters as $voter)
                                    <tr>
                                        <td>{{ $voter->last_name }}, {{ $voter->first_name }}</td>
                                        <td>{{ $voter->username }}</td>
                                        <td>{{ $voter->course_id }}</td>
                                        <td>{{ $voter->college_id }}</td>
                                        <td>
                                            <a href="#edit" data-toggle="modal"
                                                class="btn btn-success btn-sm edit btn-flat" data-id="{{ $voter->id }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="#delete" data-toggle="modal"
                                                class="btn btn-danger btn-sm delete btn-flat" data-id="{{ $voter->id }}"
                                                data-name="{{ $voter->first_name }} {{ $voter->last_name }}">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


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
                    <form action="{{ route('voters.store') }}" class="form-horizontal" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group has-feedback">
                                <label for="first_name">First Name:</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" required
                                    maxlength="30">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="middle_name">Middle Name:</label>
                                <input type="text" name="middle_name" id="middle_name" class="form-control" required
                                    maxlength="30">
                                @error('middle_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">

                                <label for="last_name">Last Name:</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" required
                                    maxlength="30">
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">

                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">

                                <label for="username">Username:</label>
                                <input type="text" name="username" id="username" class="form-control" required
                                    maxlength="30">
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="password">Password:</label>
                                <input type="text" name="password" id="password" class="form-control" required
                                    maxlength="16" minlength="8">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="student_id">Student ID:</label>
                                <input type="text" name="student_id" id="student_id" class="form-control" required
                                    maxlength="8" minlength="8">
                                @error('student_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group
                                    has-feedback">
                                <label for="course">Course:</label>
                                <select name="course" id="course" required class="form-control">
                                    <option value="" selected>---------</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                                    @endforeach
                                </select>
                                @error('course')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="year">Year Level:</label>
                                <select name="year" id="year" required class="form-control">
                                    <option value="" selected>---------</option>
                                    <option value="1">1st Year</option>
                                    <option value="2">2nd Year</option>
                                    <option value="3">3rd Year</option>
                                    <option value="4">4th Year</option>
                                </select>
                                @error('year')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger  btn-flat" data-dismiss="modal">
                                <i class="fa fa-close"></i> Close
                            </button>
                            <button type="submit" class="btn btn-success  btn-flat" name="add">
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
                    <b class="text-danger" id="ajx-error" style="display: none">Can't Find User</b>
                </div>
                <div class="modal-body">
                    <form action="{{ route('voters.update') }}" class="form-horizontal" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            {{-- *: This is the form template. Uncomment the span tag to add error message --}}
                            <input type="hidden" name="update_id" id="update_id">
                            <div class="form-group has-feedback">
                                <label for="edit_first_name">First Name:</label>
                                <input type="text" name="edit_first_name" id="edit_first_name" class="form-control"
                                    maxlength="30">
                                @error('edit_first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="edit_middle_name">Middle Name:</label>
                                <input type="text" name="edit_middle_name" id="edit_middle_name" class="form-control"
                                    required maxlength="30">
                                @error('edit_middle_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="edit_last_name">Last Name:</label>
                                <input type="text" name="edit_last_name" id="edit_last_name" class="form-control"
                                    required maxlength="30">
                                @error('edit_last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="edit_email">Email:</label>
                                <input type="text" name="edit_email" id="edit_email" class="form-control" required>
                                @error('edit_email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="edit_username">Username:</label>
                                <input type="text" name="edit_username" id="edit_username" class="form-control"
                                    required maxlength="30">
                                @error('edit_username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="edit_password">Password:</label>
                                <input type="text" name="edit_password" id="edit_password" class="form-control"
                                    maxlength="16">
                                @error('edit_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="edit_course">Course:</label>
                                <select type="text" name="edit_course" id="edit_course" class="form-control"
                                    required>
                                    <option value="" selected>---------</option>
                                    @foreach ($courses as $c)
                                        <option value="{{ $c->id }}">{{ $course->course_name }}</option>
                                    @endforeach
                                </select>
                                @error('edit_course')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="edit_year">Year Level:</label>
                                <select type="text" name="edit_year" id="edit_year" class="form-control">
                                    <option value="" selected>---------</option>
                                    <option value="1">1st Year</option>
                                    <option value="2">2nd Year</option>
                                    <option value="3">3rd Year</option>
                                    <option value="4">4th Year</option>
                                </select>
                                @error('edit_year')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                Status:
                                <label for="edit_status" class="switch">
                                    <input type="checkbox" id="edit_status" name="edit_status">
                                    <span class="slider round"></span>
                                </label>
                                @error('edit_status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger  btn-flat" data-dismiss="modal">
                                <i class="fa fa-close"></i> Close
                            </button>
                            <button type="submit" class="btn btn-success  btn-flat" name="edit">
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
                    <form action="{{ route('voters.destroy') }}" class="form-horizontal" method="POST">
                        @csrf
                        @method('delete')
                        <div class="modal-body">
                            <p class="text-center"><b style="font-size: 20px" id="del-text"></b></p>
                            <input type="hidden" name="user_del" id="user_del">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger  btn-flat" data-dismiss="modal">
                                <i class="fa fa-close"></i> Close
                            </button>
                            <button type="submit" class="btn btn-success  btn-flat" name="add">
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
                var id = $(this).data('id')
                getRow(id)
            })

            $(document).on("click", ".delete", function(e) {
                e.preventDefault()
                var id = $(this).data('id')
                var name = $(this).data('name')

                $("#del-text").html(`Are you sure you want to delete <i>${name.toUpperCase()}</i>?`)
                $("#user_del").val(id)

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
                url: "{{ route('voter.api') }}",
                data: {
                    voter_id: id
                },
                dataType: 'json',
                success: function(response) {
                    $("#ajx-error").css('display', 'none')
                    var data = response.data
                    $("#update_id").val(data.id)
                    $("#edit_first_name").val(data.first_name)
                    $("#edit_middle_name").val(data.middle_name)
                    $("#edit_last_name").val(data.last_name)
                    $("#edit_username").val(data.username)
                    $("#edit_email").val(data.email)
                    $("#edit_student_id").val(data.student_id)
                    $("#edit_course").val(data.course_id)
                    $("#edit_year").val(data.year)
                    if (data.status === 0) {
                        $("#edit_status").prop('checked', false)
                    } else {
                        $("#edit_status").prop('checked', true)
                    }
                },
                error: function(er) {
                    $("#ajx-error").css('display', 'block')
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
