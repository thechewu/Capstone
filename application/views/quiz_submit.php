<div class="container">
	<div class="content">	
	<h1>Results:</h1>
	You have answered correctly <?=$correct?> out of <?=$num?> questions.
	<br/>
	Your score is <?=($correct/$num)*100?>%!
	<br/>
	<br/>
	<a href="index.php?/questions/view_quiz/<?=$quizId?>"><input type="button" value="Retry"/></a>
	
	</div>
</div>