<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/ogranization-logo.png') }}">
    <title>{{ $election->title }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    </style>
</head>

<body class="hold-transition skin-blue">


    <header class="main-header">
        <span class="logo logo-lg"><b>Voting Ballot</span>
        <nav class="navbar navbar-static-top">
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ asset('images/userplaceholder.png') }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">Username</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-footer">
                                <div class="">
                                    <a href="/logout" class="btn btn-danger btn-flat">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="content">
        <div class="">
            <div class="election-title">
                <h3>{{ $election->title }}</h3>
            </div>
            <hr>
            <form method="GET" action="{{ route('ballot.cast', ['id' => $election->id, 'u_id' => Auth::user()->id]) }}">
                @csrf
                <input type="hidden" name="elid" id="elid" value="{{ $election->id }}">
                @foreach ($candidates as $key => $value)
                    <div class="candidate-container">
                        <h3>{{ $key }}</h3>
                        <div class="candidate-body">
                            @if ($max_vote[$key] == 1)
                                @foreach ($value as $v)
                                    <div class="candidate">
                                        <label for="{{ $key }}-{{ $v['c_id'] }}">
                                            <input type="radio" name="{{ $key }}" required
                                                id="{{ $key }}-{{ $v['c_id'] }}"
                                                value="{{ $v['c_id'] }}">{{ $v['c_name'] }}
                                        </label>
                                        <i class="fa fa-circle-info info" data-id="{{ $v['c_id'] }}"></i>
                                    </div>
                                @endforeach
                            @else
                                @foreach ($value as $v)
                                    <div class="candidate">
                                        <label for="{{ $key }}-{{ $v['c_id'] }}">
                                            <input type="checkbox" name="{{ $key }}[]"
                                                id="{{ $key }}-{{ $v['c_id'] }}"
                                                value="{{ $v['c_id'] }}">{{ $v['c_name'] }}
                                        </label>
                                        <i class="fa fa-circle-info info" data-id="{{ $v['c_id'] }}"></i>
                                    </div>
                                @endforeach
                                <script>
                                    document.querySelectorAll('input[name="{{ $key }}[]"]').forEach(function(checkbox) {
                                        checkbox.addEventListener('click', function() {
                                            console.log("hello world");

                                            var checkedCheckboxes = document.querySelectorAll(
                                                'input[name="{{ $key }}[]"]:checked');

                                            var disableOthers = checkedCheckboxes.length >= +`{{ $max_vote[$key] }}`;

                                            document.querySelectorAll('input[name="{{ $key }}[]"]').forEach(function(cb) {
                                                if (!cb.checked) {
                                                    cb.disabled = disableOthers;
                                                }
                                            });
                                        });
                                    });
                                </script>
                            @endif
                        </div>
                    </div>
                @endforeach
                <hr>
                <div class="ballot-footer">
                    <input type="checkbox" id="confirmed" name="confirmed" required>
                    <p>I agree that all the contents above are correct.</p>
                    <br>
                    <button class="btn btn-success btn-sm" type="submit"> Cast Vote!</button>
                </div>
            </form>
        </div>
    </div>



    <script>
        document.addEventListener("DOMContentLoaded", function() {});
    </script>


</body>

</html>
