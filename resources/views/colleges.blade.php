@extends('base.base')

@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <a href="#addcollege" data-toggle="modal" class="btn btn-success btn-sm btn-flat">
                            <i class="fa fa-plus"></i> Add College
                        </a>
                        <a href="#removecollege" data-toggle="modal" class="btn btn-danger btn-sm btn-flat">
                            <i class="fa fa-minus"></i> Remove College
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <table id="example1" class="table tablebordered table-hover table-stripped">
                        <thead style="background: #222D32; color:white">
                            <th>Course</th>
                            <th>College</th>
                            <th>Enrolled Student</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Sample</td>
                                <td>Data</td>
                                <td>Rendered</td>
                                <td>
                                    <form action="#" method="POST">
                                        @csrf
                                        <input type="hidden" name="course_delete" id="course_delete"
                                            value="custom_value_here">
                                        <button class="btn btn-danger btn-sm btn-flat"
                                            data-id="custom_value">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                    <h4>Add New College</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="#route_for_new_college" method="POST">
                        @csrf
                        <div class="modal-body">
                            {{-- *: Important Field Blueprint --}}
                            <div class="form-group has-feedback">
                                {{-- *: Still need to learn --}}
                                {{-- <span class="text-danger">Error Message Here</span> --}}
                                {{-- TODO: Add field here. Sample below. --}}
                                <label for="sample">Sample Input</label>
                                <input type="text" name="" id="sample" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal">
                                <i class="fa fa-close"></i> Close
                            </button>
                            <button type="submit" class="btn btn-success btn-sm btn-flat" name="add">
                                <i class="fa fa-save"> Save</i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="removecollege">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><b>Remove College</b></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="{% url 'removeCollege' %}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group has-feedback">
                                <label for="rm_sample">Remove Sample</label>
                                <select name="" id="rm_sample" class="form-control">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i
                                    class="fa fa-close"></i> Close</button>
                            <button type="submit" class="btn btn-success btn-flat" name="add"><i
                                    class="fa fa-save"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
