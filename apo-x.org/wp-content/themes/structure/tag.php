<?php get_header(); ?>

<div id="content">

	<div id="contentleft">
    
		<div class="postarea">
	
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            <h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
            
                <div class="postauthor">
            
            		<p><?php _e("Posted by", 'structuretheme'); ?> <?php the_author_posts_link(); ?> <?php _e("on", 'structuretheme'); ?> <?php the_time('F j, Y'); ?> &middot; <a href="<?php the_permalink(); ?>#comments"><?php comments_number('Leave a Comment', '1 Comment', '% Comments'); ?></a>&nbsp;<?php edit_post_link('(Edit)', '', ''); ?></p>
                    
                </div>
                
			<!--The tag page is currently using the Limit Post funtion and is currently set to display 450 characters. You can increase this or decreas it as you wish.-->
            
            <?php the_content_limit(450, "Read More"); ?><div style="clear:both;"></div>
            
			<div class="postmeta">
				<p><?php _e("Filed under", 'structuretheme'); ?> <?php the_category(', ') ?> &middot; <?php _e("Tagged with", 'structuretheme'); ?> <?php the_tags('') ?></p>
			</div>
            		
			<?php endwhile; else: ?>
                    
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
            <p><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?></p>
        
        </div>
	
	</div>
			
	<?php include(TEMPLATEPATH."/sidebar_right.php");?>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>