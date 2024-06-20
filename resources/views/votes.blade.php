@extends('base.base')

@section("title")
Votes
@endsection

@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <a href="#reset" data-toggle="modal" class="btn btn-danger btn-sm btn-flat">
                            <i class="fa fa-refresh"></i> Reset
                        </a>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-hover table-striped">
                            <thead style="background-color: #222D32; color:white;">
                                <th>Voter's Name</th>
                                <th>Candidate Voted For</th>
                                <th>Position</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Sample</td>
                                    <td>Data</td>
                                    <td>Votes</td>
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
    <div class="modal fade" id="reset">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4>Reseting...</h4>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <p>RESET VOTES</p>
                        <h4>This will delete all votes!</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
                        <i class="fa fa-close"></i> Close
                    </button>
                    <a href="#" class="btn btn-danger btn-flat">
                        <i class="fa fa-refresh">Reset</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
