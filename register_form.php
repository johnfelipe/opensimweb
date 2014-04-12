<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;
}
?>
	<form action="register.php" method="post">
		<input type="hidden" name="process" value="true" />
<div class="container">
 <div class="row">
  <div class="col-md-12">
   <div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-lock"></i> Register</div>
    <div class="panel-body">

	<div class="form-group">
		<label for="InputFirst" class="col-sm-3 control-label">Avatar First Name</label>
		<div class="col-sm-9">
		<input type="text" id="InputFirst" class="form-control" name="firstname" maxlength="100" value="" required />
		</div>
	</div>

	<div class="form-group">
		<label for="InputLast" class="col-sm-3 control-label">Avatar Last Name</label>
		<div class="col-sm-9">
		<input type="text" id="InputLast" class="form-control" name="lastname" maxlength="100" value="" required />
		</div>
	</div>

	<div class="form-group">
		<label for="InputPassword" class="col-sm-3 control-label">Password <font color="Red">*</font></label>
		<div class="col-sm-9">
		<input type="password" id="InputPassword" class="form-control" name="password" maxlength="<?php echo $osw->config['max_password']; ?>" required />
		</div>
	</div>

	<div class="form-group">
		<label for="InputCPassword" class="col-sm-3 control-label">Confirm Password <font color="Red">*</font></label>
		<div class="col-sm-9">
		<input type="password" id="InputCPassword" class="form-control" name="password_c" maxlength="<?php echo $osw->config['max_password']; ?>" required />
		</div>
	</div>

	<div class="form-group">
		<label for="InputEmail" class="col-sm-3 control-label">Email site_address</label>
		<div class="col-sm-9">
		<input type="text" id="InputEmail" class="form-control" name="email" maxlength="100" value="" required />
		</div>
	</div>
<?php
if ($osw->config['Default_Female'] != "" && $osw->config['Default_Male'] != "") {
?>
	<div class="form-group">
		<label for="InputAvi" class="col-sm-3 control-label">Default Avatar</label>
		<div class="col-sm-9">
			<input type="radio" id="InputAvi" name="avi" maxlength="100" value="f" required /> Female
			<input type="radio" id="InputAvi" name="avi" maxlength="100" value="m" required /> Male
		</div>
	</div>
<?php
}
/* START SECURITY IMAGE */
if ($osw->config['security_image'] == 'yes') {
?>
	<div class="form-group">
		<label for="InputRobotTest" class="col-sm-3 control-label">Are you human?</label>
		<div class="col-sm-9">
			<?php
			require_once('recaptchalib.php');
  			$publickey = $osw->config['ReCaptcha_Public_Key'];
  			echo recaptcha_get_html($publickey);
			?>
		</div>
	</div>
<?php
}
/* END SECURITY IMAGE */
?>
	<div class="form-group">
		<label for="Submit" class="col-sm-3 control-label"></label>
		<div class="col-sm-9">
		<input type="submit" id="Submit" value="Register" class="btn btn-primary" /><br>
		<br><small><font color="Red">*</font> Passwords MUST be <?php echo $osw->config['min_password']; ?> to <?php echo $osw->config['max_password']; ?> characters</small>
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
Don't worry it doesn't store your password. Just your uuid, the current time and your session id.<br>
For more information google Opensimweb.<br>
<br>
When registering you agree to our <a href='<?php echo $site_address; ?>/tos.php'>Terms of Service</a> and our <a href='<?php echo $site_address; ?>/privacypolicy.php'>Cookie and Privacy Policy</a><br>
We only require a valid email site_address at registration to confirm that you are human and not a spam bot.<br>
We wont email you anything else without your approval.<br>
We also will NOT sell or give your email site_address to any annoying spam company because we hate spam too.
</small>
</p>