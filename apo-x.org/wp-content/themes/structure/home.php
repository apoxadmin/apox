<?php get_header(); ?>

<div id="content">

	<div id="homepagetop">
        
        <div class="textbanner">
			<?php $recent = new WP_Query("cat=" .ot_option('hp_top_cat'). "&showposts=1"); while($recent->have_posts()) : $recent->the_post();?>
            <h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
            <?php endwhile; ?>
        </div>
        
        <div id="homeslider">
        	<ul id="slider1">
				<?php $recent = new WP_Query("cat=" .ot_option('slider_cat'). "&showposts=" .ot_option('slider_num') ); while($recent->have_posts()) : $recent->the_post();?>
                <?php $meta_box = get_post_custom($post->ID); $video = $meta_box['custom_meta_video'][0]; ?>
                <li>
                    <?php if ( $video ) : ?>
                        <div class="feature_video"><?php echo $video; ?></div>
                    <?php else: ?>
                        <a class="feature_img" href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'home-feature' ); ?></a>
                    <?php endif; ?>
                    <div class="feature_info">
                        <h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                        <?php the_excerpt(); ?>
                    </div>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
        
        <div class="homewidgets">
        
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Top Right') ) : ?>
            	<div class="widget">
                    <h4>Widget Area</h4>
                    <p>This section is widgetized. To add widgets here, go to the <a href="<?php echo admin_url(); ?>widgets.php">Widgets</a> panel in your WordPress admin, and add the widgets you would like to <strong>Homepage Top Right</strong>.</p>
                    <p><small>*This message will be overwritten after widgets have been added</small></p>
                </div>
            <?php endif; ?>
        
        </div>
    
    </div>

    <div id="homepage">
    
    	<?php include(TEMPLATEPATH."/sidebar_left.php");?>
        
        <div class="homepagemid">

			<h3><?php echo cat_id_to_name(ot_option('hp_mid_cat')); ?></h3>
			
			<?php $wp_query = new WP_Query(array('cat'=>ot_option('hp_mid_cat'),'showposts'=>ot_option('hp_mid_num'),'paged'=>$paged)); ?>
			<?php if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); ?>
            <?php $meta_box = get_post_custom($post->ID); $video = $meta_box['custom_meta_video'][0]; ?>
            <?php global $more; $more = 0; ?>
                
            	<div class="homepagecontent">
                    
                    <?php if ( $video ) : ?>
						<?php echo $video; ?>
                    <?php else: ?>
                        <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'home-thumbnail' ); ?></a>
                    <?php endif; ?>
                    <h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                	<?php the_excerpt(); ?>
                
                </div>
                
            <?php endwhile; ?>
			
			<div id="prevLink"><p><?php previous_posts_link(); ?></p></div>
			<div id="nextLink"><p><?php next_posts_link(); ?></p></div>
            
            <?php else : // do not delete ?>
			<?php endif; // do not delete ?>

        </div>
        
        <?php include(TEMPLATEPATH."/sidebar_right.php");?>

	</div>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>