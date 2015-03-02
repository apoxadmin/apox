<?php
/*
Template Name: Archive
*/
?>

<?php get_header(); ?>

<div id="content">

	<div id="contentleft">
    
        <div class="postarea">
    
    		<div class="posttitle">
				<h3><?php _e("Archives", 'organicthemes'); ?></h3>       
            </div>
				
				<div class="archive">
		
					<h5><?php _e("By Page:", 'organicthemes'); ?></h5>
						<ul>
							<?php wp_list_pages('title_li='); ?>
						</ul>
				
					<h5><?php _e("By Month:", 'organicthemes'); ?></h5>
						<ul>
							<?php wp_get_archives('type=monthly'); ?>
						</ul>
							
					<h5><?php _e("By Category:", 'organicthemes'); ?></h5>
						<ul>
							<?php wp_list_categories('sort_column=name&title_li='); ?>
						</ul>
		
				</div>
				
				<div class="archive">
					
					<h5><?php _e("By Post:", 'organicthemes'); ?></h5>
						<ul>
							<?php wp_get_archives('type=postbypost&limit=100'); ?> 
						</ul>
				</div>
			            
        </div>
		
	</div>
			
<?php include(TEMPLATEPATH."/sidebar_right.php");?>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>