@extends('base.electionbase')

@section('title')
    Votes
@endsection

@section('action')
    Result
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
                        <i class="fa fa-tasks"></i>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>Voted</h3>
                        <p>No. of Count</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-maroon">
                    <div class="inner">
                        <h3>Canidates</h3>
                        <p>No. of Count</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                        <br>
                    </div>
                </div>
            </div>
            <div class="result-container">
                <div class="col-xs-12 result-left">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3>Live Result</h3>
                        </div>
                        <div class="result-chart">
                            @foreach ($new_data as $key => $nd)
                                <div class="chart-container" style="position: relative; height:40vh; width:80vw">
                                    <canvas id="{{ $key }}" height="250px"></canvas>
                                </div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", async function() {
                                        const ctx = document.getElementById('{{ $key }}');
                                        const labels = @json(array_map(fn($item) => $item['c_name'], $nd));
                                        const data = @json(array_map(fn($item) => $item['c_votes'], $nd));

                                        new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                                labels: labels,
                                                datasets: [{
                                                    axis: 'y',
                                                    label: '{{ $key }}',
                                                    data: data,
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
                                    })
                                </script>
                            @endforeach
                        </div>

                    </div>
                </div>
                <div class="col-xs-12 result-right">
                    <div class="box" style="padding: 1% 1%">
                        <div class="box-header with-border">
                            <h3>Leaderboard</h3>
                        </div>
                        <div class="result-container">
                            <table class="table">
                                <thead>
                                    <th>Position</th>
                                    <th>Candidate</th>
                                    <th>Vote</th>
                                </thead>
                                <tbody>
                                    @foreach ($highest as $h => $data)
                                        <tr>
                                            <td>{{ $h }}</td>
                                            @if ($highest[$h]['votes'] > 0)
                                                <td>{{ $highest[$h]['name'] }}</td>
                                                <td>{{ $highest[$h]['votes'] }}</td>
                                            @else
                                                <td>None</td>
                                                <td>None</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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

@section('custom_script')
    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            const ctx = document.getElementById('sample-data');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['January', 'February'],
                    datasets: [{
                        axis: 'y',
                        label: 'My First Dataset',
                        data: [65, 59],
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
        })
    </script>
@endsection
