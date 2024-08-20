@extends('base.base')

@section('page_name')
    Dashboard
@endsection

@section('title')
    Dashboard
@endsection

@section('main')
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>Count</h3>
                        <p>No. of Count</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-tasks"></i>
                    </div>
                    <a href="#" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>Count</h3>
                        <p>No. of Count</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-black-tie"></i>
                    </div>
                    <a href="#" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>Count</h3>
                        <p>No. of Count</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="#" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-maroon">
                    <div class="inner">
                        <h3>Count</h3>
                        <p>No. of Count</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-edit"></i>
                    </div>
                    <a href="#" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h3>Active Election</h3>
                <br>
            </div>
        </div>
        @if($elections->count() >= 1)
            <div class="box-body box">
                <table id="election" class="table table-bordered table-hover table-striped">
                    <thead style="background-color: #222D32; color:white;">
                        <th>Name</th>
                        <th>Scope</th>
                        <th>Progress</th>
                        <th style="width: 20%">Action</th>
                    </thead>
                    <tbody>
                        @foreach($elections as $e)
                        <tr>
                            <td>{{ $e->title }}</td>
                            @if($e->scope == 1) 
                                <td>University</td>
                            @elseif($e->scope == 2)
                                <td>{{ $e->college_name }}</td>
                            @else
                                <td>{{ $e->course_name }} - {{ ordinal($e->year_level_limit) }} Year</td>
                            @endif
                            <td>0</td>
                            <td>
                                <a href="{{ route('vote.show', ['id' => $e->id ]) }}" class="btn btn-primary btn-sm btn-flat">
                                    <i class="fa fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center">
                <h3>No Active Election</h3>
                <img src="images/sad.png" alt="" width="20%">
            </div>
        @endif
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $("#election").DataTable()
        });
    </script>
@endsection
