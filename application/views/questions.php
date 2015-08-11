

<div class="container">
	<div class="content">
		<h1>Quizzes:</h1>

		<div class="row">
		<?foreach($categories as $category):?>
			<div class="col-md-3">
				<h3><?=$category['name']?></h3>
				<ul class="categories">
					<?foreach($category['subcategories'] as $subcategory):?>
						<a href="index.php?/questions/view_questions/<?=$subcategory->id?>"><li class="subcategory"><?=$subcategory->name?></li></a>
					<?endforeach;?>
				</ul>
			</div>	
		<?endforeach;?>
		</div>
		<hr/>
		<?if($canCreate):?>
			<a href="index.php?/questions/create_question"><input type="button" value="Create a Quiz"/></a>
		<?endif;?>
	</div>
	
	
</div>
