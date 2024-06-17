@extends('base.login-base')

@section('login')
    <div class="log-container">
        <div class="log-box-main">
            <div class="data-left">
                <div style="text-align: center;">
                    <div class="logos">
                        <img src='images/school-logo.png' alt="ESSU Logo" class="logo-layout essu-logo">
                        <img src="images/ogranization-logo.png" alt="LUG Logo" class="logo-layout lug-logo">
                    </div>
                    <b class="login-title" style="color: white; text-shadow: 4px 4px #000;">STUDENT VOTING SYSTEM</b>
                </div>
            </div>
            <div class="data-right">
                <b class="login-title">Log In Your Account and Vote Now!</b>
                <div class="form-container">
                    <form action="/login" method="POST" class="input-width">
                        @csrf
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control custom-background" name="email"
                                placeholder="Email" required>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" class="form-control custom-background" name="password"
                                placeholder="Password" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-success btn-block btn-flat custom-success"
                                    name="login"><i class="fa fa-sign-in"></i> Log In</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="credits">
                    <b> &copy </b><a href="https://github.com/Linux-User-Group-ESSU">Linux Users Group</a>
                </div>
            </div>
        </div>
    </div>

@endsection
