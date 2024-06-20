@extends('base.base')

@section("title")
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
                <h3>Votes Tally For Sample Election</h3>
                <span class="pull-right">
                    <a href="#" class="btn btn-success btn-sm btn-flat"><span
                            class="glyphicon glyphicon-print"></span> Print/Download PDF</a>
                </span>
            </div>
        </div>
        {{-- <div style="text-align: center">
            <h3>No Active Election</h3>
            <img src="images/sad.png" alt="" width="20%">
        </div> --}}
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h4 class="box-title"><b>Sample Position</b></h4>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="sample-data" style="height: 200px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('sample-data');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April'],
                    datasets: [{
                        axis: 'y',
                        label: 'My First Dataset',
                        data: [65, 59, 80, 81],
                        fill: false,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    }]
                }
            });
        });
    </script>
@endsection
