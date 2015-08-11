<div class="container">
	<div class="content">
	<h1><?=$lecture->title?></h1>
	<span class="publish-info">Created on <?=$lecture->date_created?> by <?=$this->ion_auth->user($lecture->creator)->row()->username?></span>
	
	<br/>
	
	<?=$lecture->content?>
	</div>
</div>