<?php get_header(); ?>

<div id="content">

	<?php include(TEMPLATEPATH."/sidebar_left.php");?>

	<div id="contentarchive">

		<div class="postarea">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>

                <div class="postauthor">
            		<p><?php _e("Posted by", 'organicthemes'); ?> <?php the_author_posts_link(); ?> on <?php the_time('F j, Y'); ?> &middot; <a href="<?php the_permalink(); ?>#comments"><?php comments_number('Leave a Comment', '1 Comment', '% Comments'); ?></a>&nbsp;<?php edit_post_link('(Edit)', '', ''); ?></p>      
                </div>

			<!--The archive page is currently using the Limit Post funtion and is currently set to display 480 characters. You can increase or decrease it as you wish.-->

            <?php the_content_limit(480, "Read More"); ?><div style="clear:both;"></div>   

			<div class="postmeta">
				<p><?php _e("Filed under", 'organicthemes'); ?> <?php the_category(', ') ?> &middot; <?php _e("Tagged with", 'organicthemes'); ?> <?php the_tags('') ?></p>
			</div>

			<?php endwhile; else: ?>         
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
            
            <div id="prevLink"><p><?php previous_posts_link(); ?></p></div>
			<div id="nextLink"><p><?php next_posts_link(); ?></p></div>

        </div>

	</div>

	<?php include(TEMPLATEPATH."/sidebar_right.php");?>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>