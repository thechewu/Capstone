<div class="container">
	<div class="content">
		<h1><?=$title?></h1>
		<ul class="categories">
			<?foreach($questions as $q):?>
				<a href="index.php?/questions/view_quiz/<?=$q->id?>"><li><?=$q->title?></li></a>
			<?endforeach;?>
		</ul>		
	</div>
</div>