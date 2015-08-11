<h1>New Category</h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/create_category");?>

      <p>
            Category Name: <br />
            <?php echo form_input($category_name);?>
      </p>


      <p><?php echo form_submit('submit', "Create New Category");?></p>

<?php echo form_close();?>

<?=anchor("auth/category_management", "Back")?><br/>