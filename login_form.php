<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;
}

$err = $osw->Security->make_safe($_GET['err']);

if ($err == "invalidcreds") {
    $csshaserror = "has-error";
    $csser = "inputError1";
    echo "<div class='alert alert-danger'>Your username and/or password are not correct.</div>";
}else if ($err == "unable2process") {
    $csshaserror = "has-error";
    $csser = "inputError1";
    echo "<div class='alert alert-danger'>Unable to log you in at this time. Please try again later.</div>";
}else{
    $csshaserror = "";
    $csser = "";
}
?>
<form class="form-horizontal" role="form" action="login_process.php" method="post">
 <input type="hidden" name="process" value="true" />
 <input type="hidden" name="lastpage" value="<?php echo $lastpage; ?>" />
<style>
.panel-default {
opacity: 0.9;
margin-top:30px;
}
.form-group.last { margin-bottom:0px; }
</style>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-lock"></i> Login</div>
                <div class="panel-body">

                    <div class="form-group <?php echo $csshaserror; ?>">
                        <label for="inputUsername <?php echo $csser; ?>" class="col-sm-3 control-label">
                            FirstName LastName</label>
                        <div class="col-sm-9">
                            <input type="text" name="username" class="form-control" id="inputUsername <?php echo $csser; ?>" placeholder="FirstName LastName" required>
                        </div>
                    </div>
                    <div class="form-group <?php echo $csshaserror; ?>">
                        <label for="inputPassword <?php echo $csser; ?>" class="col-sm-3 control-label">
                            Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="password" class="form-control" id="inputPassword <?php echo $csser; ?>" placeholder="Password" maxlength="<?php echo $osw->config['max_password']; ?>" required>
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
                    Not Registred? <a href="<?php echo $site_address; ?>/register.php">Register here</a>
                </div>
            </div>
<small>
This website uses cookies to store login information so the system knows its you without forcing you to login all the time.<br>
By logging in you agree to allow this site place a cookie on your computer.<br>
Don't worry it doesn't store your password. Just your uuid, session id and the time in unix format.<br>
</small>
</form>