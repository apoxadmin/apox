<?php get_header(); ?>

<div id="content">

	<div id="contentleft" class="narrowcolumn">
    
		<!-- This sets the $curauth variable -->
        
		<?php
		
			if(isset($_GET['author_name'])) :
			$curauth = get_userdatabylogin($author_name);
			else :
			$curauth = get_userdata(intval($author));
			endif;
			
		?>
        
		<div class="posttitle">
			<h3><?php echo $curauth->display_name; ?></h3>
        </div>
        
        <p><?php if(function_exists('get_avatar')) { echo get_avatar($author, '120'); } ?></p>
		<p><strong><?php _e("Website:", 'organicthemes'); ?></strong> <a href="<?php echo $curauth->user_url; ?>" rel="bookmark" target="_blank"><?php echo $curauth->user_url; ?></a></p>
		<p><strong><?php _e("Profile:", 'organicthemes'); ?></strong> <?php echo $curauth->user_description; ?></p>
		<h5><?php _e("Posts by", 'organicthemes'); ?> <?php echo $curauth->display_name; ?>:</h5>
        
		<ul>
        
		<!– The Loop –>
        
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<li>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
				<?php the_title(); ?></a>
			</li>
			<?php endwhile; else: ?>
			<p><?php _e('No posts by this author.'); ?></p>
			<?php endif; ?>
            
		<!– End Loop –>
        
		</ul>
        
	</div>
			
	<?php include(TEMPLATEPATH."/sidebar_right.php");?>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>