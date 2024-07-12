@extends('base.base')

@section('page_name')
    Courses
@endsection

@section('title')
    Courses
@endsection


@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <a href="#addcourse" data-toggle="modal" class="btn btn-success btn-sm btn-flat">
                            <i class="fa fa-plus"></i> Add Course
                        </a>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-hover table-striped">
                            <thead style="background-color: #222D32; color:white;">
                                <th>Course</th>
                                <th>Enrolled Student</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>{{ $course->course_name }}</td>
                                        <td>{{ $course->count }}</td>
                                        <td>
                                            <a href="#deletecourse" data-toggle="modal" data-id="{{ $course->id }}"
                                                data-name="{{ $course->course_name }}" class="btn delete btn-danger btn-sm btn-flat">
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
    <div class="modal fade" id="addcourse">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><b>Add New Course</b></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{ route('courses.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            {{-- *: Important Field Blueprint --}}
                            <div class="form-group has-feedback">
                                <label for="course">Course:</label>
                                <input type="text" name="course" id="course" class="form-control" required>
                                @error('course')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="college">College:</label>
                                <select name="college" id="college" class="form-control" required>
                                    <option value="" selected>------</option>
                                    @foreach ($colleges as  $college)
                                        <option value="{{$college->id}}">{{$college->college_name}}</option>
                                    @endforeach
                                </select>
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

    <div class="modal fade" id="deletecourse">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><b>Delete Course</b></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="{{ route('courses.destroy') }}">
                        @csrf
                        @method('delete')
                        <div class="modal-body">
                            <p class="text-center"><b style="font-size: 20px" id="del-text"></b></p>
                            <input type="hidden" name="course_del" id="course_del">
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
                $("#course_del").val(data)
            })
        })
    </script>
@endsection
