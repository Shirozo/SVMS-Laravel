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
        .bold{
          font-weight:bold;
        }

        #candidate_list{
          margin-top:20px;
        }

        #candidate_list ul{
          list-style-type:none;
        }

        #candidate_list ul li{
          margin:0 30px 30px 0;
          vertical-align:top
        }

        .clist{
          margin-left: 20px;
        }

        .cname{
          font-size: 25px;
        }
      </style>
</head>

<body>
    @include("base.sidenav")

    <div class="container">
        @yield('main')
    </div>

</body>

</html>
