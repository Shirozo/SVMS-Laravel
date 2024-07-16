<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/ogranization-logo.png') }}">
    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="hold-transition skin-blue">
    @include('base.navbar')
    <div class="content" style="background-color: #ecf0f5; min-height:900px">
        <section class="content-header">
            <a style="color:black" href="{{ route('elections.index') }}">
                <i class="fa fa-arrow-left fa-lg arrow-back"></i>
            </a>
            <h1 class="text-center">@yield('page_name')</h1>
            <ol class="breadcrumb">
                <li><a href="/"><i class="fa fa-dashboard"></i>Home</a></li>
                <li class="active">Election</li>
                <li class="active">Manage</li>
            </ol>
        </section>
        @yield('main')
    </div>

    @yield('modal')


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            $("#example1").DataTable()
        });
    </script>

    @yield('custom_script')

</body>

</html>
