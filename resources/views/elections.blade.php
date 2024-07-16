@extends('base.base')

@section('page_name')
    Election
@endsection

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
                                            {{ $election->title }}
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
                                            <a href="{{ route('elections.show', ['id' => $election->id]) }}"
                                                class="btn btn-primary btn-sm start btn-flat">
                                                <i class="fa fa-gear"></i> Manage
                                            </a>
                                            <a href="#deletemodal" data-toggle="modal"
                                                class="btn btn-danger btn-sm delete btn-flat" data-id="{{ $election->id }}"
                                                data-name="{{ $election->title }}">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                            @if ($election->started == true)
                                                <a href="{{ route('elections.update', ['action' => 'stop', 'id' => $election->id]) }}"
                                                    class="btn btn-danger btn-sm stop btn-flat">
                                                    <i class="fa fa-stop"></i> Stop
                                                </a>
                                            @else
                                                <a href="{{ route('elections.update', ['action' => 'start', 'id' => $election->id]) }}"
                                                    class="btn btn-success btn-sm stop btn-flat">
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
    <div class="modal fade" id="addNew" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>Add New Election</b></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="election_from">
                        @csrf
                        <div class="modal-body" id="election_add_data">
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
                        <div class="modal-body" id="add_progress" style="display: none;">
                            <p class="text-center" id="ajax_return"></p>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated active"
                                role="progressbar" style="width: 2%" id="progress-bar"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="elec_close" class="btn btn-danger btn-flat pull-left"
                                data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                            <button type="submit" id="elec_save" class="btn btn-success btn-flat"><i
                                    class="fa fa-save"></i> Save</button>
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
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>Deleting...</b></h4>
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('elections.destroy') }}">
                    <div class="modal-body">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="elec_del_id" id="elec_del_id">
                        <div class="text-center">
                            <h3 class="bold fullname" id="election_name_del"></h3>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                                class="fa fa-close"></i> Close</button>
                        <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i>
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
            $(".delete").on("click", function(e) {
                e.preventDefault()
                name = $(this).data('name')
                id = $(this).data('id')
                $("#election_name_del").html(`Are you sure you want to DELETE` + " " + `<i>${name}</i>?`)
                $("#elec_del_id").val(id)
            })

            $("#scope").on("change", function(e) {
                var selected = $(this).val();
                if (+selected === 1) {
                    $("#colege_selection").css('display', 'none');
                    $("#course_selection").css('display', 'none');
                    $("#year_selection").css('display', 'none');
                    $("#college_limit").attr("required", false);
                    $("#course_limit").attr("required", false);
                    $("#year_limit").attr("required", false);
                } else if (+selected === 2) {
                    $("#colege_selection").css('display', 'block');
                    $("#course_selection").css('display', 'none');
                    $("#year_selection").css('display', 'none');
                    $("#college_limit").attr("required", true);
                } else if (+selected === 3) {
                    $("#course_selection").css('display', 'block');
                    $("#year_selection").css('display', 'block');
                    $("#colege_selection").css('display', 'none');
                    $("#course_limit").attr("required", true);
                    $("#year_limit").attr("required", true);
                } else {
                    $("#colege_selection").css('display', 'none');
                    $("#course_selection").css('display', 'none');
                    $("#year_selection").css('display', 'none');
                }
            });

            $("#addNew").on('hidden.bs.modal', function() {
                $("#ajax_return").html("");
                $("#add_progress").css('display', 'none');
                $("#progress-bar").css("width", "2%")
                $("#election_add_data").css("display", "block");
                $("#colege_selection").css('display', 'none');
                $("#course_selection").css('display', 'none');
                $("#year_selection").css('display', 'none');
                $("#college_limit").attr("required", false);
                $("#course_limit").attr("required", false);
                $("#year_limit").attr("required", false);
            })

            $("#election_from").on("submit", (e) => {
                e.preventDefault()

                $.ajax({
                    type: 'POST',
                    url: "{{ route('elections.store') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        title: $("#title").val(),
                        scope: $("#scope").val(),
                        college_limit: $("#college_limit").val(),
                        course_limit: $("#course_limit").val(),
                        year_limit: $("#year_limit").val(),
                    },
                    success: function(response) {
                        $("#election_add_data").css("display", "none");
                        $("#ajax_return").html(response.message)
                        $("#add_progress").css("display", "block");
                        $("#progress-bar").css("width", "100%")
                        $("#elec_close").attr("disabled", true)
                        $("#elec_save").attr("disabled", true)
                        setTimeout(() => {
                            getVoters(response.id)
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr.responseText)
                        $("#elec_close").removeAttr("disabled")
                        $("#elec_save").removeAttr("disabled")
                    }
                });

            })


            function getVoters(id) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('elections.register') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        election_id: id
                    },
                    success: function(response) {
                        $("#progress-bar").css("width", "0%")
                        $("#ajax_return").html(response.message)
                        progressBar(response.id, id)

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });

            }

            async function progressBar(id, election_id) {
                window.addEventListener('keydown', function(event) {
                    if (event.key === 'r' && (event.ctrlKey || event.metaKey)) {
                        event.preventDefault();
                        alert('Reload not allowed while uploading data!');
                    } else if (event.key === 'F5') {
                        event.preventDefault();
                        alert('Reload not allowed while uploading data!');
                    }
                });

                const loop = setInterval(async () => {
                    const response = await $.ajax({
                        type: "GET",
                        url: "{{ route('elections.progress') }}",
                        data: {
                            "batch_id": id
                        },
                        dataType: "json"
                    })

                    pending = response.pendingJobs

                    $("#ajax_return").html(`Registering User...    ${response.progress}%`)
                    $("#progress-bar").css("width", `${response.progress}%`)

                    if (pending === 0 || pending === response.failedJobs) {
                        toastr.success("Voter's Registered!")
                        clearInterval(loop);
                        var url = `{{ route('elections.show', ['id' => ':id']) }}`
                        url = url.replace(':id', election_id);
                        window.location.href = url;
                    }

                }, 1000);
            }
        })
    </script>
@endsection
