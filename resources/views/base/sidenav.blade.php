<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="images/userplaceholder.png" class="img-cicle" alt="">
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
            <li>
                <a href="{{ route('votes') }}"><i class="glyphicon glyphicon-lock"></i><span>Votes</span></a>
            </li>

            <li class="header">MANAGE</li>
            <li>
                <a href="{{ route('college.index') }}"><i class="fa fa-university"></i><span>Colleges</span></a>
            </li>
            <li>
                <a href="{{ route('courses.index') }}"><i class="fa fa-graduation-cap"></i><span>Courses</span></a>
            </li>
            <li>
                <a href="{{ route('voters.index') }}"><i class="fa fa-users"></i><span>Voters</span></a>
            </li>
            <li>
                <a href="{{ route('positions.index') }}"><i class="fa fa-tasks"></i><span>Positions</span></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-black-tie"></i><span>Election</span></a>
            </li>
            <li class="header">COMMITTEE</li>
            <li>
                <a href="#"><i class="fa fa-user"></i><span>Committee</span></a>
            </li>
            <li class="header">SETTINGS</li>
            <li>
                <a href="#"><i class="fa fa-file-text"></i><span>Ballot Position</span></a>
            </li>
            <li class="header">EXIT</li>
            <li>
                <a href="/logout"><i class="fa fa-power-off"></i><span>Logout</span></a>
            </li>
        </ul>
    </section>
</aside>
