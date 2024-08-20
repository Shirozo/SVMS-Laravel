<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('images/userplaceholder.png') }}" class="img-cicle" alt="">
            </div>
            <div class="pull-left info">
                <p>Sample username</p>
                <a><i class="fa fa-circle text-success"></i></a>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">REPORT</li>
            <li>
                <a href="/"><i class="fa fa-dashboard"></i><span>Dasboard</span></a>
            </li>
            <li class="header">MANAGE</li>
            <li>
                <a href="{{ route('voters.index') }}"><i class="fa fa-users"></i><span>Voters</span></a>
            </li>
            @if (Auth::user()->user_type == 1)
                <li>
                    <a href="{{ route('college.index') }}"><i class="fa fa-university"></i><span>Colleges</span></a>
                </li>
                <li>
                    <a href="{{ route('courses.index') }}"><i class="fa fa-graduation-cap"></i><span>Courses</span></a>
                </li>
                <li>
                    <a href="{{ route('positions.index') }}"><i class="fa fa-tasks"></i><span>Positions</span></a>
                </li>
            @endif
            <li>
            <li>
                <a href="{{ route('elections.index') }}"><i class="fa-brands fa-black-tie"></i><span>Election</span></a>
            </li>
            @if (Auth::user()->user_type == 1)
                <li class="header">COMMITTEE</li>
                <li>
                    <a href="{{ route('committee.show') }}"><i class="fa fa-user"></i><span>Committee</span></a>
                </li>
            @endif
            <li class="header">EXIT</li>
            <li>
                <a href="/logout"><i class="fa fa-power-off"></i><span>Logout</span></a>
            </li>
        </ul>
    </section>
</aside>
