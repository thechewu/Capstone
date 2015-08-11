$(document).ready(function(){
	// ENTIRE SITE
	$(".content").slideDown("fast");
	
	$(".active a").css("background-color","#03a9f4");
	
	$( ".active a" ).animate({
		backgroundColor: '#0277bd',
		}, 500, function() {
	});
	
	// CREATE A QUIZ SECTION
	var questionIndex = 1;
	$("#question_remove").hide();
	// Performs an ajax call, which creates a new question form and adds it to the page
	$("#question_add").click(function(){		
		$.post("index.php?/questions/create_new_question_string/"+questionIndex,"",function(data){
			if(typeof data !== "undefined"){
				$($(".question").last()).after(data);
				var last = $(".question").last();
				last.hide();
				last.slideDown();
				questionIndex++;
				if($(".question").size() > 1){
					$("#question_remove").fadeIn("fast");
				}
			}else{
				console.log("bad happened");
			}
		});
	});
	// Removes last added question
	$("#question_remove").click(function(){	
		if($(".question").size() > 1){
			$(".question").last().slideUp(function(){
				$(this).remove();
				questionIndex--;
				if($(".question").size() <= 1){
					$("#question_remove").fadeOut("fast");
				}
			});
			
		}
	});	
});