<header class="main-header">
    <a href="#" class="logo">
        <span class="logo-mini">VMS</span>
        <span class="logo-lg"><b>Voting Management</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src='images/userplaceholder.png' class="user-image" alt="User Image">
                        <span class="hidden-xs">Username</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src='images/userplaceholder.png' class="img-circle" alt="User Image">
                            <p>
                                Username<small>Member since 2021 </small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#profile" data-toggle="modal" class="btn btn-primary btn-flat"
                                    id="admin_profile">Update</a>
                            </div>
                            <div class="pull-right">
                                <a href="{% url 'account_logout' %}" class="btn btn-danger btn-flat">Logout</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>


<div class="modal fade" id="profile">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Admin Profile</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST"
                    action="profile_update.php?return={% url 'adminDashboard' %}" enctype="multipart/form-data">

                    <!-- Form For Update Goes Here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-success btn-flat" name="save"><i
                        class="fa fa-check-square-o"></i> Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
