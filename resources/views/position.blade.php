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
                                <tr>
                                    <td>Sample</td>
                                    <td>Data</td>
                                    <td>Here</td>
                                    <td>
                                        {{-- TODO: Change data id --}}
                                        <button class="btn btn-primary btn-sm edit btn-flat" data-id="changer">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm delete btn-flat" data-id="chnage">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
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
                    <form action="#" method="POST" class="form-horizontal">
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
@endsection

@section('custom_script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

        })
    </script>
@endsection
