<div class="container">
	<div class="content">
		<h1><?=$title?></h1>
		<ul class="categories">
			<?foreach($lectures as $l):?>
				<a href="index.php?/lectures/view_lecture/<?=$l->id?>"><li><?=$l->title?></li></a>
			<?endforeach;?>
		</ul>		
	</div>
</div>