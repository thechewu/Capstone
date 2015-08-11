<div class="container">
	<div class="content">
	<?=form_open("questions/submit_quiz/".$quizId);?>
	
	<h1><?=$title[0]->title?></h1>

	<?$i=1;?>
	
	<?foreach($questions as $question):?>
		<h2><?=($i++).'. '.$question['q']->title?></h2>
		<ul>
		<?foreach($question['a'] as $answer):?>
			<li><?=form_radio($question['q']->id,$answer->id,FALSE)?> <?=$answer->answer?> </li>
		<?endforeach;?>
		</ul>
	<?endforeach;?>
	<br/>
	<?php echo form_submit('submit', "Submit");?>

	<?php echo form_close();?>
	</div>
</div>