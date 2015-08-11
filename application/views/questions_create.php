<div class="container">
	<div class="content">
	<h1>Create a Quiz</h1>
	<br/>
		<?php echo form_open("questions/create_question");?>
		<?if($success){?>
		<div class="alert alert-success alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		  Quiz created successfully.
		</div>
		<?}?>
		<div class="row">
			<div class="col-md-2 ">Title:</div>
			<div class="col-md-4 text-left">
			<?= form_input(array('name'    => 'title', 
											'size'    => 30,
											'required' => 'required') ); ?> 
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-2 ">Category:</div>
			<div class="col-md-4 text-left">
			<?=form_dropdown('subcategories', $subcategories);?>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-2 ">Level:</div>
			<div class="col-md-4 text-left">
			<?=form_dropdown('level', $levels);?>
			</div>
		</div>
		
		<hr/>
		<?
		$index = 0;
		include 'new_question.php';
		?>
		
		<div class="row">
			<div class="col-md-12">
				<div class="question-add-new" id="question_add">+</div>
				<div class="question-add-new" id="question_remove">-</div>
				
			</div>
		</div>
		<!--
		<div class="row">
			<div class="col-md-2 ">Content:</div>	
		</div>
		
		<div class="row">				
			<div class="col-md-12">
			<?=  form_textarea(array('class' => 'ckeditor', 'name' => 'content'))  ?> 
			</div>
		</div>
		-->
		<br/>
		<?php echo form_submit('submit', "Create");?>

	<?php echo form_close();?>
	</div>
</div>