<div class="container">
	<div class="content">
		<h1><?php echo lang('login_heading');?></h1>
		<p><?php echo lang('login_subheading');?></p>

		<div id="infoMessage"><?php echo $message;?></div>
		<br/>
		<?php echo form_open("auth/login");?>

		  
		  <div class="row">
			<div class="col-md-2">
			<?php echo lang('login_identity_label', 'identity');?>
			</div>
			<div class="col-md-4">
			<?php echo form_input($identity);?>
			</div>
			<div class="col-md-8"></div>
		  </div>

		  <div class="row">
			<div class="col-md-2"><?php echo lang('login_password_label', 'password');?></div>
			<div class="col-md-4"><?php echo form_input($password);?></div>
			<div class="col-md-2"></div>
		  </div>

		  <div class="row">
			<div class="col-md-2"><?php echo lang('login_remember_label', 'remember');?></div>
			<div class="col-md-2"><?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?></div>
			<div class="col-md-2"></div>
		  </div>

		<br/>
		  <p><?php echo form_submit('submit', lang('login_submit_btn'));?></p>

		<?php echo form_close();?>
		
		<p><a href="index.php?/auth/forgot_password"><?php echo lang('login_forgot_password');?></a></p>
	</div>
</div>