

<div class="container">
	<div class="content">
		<h1>Lectures:</h1>

		<div class="row">
		<?foreach($categories as $category):?>
			<div class="col-md-3">
				<h3><?=$category['name']?></h3>
				<ul class="categories">
					<?foreach($category['subcategories'] as $subcategory):?>
						<a href="index.php?/lectures/view_lectures/<?=$subcategory->id?>"><li class="subcategory"><?=$subcategory->name?></li></a>
					<?endforeach;?>
				</ul>
			</div>	
		<?endforeach;?>
		</div>
		<hr/>
		<?if($canCreate):?>
			<a href="index.php?/lectures/create_lecture"><input type="button" value="Create a Lecture"/></a>
		<?endif;?>
	</div>
	
	
</div>
