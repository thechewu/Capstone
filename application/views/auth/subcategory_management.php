<div class="container">
	<h1>Subcategories for <?=$category[0]->name?></h1>
	<table class="table">
	<?foreach($categories as $c):?>
		<tr>
			<td><?=$c->name?></td>
			<td><?=$c->active ? anchor("auth/deactivate_subcategory/".$c->id, "Disable") : anchor("auth/activate_subcategory/".$c->id, "Enable")?></td>

		</tr>
	<?endforeach;?>
	</table>
	<?=anchor("auth/create_subcategory/".$category[0]->id, "New Subcategory")?><br/>
	<?=anchor("auth/category_management", "Back")?><br/>
</div>