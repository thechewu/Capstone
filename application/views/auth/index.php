<div class="container">
	<h1><?php echo lang('index_heading');?></h1>
	<?if(isset($message)) echo $message;?>
	<?php echo anchor("auth/user_management", 'Manage Users') ;?>
	<br/>
	<?php echo anchor("auth/category_management", 'Manage Categories') ;?>
</div>
