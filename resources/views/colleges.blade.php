@extends('base.base')

@section('title')
    College
@endsection

@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <a href="#addcollege" data-toggle="modal" class="btn btn-success btn-sm btn-flat">
                            <i class="fa fa-plus"></i> Add College
                        </a>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-hover table-striped">
                            <thead style="background-color: #222D32; color:white;">
                                <th>College</th>
                                <th>Enrolled Student</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($colleges as $college)
                                    <tr>
                                        <td>{{ $college->college_name }}</td>
                                        <td>0</td>
                                        <td>
                                            <a href="#deleteCollege" data-toggle="modal" data-id="{{ $college->id }}"
                                                data-name="{{ $college->college_name }}" class="btn delete btn-danger btn-sm btn-flat">
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
    <div class="modal fade" id="addcollege">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><b>Add New College</b></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{ route('college.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            {{-- *: Important Field Blueprint --}}
                            <div class="form-group has-feedback">
                                <label for="college">College:</label>
                                <input type="text" name="college" id="college" class="form-control" required>
                                @error('college')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal">
                                <i class="fa fa-close"></i> Close
                            </button>
                            <button type="submit" class="btn btn-success btn-flat" name="add">
                                <i class="fa fa-save"> Save</i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteCollege">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><b>Delete College</b></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="{{ route('college.destroy') }}">
                        @csrf
                        @method('delete')
                        <div class="modal-body">
                            <p class="text-center"><b style="font-size: 20px" id="del-text"></b></p>
                            <input type="hidden" name="college_del" id="college_del">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i
                                    class="fa fa-close"></i> Close</button>
                            <button type="submit" class="btn btn-success btn-flat" name="add"><i
                                    class="fa fa-save"></i> Yes</button>
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
            $(".delete").on('click', function(e) {
                e.preventDefault()
                var data = $(this).data('id')
                var name = $(this).data('name')

                $("#del-text").html(`Are you sure you want to delete <i>${name.toUpperCase()}</i>?`)
                $("#college_del").val(data)
            })
        })
    </script>
@endsection
