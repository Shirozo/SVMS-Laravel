<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="images/ogranization-logo.png">
    <title>Elections</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="hold-transition skin-blue">
    @include('base.election-navbar')
    <div class="content" style="background-color: #ecf0f5; min-height:900px">
        <section class="content-header">
            <h1 class="text-center">Elections</h1>
            <ol class="breadcrumb">
                <li><a href="/"><i class="fa fa-dashboard"></i>Home</a></li>
                <li class="active">Election</li>
                <li class="active">@yield('action')</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-hover table-striped">
                                <thead style="background-color: #222D32; color:white;">
                                    <th>Name</th>
                                    <th style="width: 40%">Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($elections as $e)
                                        <tr>
                                            <td>{{ $e->title }}</td>
                                            <td>
                                                <a href="{{ route('ballot.show', ['id' => $e->id]) }}" class="btn btn-sm btn-primary btn-flat"><i
                                                        class="fa fa-pen-nib"></i> Vote</a>
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
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $("#example1").DataTable()
        })
    </script>
</body>

</html>
