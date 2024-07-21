@extends('base.electionbase')

@section('page_name')
    {{ $election->title }} Election
@endsection

@section('title')
    Elections
@endsection


@section('main')
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>Voters</h3>
                        <p>No. of Count</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>Candidate</h3>
                        <p>No. of Count: {{ $candidates->count() }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-brands fa-black-tie"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>Voted</h3>
                        <p>No. of Count</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check"></i>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <b style="float: left" id="table-title">Candidates</b>
                        <div class="btn-group dropleft election-options">
                            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="color: black">
                                <i class="fa-solid fa-ellipsis-vertical fa-xl"></i>
                            </a>
                            <div class="dropdown-menu dd-left" x-placement="left-start">
                                <a class="dropdown-item" href="#">View Ballot</a>
                                <a class="dropdown-item" href="#addCandidate" data-toggle="modal">Add Candidate</a>
                                <a class="dropdown-item" href="#addVoter" data-toggle="modal">Add Voter</a>
                                <a id="voterButton" class="dropdown-item" onclick="showVoters('voter')">Show Voters</a>
                                <a id="candidateButton" style="display: none" class="dropdown-item"
                                    onclick="showVoters('candidate')">Show Candidates</a>
                            </div>
                        </div>
                    </div>
                    <div class="box-body" id="candidate_container">
                        <table id="candidate_table" class="table table-bordered table-hover table-stripped">
                            <thead style="background-color: #222D32;color:white;">
                                <th>Candidate Name</th>
                                <th>Position</th>
                                <th style="width: 20%"> Action</th>
                            </thead>
                            <tbody>
                                @foreach ($candidates as $candidate)
                                    <tr>
                                        <td>{{ $candidate->fullname }}</td>
                                        <td>{{ $candidate->position_name }}</td>
                                        <td>
                                            <a href="#" data-toggle="modal" class="btn btn-primary btn-flat btn-sm"
                                                data-id="{{ $candidate->id }}" data-name="{{ $candidate->fullname }}">
                                                <i class="fa fa-pen-to-square"></i> Edit
                                            </a>
                                            <a href="#delete_candidate" data-toggle="modal"
                                                class="btn delete btn-danger btn-flat btn-sm" data-id="{{ $candidate->id }}"
                                                data-name="{{ $candidate->fullname }}">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="box-body" id="voter_container" style="display: none">
                        <table id="voters_table" class="table table-bordered table-hover table-stripped">
                            <thead style="background-color: #222D32; color:white">
                                <th> Voter Name</th>
                                <th> Has Voted</th>
                                <th style="width: 20%"> Action </th>
                            </thead>
                            <tbody>
                                @foreach ($voters as $voter)
                                    <tr>
                                        <td>{{ $voter->voter_name }}</td>
                                        <td>
                                            @if ($voter->has_voted === 0)
                                                False
                                            @else
                                                True
                                            @endif
                                        </td>
                                        <td style="width: 20%">
                                            <a href="#delete_voter" data-toggle="modal"
                                                class="btn delete-voter btn-danger btn-flat btn-sm"
                                                data-id="{{ $voter->id }}" data-name="{{ $voter->voter_name }}">
                                                <i class="fa fa-trash"></i> Remove
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
    <div class="modal fade" id="addCandidate" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>Add New Candidate </b></h4>
                </div>
                <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                    action="{{ route('candidate.store', ['id' => $election->id]) }}">
                    <div class="modal-body">
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
                                <label for="bio">Bio: </label>
                                <textarea style="min-height: 100px" type="text" name="bio" id="bio" class="form-control" required
                                    placeholder="Candidate Bio"></textarea>
                                @error('bio')
                                    <span class="text-danger"></span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="position">Position: </label>
                                <select name="position" id="position" class="form-control" required>
                                    <option value="" selected> Position</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </select>
                                @error('position')
                                    <span class="text-danger"></span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback">
                                <label for="photo">Photo: </label>
                                <input type="file" accept="image/*" name="photo" id="photo" required></input>
                                @error('photo')
                                    <span class="text-danger"></span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal"><i
                                class="fa fa-close"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-plus"></i>
                            Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addVoter" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title">Add Voter To Election</h4>
                </div>
                <form id="addVoterElection">
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group has-feedback">
                                <label for="add_user_id">Fullname: </label>
                                <select name="add_user_id" id="add_user_id" class="form-control" required></select>
                                @error('add_user_id')
                                    <span class="text-danger"></span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn addV_close btn-danger btn-flat" data-dismiss="modal"><i
                                    class="fa fa-close"></i> Close</button>
                            <button type="submit" class="btn addV btn-success btn-flat"><i class="fa fa-plus"></i>
                                Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_candidate">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title"><b>Deleting...</b></h4>
                </div>
                <form method="POST" action="{{ route('candidate.destroy', ['id' => $election->id]) }}">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <input type="hidden" name="del_id" id="del_id">
                        <div class="text-center">
                            <h3 class="bold fullname" id="candidate-name"></h3>
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

    <div class="modal fade" id="delete_voter">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title"><b>Deleting...</b></h4>
                </div>
                <form method="POST" id="deleteVoter">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <input type="hidden" name="vtr_id" id="vtr_id">
                        <div class="text-center">
                            <h3 class="bold fullname" id="voter-name"></h3>
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

            voter_param = new URL(window.location.href);
            url_voter = new URLSearchParams(voter_param.search);
            action = url_voter.get('show')
            data = url_voter.get("data")

            if (data === "new") {
                toastr.success("Voter Added!")
                url_voter.delete('data');
                window.history.replaceState({}, '', url_voter.toString());

            }
            showVoters(action)

            const candidateTable = $("#candidate_table").DataTable({
                responsive: true
            })

            const voterTable = $("#voters_table").DataTable({
                responsive: true
            })


            $(".delete").on("click", function(e) {
                e.preventDefault()
                name = $(this).data('name')
                id = $(this).data('id')
                $("#del_id").val(id)
                $("#candidate-name").html(`Are you sure you want to DELETE` + " " + `<i>${name}</i>?`)
            })

            $(".delete-voter").on("click", function(e) {
                e.preventDefault()
                name = $(this).data('name')
                id = $(this).data('id')
                $("#vtr_id").val(id)
                $("#voter-name").html(`Are you sure you want to DELETE` + " " + `<i>${name}</i>?`)
            })


            $("#addVoterElection").on("submit", function(e) {
                e.preventDefault();

                v_id = $("#add_user_id").val()
                e_id = "{{ $election->id }}"
                $("#addV_close").attr("disabled", true)
                $("#addV").attr("disabled", true)

                $.ajax({
                    type: "POST",
                    url: "{{ route('elections.store_voter', ['id' => $election->id]) }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        add_user_id: v_id,
                        elec_id: e_id
                    },
                    success: function(response) {
                        if (action === "voter") {
                            toastr.success(response.message)
                            $("#addV_close").removeAttr("disabled")
                            $("#addV").removeAttr("disabled")
                            voterTable.row.add(
                                [
                                    response.voter_name,
                                    "False",
                                    `<a href="#delete_voter" data-toggle="modal"
                                        class="btn delete-voter btn-danger btn-flat btn-sm"
                                        data-id="${ response.id }" data-name="${response.voter_name }">
                                        <i class="fa fa-trash"></i> Remove
                                    </a>`
                                ]
                            ).draw()

                        } else {
                            const url = new URL(window.location.href);
                            const params = new URLSearchParams(url.search);
                            params.set("show", "voter");
                            params.set("data", "new");
                            url.search = params.toString();

                            window.location.href = url.toString();
                        }
                    },
                    error: function(xhr, status, error) {
                        error_message = JSON.parse(xhr.responseText).message;
                        toastr.error(error_message)
                        $("#addV_close").removeAttr("disabled")
                        $("#addV").removeAttr("disabled")
                    }
                })
            })

            $("#deleteVoter").on("submit", function(e) {
                e.preventDefault()

                ids = $("#vtr_id").val()
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('voters.delete_specific', ['id' => $election->id]) }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        'vtr_id': ids,
                    },
                    success: function(response) {
                        voterTable.rows().every(function() {
                            var _data = this.data();
                            if (_data) {
                                if (_data[0] === response.name) {
                                    this.remove().draw();
                                }
                            }
                        })
                        toastr.success(response.message)
                        $("#delete_voter").modal("hide")
                    },
                    error: function(xhr, status, error) {
                        error_message = JSON.parse(xhr.responseText).message;
                        toastr.error(error_message)
                    }
                })
            })

            $("#user_id").select2({
                width: "100%",
                placeholder: "Select Candidate...",
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route('elections.search') }}',
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

            $("#add_user_id").select2({
                width: "100%",
                placeholder: "Select Candidate...",
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

            function getVoters(id) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('elections.register') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        election_id: 1
                    },
                    success: function(response) {
                        $("#progress-bar").css("width", "2%")
                        $("#ajax_return").html(response.message)
                        createBatch(response)
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });

            }
        })

        function showVoters(action) {
            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);
            if (action === 'voter') {
                $("#candidate_container").css("display", "none")
                $("#voter_container").css("display", "block")
                $("#table-title").html("Voters")
                $("#candidateButton").css("display", "block")
                $("#voterButton").css("display", "none")

                params.set("show", "voter");
            } else {
                $("#candidate_container").css("display", "block")
                $("#voter_container").css("display", "none")
                $("#table-title").html("Candidates")
                $("#candidateButton").css("display", "none")
                $("#voterButton").css("display", "block")

                params.delete('show');
                params.delete('data');
            }

            url.search = params.toString();
            window.history.replaceState({}, '', url.href);
        }
    </script>
@endsection
