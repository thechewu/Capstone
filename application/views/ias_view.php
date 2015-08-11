<div class="container">
	<div class="content">
		<h1>Welcome to IAS Module!</h1>
		<p>IAS stands for Intelligent Assessment System, which aims to provide you with material suitable for your level of knowledge in a specific area</p>
		<p>To begin, select any of the subcategories from the list below:</p>
		<hr/>
		<div class="row">
		<?foreach($categories as $category):?>
			<div class="col-md-3">
				<h3><?=$category['name']?></h3>
				<ul class="categories">
					<?foreach($category['subcategories'] as $subcategory):?>
						<a href="index.php?/ias/start_assessment/<?=$subcategory->id?>"><li class="subcategory"><?=$subcategory->name?></li></a>
					<?endforeach;?>
				</ul>
			</div>	
		<?endforeach;?>
		</div>
	</div>
</div>
