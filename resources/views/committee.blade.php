@extends('base.base')

@section('page_name')
    Committee
@endsection

@section('title')
    Committee
@endsection


@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i>
                            Add New</a>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-hover table-striped">
                            <thead style="background-color: #222D32; color:white;">
                                <th>Fullname</th>
                                <th>Scope</th>
                                <th>Username</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($committee as $c)
                                    <tr>
                                        <td>{{ $c->fullname }}</td>
                                        @if ($c->ssc == 1)
                                            <td>SSC</td>
                                        @else
                                            <td>{{ $c->college_name }}</td>
                                        @endif
                                        <td>{{ $c->username }}</td>
                                        <td>
                                            <a href="#deleteCom" data-toggle="modal" data-id="{{ $c->id }}"
                                                data-name="{{ $c->fullname }}"
                                                class="btn delete btn-danger btn-sm btn-flat">
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
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title"><b>Add New Electoral Committee</b></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="{{ route('committee.store') }}">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group has-feedback">
                                <label for="user_id">Fullname: </label>
                                <select name="user_id" id="user_id" class="form-control" required></select>
                                @error('user_id')
                                    <span class="text-danger"></span>
                                @enderror
                            </div>

                            <div class="form-group has-feedback">
                                <label for="id_username">Username:</label>
                                <input type="text" name="username" class="form-control" required="" id="id_username">
                                @error('username')
                                    <span class="text-danger"></span>
                                @enderror
                            </div>

                            <div class="form-group has-feedback">
                                <label for="id_password">Password:</label>
                                <input type="password" name="password" class="form-control" required="" id="id_password">
                                @error('password')
                                    <span class="text-danger"></span>
                                @enderror
                            </div>


                            <div class="form-group has-feedback">
                                <label for="id_ssc">Ssc:</label>
                                <select name="ssc" class="form-control" required="" id="id_ssc">
                                    <option value="" selected="">---------</option>

                                    <option value="1">Yes</option>

                                    <option value="0">No</option>

                                </select>
                                @error('ssc')
                                    <span class="text-danger"></span>
                                @enderror
                            </div>

                            <div class="form-group has-feedback" id="scope_holder">
                                <span class="text-danger"></span>   
                                <label for="id_scope">Scope:</label>
                                <select name="scope" class="form-control" id="id_scope" style="display: block;">
                                    <option value="" selected="">---------</option>
                                    @foreach ($colleges as $c)
                                        <option value="{{ $c->id }}">{{ $c->college_name }}</option>
                                    @endforeach
                                </select>
                                @error('scope')
                                    <span class="text-danger"></span>
                                @enderror
                            </div>



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i
                                    class="fa fa-close"></i> Close</button>
                            <button type="submit" class="btn btn-success btn-flat" name="add" onclick="enableForm()"><i
                                    class="fa fa-save"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteCom">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>Deleting...</b></h4>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('committee.destroy') }}">
                    <div class="modal-body">
                        <input type="hidden" class="id" name="id">
                        @csrf
                        <div class="text-center">
                            <p>DELETE COMMITTEE</p>
                            <h2 class="bold fullname"></h2>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                                class="fa fa-close"></i> Close</button>
                        <button type="submit" class="btn btn-danger btn-flat" name="delete"><i
                                class="fa fa-trash"></i>
                            Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('custom_script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $("#scope_holder").css("display", "none")
            $("#id_username").attr("disabled", false)
            $("#id_password").attr("disabled", false)

            $(function() {

                $(document).on('click', '.delete', function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    $(".id").val(id)
                });

                $(document).on("change", "#id_ssc", function(e) {
                    if ($("#id_ssc").val() === "0") {
                        $("#scope_holder").css("display", "block")
                    } else {
                        $("#scope_holder").css("display", "none")
                    }
                })
            });

            $("#user_id").select2({
                width: "100%",
                placeholder: "Select Committee...",
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route('voters.find') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            })
        })
    </script>
@endsection
