<div class="question">
	<div class="row">
		<div class="col-md-2 ">Question <?=($index+1)?>:</div>
		<div class="col-md-4 text-left">
		<?= form_textarea(array('name'    => "questions[$index][0]",'rows'=>'5','required' => 'required') ); ?> 
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-10 text-left">
			Choices:
			<ul class="categories">
				<li>1) <?= form_input(array('name'    => "questions[$index][1][0]", 'required' => 'required')); ?> Correct: <?=form_checkbox("questions[$index][2][0]", 'correct', FALSE);?></li>
				<li>2) <?= form_input(array('name'    => "questions[$index][1][1]", 'required' => 'required')); ?> Correct: <?=form_checkbox("questions[$index][2][1]", 'correct', FALSE);?></li>
				<li>3) <?= form_input(array('name'    => "questions[$index][1][2]")); ?> Correct: <?=form_checkbox("questions[$index][2][2]", 'correct', FALSE);?></li>
				<li>4) <?= form_input(array('name'    => "questions[$index][1][3]")); ?> Correct: <?=form_checkbox("questions[$index][2][3]", 'correct', FALSE);?></li>
			</ul>
		</div>
	</div>
	<hr/>
</div>
