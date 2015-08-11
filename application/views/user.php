

<div class="container">
	<div id="picture-modal">
		<div class="content">
			<span id="close-picture-modal" class="glyphicon glyphicon-remove"></span>
			<?= form_open_multipart('user/change_profile_picture');?>  
			Please select an image:
			<?= form_input(array('name'    => 'userfile','size' => '20','type' => 'file'  ,'required'=>'required')); ?> 
			<br/>
			<?= form_submit('upload', 'Upload' ); ?> 
			<?= form_close(); ?> 
		</div>
	</div>
	<div class="content">
		<img class="user-profile" src="userimg/<?=$this->ion_auth->user()->row()->image?>"/>
		<h1 class="user-name"><?=$this->ion_auth->user()->row()->first_name." ".$this->ion_auth->user()->row()->last_name?></h1>
		<br/>
		<a id="edit_picture" href="#">Edit profile picture</a>
		<hr/>
		<h2>Quiz history</h2>
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th>Quiz Name</th>
					<th>Question</th>
					<th>Answer</th>
					<th>Correct</th>
					<th>Date</th>
				</tr>
				<?foreach($history as $entry):?>
				<tr>
					<td><?=$entry->quiz?></td>
					<td><?=$entry->question?></td>
					<td><?=$entry->answer?></td>
					<td><?=($entry->correct ? 'Yes' : 'No')?></td>
					<td><?=date('d-M-Y',strtotime($entry->date))?></td>
				</tr>
				<?endforeach;?>
			</table>
			
		</div>
		<div style="width:100%; text-align:center">
			<span id="load_more" class="glyphicon glyphicon-eject" aria-hidden="true"></span>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$("#edit_picture").click(function(){
			$("#picture-modal").slideDown("fast");
		});
		$("#close-picture-modal").click(function(){
			$("#picture-modal").slideUp("fast");
		});
		var rowCount = $("tr").length
		var current = 1;
		for(var i=1;i<rowCount;i++) $("tr:eq("+i+")").hide();
		
		showRows(current,Math.min(current+=10,rowCount));
		// Onclick button animation (rotation)
		$("#load_more").click(function(){
		   $(this).animate({ borderSpacing: 540 }, {
			start:function(){
				$(this).css("transition","all 0.2s linear");
			},
            step: function (now, fx) {
                $(this).css('-webkit-transform', 'rotate(' + now + 'deg)');
                $(this).css('-moz-transform', 'rotate(' + now + 'deg)');
                $(this).css('transform', 'rotate(' + now + 'deg)');
            },
            duration: 'fast',
			done:function(){
				showRows(current,Math.min(current+=10,rowCount));
				if(current>=rowCount)($(this).hide());
				$(this).css("transition","none");				
				$(this).css('-webkit-transform', 'rotate(180deg)');
				$(this).css('-moz-transform', 'rotate(180deg)');
				$(this).css('transform', 'rotate(180deg)');		
			}},
			'linear');
			
		
		});
	});
	// Reveals additional history
	function showRows(start,end){
		for(var i=start;i<end;i++){
				$("tr:eq("+i+")").fadeIn("slow");
		}
		$("html, body").scrollTop($(document).height());	
	}
</script>