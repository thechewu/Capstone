<div class="container">
	<h1>Categories</h1>
	<table class="table">
	<?foreach($categories as $c):?>
		<tr>
		<td><?=$c->name?></td>
		<td><?=anchor("auth/subcategory_management/".$c->id, "Subcategories")?></td>
		<td><?=$c->active ? anchor("auth/deactivate_category/".$c->id, "Disable") : anchor("auth/activate_category/".$c->id, "Enable")?></td>
		</tr>
	<?endforeach;?>
	</table>
	<br/>
	<?=anchor("auth/create_category", "New Category")?><br/>
	<?=anchor("auth/index", "Back")?><br/>
</div>