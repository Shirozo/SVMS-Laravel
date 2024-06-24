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
                                <tr>
                                    <td>
                                        {{-- TODO: Change HREF --}}
                                        <a href="#" style="text-decoration: none;color:black;">
                                            Election name
                                        </a>
                                    </td>
                                    <td>Data</td>
                                    <td>
                                        {{-- TODO: Change data-id --}}
                                        <a href="#deletemodal" data-toggle="modal"
                                            class="btn btn-danger btn-sm delete btn-flat" data-id="elec_id here"
                                            data-name="elec_name">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                        {{-- TODO: Do logic on which to show --}}
                                        <a href="#startmodal" data-toggle="modal"
                                            class="btn btn-success btn-sm start btn-flat" data-id="elec_id_here"
                                            data-name="elec_name">
                                            <i class="fa fa-play"></i> Start
                                        </a>
                                        <a href="#stopmodal" data-toggle="modal" class="btn btn-danger btn-sm stop btn-flat"
                                            data-id="elec_id_here" data-name="elec_name">
                                            <i class="fa fa-stop"></i> Stop
                                        </a>
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
                    <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="#">


                        <div class="modal-body">
                            <div class="form-group has-feedback">
                                <span class="text-danger"></span>
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
