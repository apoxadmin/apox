
/*

*/


$tooltip =  jQuery.noConflict();
$tooltip(function(){
				  
$tooltip(".social-icons li a").each(function(){
										  
										$ti = $tooltip(".social-icons a").attr("title");
										
										$tooltip(".scoial-icons a").attr("data-original-title" , $ti);
										  });
});