<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="images/ogranization-logo.png">
    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .bold {
            font-weight: bold;
        }

        #candidate_list {
            margin-top: 20px;
        }

        #candidate_list ul {
            list-style-type: none;
        }

        #candidate_list ul li {
            margin: 0 30px 30px 0;
            vertical-align: top
        }

        .clist {
            margin-left: 20px;
        }

        .cname {
            font-size: 25px;
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        @include('base.navbar')

        @include('base.sidenav')

        <div class="content-wrapper">
            <section class="content-header">
                <h1>VMS</h1>
                <ol class="breadcrumb">
                    <li><a href="/"><i class="fa fa-dashboard"></i>Home</a></li>
                    <li class="active">Page Title</li>
                </ol>
            </section>
            @yield('main')
        </div>
    </div>

    @yield("modal")


<script>
    document.addEventListener("DOMContentLoaded", function() {

        $("#example1").DataTable()

        var url = window.location;

        // for sidebar menu entirely but not cover treeview
        $('ul.sidebar-menu a').filter(function() {
            return this.href == url;
        }).parent().addClass('active');

        // for treeview
        $('ul.treeview-menu a').filter(function() {
            return this.href == url;
        }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');
    });
</script>

@yield('custom_script')

</body>

</html>
