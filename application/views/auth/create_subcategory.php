<div class="container">
	<h1>Subcategory for <?=$category[0]->name?> </h1>

	<?php echo form_open("auth/create_subcategory/".$category[0]->id);?>

		  <p>
				Subcategory Name: <br />
				<?php echo form_input($subcategory_name);?>
		  </p>


		  <p><?php echo form_submit('submit', "Create New Subcategory");?></p>

	<?php echo form_close();?>

	<?=anchor("auth/subcategory_management/".$category[0]->id, "Back")?><br/>
</div>