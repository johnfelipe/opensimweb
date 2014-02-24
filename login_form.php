<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;
}
?>
<form class="form-horizontal" role="form" action="login_process.php" method="post">
 <input type="hidden" name="process" value="true" />
<style>
.panel-default {
opacity: 0.9;
margin-top:30px;
}
.form-group.last { margin-bottom:0px; }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-lock"></i> Login</div>
                <div class="panel-body">

                    <div class="form-group">
                        <label for="inputUsername" class="col-sm-3 control-label">
                            Username<br><small>or email</small></label>
                        <div class="col-sm-9">
                            <input type="text" name="username" class="form-control" id="inputUsername" placeholder="Username or Email address" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-3 control-label">
                            Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" maxlength="<?php echo $osw->config['max_password']; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" value="1" />
                                    Remember me
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group last">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-success btn-sm">
                                Sign in</button>
                                 <button type="reset" class="btn btn-default btn-sm">
                                Reset</button>
                        </div>
                    </div>

                </div>
                <div class="panel-footer">
Not Registred? <a href="<?php echo $site_address; ?>/register.php">Register here</a><br>
</div>
            </div>
        </div>
    </div>
</div>
<small>
This website uses cookies to store login information so the system knows its you without forcing you to login all the time.<br>
By logging in you agree to allow this site place a cookie on your computer.<br>
Don't worry it doesn't store your password. Just a unique id and your session id.<br>
For more information go google Quadodo Login Script.
</small>
</form>