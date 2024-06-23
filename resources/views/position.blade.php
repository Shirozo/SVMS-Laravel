@extends('base.base')

@section('title')
    Position
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
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-hover table-stripped">
                            <thead style="background-color: #222D32; color:white">
                                <th>Name</th>
                                <th>Maximum Votes</th>
                                <th>Priority</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($positions as $position)
                                    <tr>
                                        <td>{{ $position->name }}</td>
                                        <td>{{ $position->max_vote }}</td>
                                        <td>{{ $position->priority }}</td>
                                        <td>
                                            {{-- TODO: Change data id --}}
                                            <a href="#editPosition" data-toggle="modal" class="btn btn-primary btn-sm edit btn-flat"
                                                data-id="{{ $position->id }}">
                                                <i class="fa fa-edit"></i> Edit
                                        </a>
                                            <a href="#deletemodal" data-toggle="modal" data-name="{{ $position->name }}"
                                                class="btn btn-danger btn-sm delete btn-flat" data-id="{{ $position->id }}">
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
                    <h4 class="modal-title"><b>Add new</b></h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('positions.store') }}" method="POST" class="form-horizontal">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group has-feedback">
                                <label for="name">Name: </label>
                                <input type="text" name="name" id="name" required maxlength="50"
                                    class="form-control">
                                @error('name')
                                    <span class="text-danger"> {{ $message }}|</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="max_vote">Max Vote: </label>
                                <input type="number" name="max_vote" id="max_vote" required min="1"
                                    class="form-control">
                                @error('max_vote')
                                    <span class="text-danger"> {{ $message }}|</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="exclusive">Choose Yes if it is a exclusive for certain College or Course:
                                </label>
                                <select type="text" name="exclusive" id="exclusive" required class="form-control">
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                </select>
                                @error('exclusive')
                                    <span class="text-danger"> {{ $message }}|</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal">
                                <i class="fa fa-close"></i> Close
                            </button>
                            <button type="submit" class="btn btn-success btn-flat" name="add">
                                <i class="fa fa-save"></i> Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editPosition">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><b>Edit Position</b></h4>
                    <b class="text-danger" id="ajx-error" style="display: none">Can't Find User</b>
                </div>
                <div class="modal-body">
                    <form action="{{ route('positions.update') }}" method="POST" class="form-horizontal">
                        @csrf
                        @method("put")
                        <input type="hidden" name="up_p_id" id="up_p_id">
                        <div class="modal-body">
                            <div class="form-group has-feedback">
                                <label for="edit_name">Name: </label>
                                <input type="text" name="name" id="edit_name" required maxlength="50"
                                    class="form-control">
                                @error('name')
                                    <span class="text-danger"> {{ $message }}|</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="edit_max_vote">Max Vote: </label>
                                <input type="number" name="max_vote" id="edit_max_vote" required min="1"
                                    class="form-control">
                                @error('max_vote')
                                    <span class="text-danger"> {{ $message }}|</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="edit_exclusive">Choose Yes if it is a exclusive for certain College or Course:
                                </label>
                                <select name="exclusive" id="edit_exclusive" required class="form-control">
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                </select>
                                @error('exclusive')
                                    <span class="text-danger"> {{ $message }}|</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal">
                                <i class="fa fa-close"></i> Close
                            </button>
                            <button type="submit" class="btn btn-success btn-flat" name="add">
                                <i class="fa fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deletemodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><b>Delete Position</b></h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('positions.destroy') }}" method="POST" class="form-horizontal">
                        @csrf
                        @method('delete')
                        <div class="modal-body">
                            <p class="text-center"><b style="font-size: 20px" id="del-text"></b></p>
                            <input type="hidden" name="p_id_del" id="p_id_del">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal">
                                <i class="fa fa-close"></i> Close
                            </button>
                            <button type="submit" class="btn btn-success btn-flat" name="add">
                                <i class="fa fa-save"></i> Delete
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
                [2, 'asc'],
            ]).draw()

            $(".delete").on("click", function(e) {
                e.preventDefault()
                var name = $(this).data("name")
                var id = $(this).data("id")

                $("#del-text").html(
                    `Are you sure you want to delete <i>${name.toUpperCase()}</i> position?`)
                $("#p_id_del").val(id)
            })

            $(".edit").on("click", function(e) {
                e.preventDefault()
                var id = $(this).data("id")
                getRow(id)
            })

        })

        function getRow(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('positions.api') }}",
                data: {
                    p_id: id
                },
                dataType: 'json',
                success: function(response) {
                    $("#ajx-error").css('display', 'none')
                    var data = response.data
                    $("#up_p_id").val(data.id)
                    $("#edit_name").val(data.name)
                    $("#edit_max_vote").val(data.max_vote)
                    $("#edit_exclusive").val(data.exclusive)

                },
                error: function(er) {
                    $("#ajx-error").css('display', 'block')
                }
            })
        }
    </script>
@endsection
