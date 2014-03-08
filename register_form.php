<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;
}
?>
<fieldset>
	<legend>
		Register
	</legend>
	<form action="register_process.php" method="post">
		<input type="hidden" name="process" value="true" />
<div class="container">
 <div class="row">
  <div class="col-md-6">
   <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-lock"></i> Register</div>
    <div class="panel-body">
	<div class="form-group">
		<label for="InputUsername" class="col-sm-3 control-label">Website Username</label>
		<div class="col-sm-9">
		  <input type="text" id="InputUsername" name="username" maxlength="" value="" required />
		</div>
	</div>
	<div class="form-group">
		<label for="InputFirst" class="col-sm-3 control-label">Avatar First Name</label>
		<div class="col-sm-9">
		<input type="text" id="InputFirst" name="firstname" maxlength="100" value="" required />
		</div>
	</div>
	<div class="form-group">
		<label for="InputLast" class="col-sm-3 control-label">Avatar Last Name</label>
		<div class="col-sm-9">
		<input type="text" id="InputLast" name="lastname" maxlength="100" value="" required />
		</div>
	</div>
	<div class="form-group">
		<label for="InputPassword" class="col-sm-3 control-label">Password</label>
		<div class="col-sm-9">
		<input type="password" id="InputPassword" name="password" maxlength="<?php echo $qls->config['max_password']; ?>" required />
			<?php echo $qls->config['min_password']; ?> - <?php echo $qls->config['max_password']; ?> characters
		</div>
	</div>
	<div class="form-group">
		<label for="InputCPassword" class="col-sm-3 control-label">Confirm Password</label>
		<div class="col-sm-9">
		<input type="password" id="InputCPassword" name="password_c" maxlength="<?php echo $qls->config['max_password']; ?>" required />
		</div>
	</div>
	<div class="form-group">
		<label for="InputEmail" class="col-sm-3 control-label">Email Address></label>
		<div class="col-sm-9">
		<input type="text" id="InputEmail" name="email" maxlength="100" value="" required />
		</div>
	</div>
<?php
/* START SECURITY IMAGE */
if ($osw->config['security_image'] == 'yes') {
?>
	<div class="form-group">
		<label for="InputRobotTest" class="col-sm-3 control-label">Are you human?</label>
		<div class="col-sm-9">
			Recaptcha here
		</div>
	</div>
<?php
}
/* END SECURITY IMAGE */
?>
	<div class="form-group">
		<label for="Submit" class="col-sm-3 control-label"></label>
		<div class="col-sm-9">
		<input type="submit" id="Submit" value="Register" class="btn btn-primary" />
		</div>
	</div>
    </div>
<div class="panel-footer">Already Registred? <a href="<?php echo $site_address; ?>/login.php">Login here</a></div>
   </div>
  </div>
 </div>
</div>
	</form>
<p>
<small>
This website uses cookies to store login information so the system knows its you without forcing you to login all the time.<br>
By registering you agree to allow this site place a cookie on your computer.<br>
Don't worry it doesn't store your password. Just your id number, the time and your session id.<br>
For more information go google Opensimweb.<br>
<br>
When registering you agree to our <a href='<?php echo $address; ?>/tos.php'>Terms of Service</a> and our <a href='<?php echo $address; ?>/privacypolicy.php'>Cookie and Privacy Policy</a><br>
We only require a valid email address at registration to confirm that you are human and not a spam bot.<br>
We wont email you anything else without your approval.<br>
We also will NOT sell or give your email address to any annoying spam company because we hate spam too.
</small>
</p>
</fieldset>