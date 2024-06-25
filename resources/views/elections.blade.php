@extends('base.base')

@section('title')
    Elections
@endsection


@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <a href="#addNew" data-toggle="modal" class="btn btn-success btn-sm btn-flat ">
                            <i class="fa fa-plus"></i> Add New
                        </a>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-hover table-stripped">
                            <thead style="background-color: #222D32;color:white;">
                                <th>Election Name</th>
                                <th>Scope</th>
                                <th style="width: 30%"></th>
                            </thead>
                            <tbody>
                                @foreach ($elections as $election)
                                    <tr>
                                        <td>
                                            {{-- TODO: Change HREF --}}
                                            <a href="#" style="text-decoration: none;color:black;">
                                                {{ $election->title }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($election->scope == 1)
                                                University
                                            @elseif ($election->scope == 2)
                                                {{ $election->college_limit }}
                                            @elseif ($election->scope == 3)
                                                {{ $election->course_limit }} - {{ ordinal($election->year_level_limit) }}
                                                Year
                                            @else
                                            @endif
                                        </td>
                                        <td>
                                            {{-- TODO: Change data-id --}}
                                            <a href="#deletemodal" data-toggle="modal"
                                                class="btn btn-danger btn-sm delete btn-flat" data-id="elec_id here"
                                                data-name="elec_name">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                            @if ($election->started == true)
                                                <a href="#stopmodal" data-toggle="modal"
                                                    class="btn btn-danger btn-sm stop btn-flat" data-id="elec_id_here"
                                                    data-name="elec_name">
                                                    <i class="fa fa-stop"></i> Stop
                                                </a>
                                            @else
                                                <a href="#startmodal" data-toggle="modal"
                                                    class="btn btn-success btn-sm start btn-flat" data-id="elec_id_here"
                                                    data-name="elec_name">
                                                    <i class="fa fa-play"></i> Start
                                                </a>
                                            @endif
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
    <div class="modal fade" id="addNew">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>Add New Election</b></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" enctype="multipart/form-data" method="POST"
                        action="{{ route('elections.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group has-feedback">
                                <label for="title">Election Title: </label>
                                <input type="text" name="title" id="title" required maxlength="50"
                                    class="form-control">
                                @error('title')
                                    <span class="text-danger"></span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="scope">Scope: </label>
                                <select type="text" name="scope" id="scope" required class="form-control">
                                    <option value="" selected>-------</option>
                                    <option value="1">University</option>
                                    <option value="2">College</option>
                                    <option value="3">Program</option>
                                </select>
                                @error('scope')
                                    <span class="text-danger"></span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback" id="colege_selection" style="display: none">
                                <label for="college_limit">College Limit: </label>
                                <select type="text" name="college_limit" id="college_limit" class="form-control">
                                    <option value="" selected>-------</option>
                                    @foreach ($colleges as $college)
                                        <option value="{{ $college->id }}">{{ $college->college_name }}</option>
                                    @endforeach
                                </select>
                                @error('college_limit')
                                    <span class="text-danger"></span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback" id="course_selection" style="display: none">
                                <label for="course_limit">Course Limit: </label>
                                <select type="text" name="course_limit" id="course_limit" class="form-control">
                                    <option value="" selected>-------</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"> {{ $course->course_name }}</option>
                                    @endforeach
                                </select>
                                @error('course_limit')
                                    <span class="text-danger"></span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback" id="year_selection" style="display: none">
                                <label for="year_limit">Year Level Limit: </label>
                                <select type="text" name="year_limit" id="year_limit" class="form-control">
                                    <option value="" selected>-------</option>
                                    <option value="1">1st Year</option>
                                    <option value="2">2nd Year</option>
                                    <option value="3">3rd Year</option>
                                    <option value="4">4th Year</option>
                                </select>
                                @error('scope')
                                    <span class="text-danger"></span>
                                @enderror
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

    <div class="modal fade" id="delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>Deleting...</b></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="#">
                        <input type="hidden" class="id" name="id">
                        <div class="text-center">
                            <p>DELETE ELECTION</p>
                            <h2 class="bold fullname"></h2>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                            class="fa fa-close"></i> Close</button>
                    <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i>
                        Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="start">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>Starting...</b></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="#">
                        <input type="hidden" class="start_id" name="start_id" id="start_id">
                        <div class="text-center">
                            <h2 class="bold fullname"> Start Election?</h2>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                            class="fa fa-close"></i> Close</button>
                    <button type="submit" class='btn btn-success btn-sm start btn-flat' name="start"><i
                            class="fa fa-check"></i>
                        Start</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="stop">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>Stopping...</b></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="{% url 'stopElection' %}">
                        {% csrf_token %}
                        <input type="hidden" class="stop_id" name="stop_id" id="stop_id">
                        <div class="text-center">
                            <h2 class="bold fullname"> Are sure to stop this election?</h2>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                            class="fa fa-close"></i> Close</button>
                    <button type="submit" class='btn btn-success btn-sm start btn-flat' name="start"><i
                            class="fa fa-check"></i>
                        Yes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('custom_script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $("#scope").on("change", function(e) {
                var selected = $(this).val()
                if (+selected === 1) {
                    $("#colege_selection").css('display', 'none')
                    $("#course_selection").css('display', 'none')
                    $("#year_selection").css('display', 'none')
                    $("#college_limit").attr("required", false);
                    $("#course_limit").attr("required", false);
                    $("#year_limit").attr("required", false);
                } else if (+selected === 2) {
                    $("#colege_selection").css('display', 'block')
                    $("#course_selection").css('display', 'none')
                    $("#year_selection").css('display', 'none')
                    $("#college_limit").attr("required", true);
                } else if (+selected === 3) {
                    $("#course_selection").css('display', 'block')
                    $("#year_selection").css('display', 'block')
                    $("#colege_selection").css('display', 'none')
                    $("#course_limit").attr("required", true);
                    $("#year_limit").attr("required", true);
                } else {
                    $("#colege_selection").css('display', 'none')
                    $("#course_selection").css('display', 'none')
                    $("#year_selection").css('display', 'none')
                }
            })
        })
    </script>
@endsection
