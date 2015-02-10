<!-- begin r_sidebar -->

<div id="sidebar_left">

	<h4 class="featuredtitle"><?php echo cat_id_to_name(ot_option('hp_side_cat')); ?></h4>
        
        <?php $recent = new WP_Query("cat=" .ot_option('hp_side_cat'). "&showposts=" .ot_option('hp_side_num') ); while($recent->have_posts()) : $recent->the_post();?>
            
            <div class="sidecontent">
                
                <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'home-side' ); ?></a>
                <h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                <?php the_content_limit(50, ""); ?>
                <a class="morelink" href="<?php the_permalink() ?>" rel="bookmark"><?php _e("Read More", 'organicthemes'); ?></a>
                <div class="clear"></div>
            
            </div>
            
        <?php endwhile; ?>

	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Left Sidebar') ) : ?>
        <div class="widget">
            <h4>Widget Area</h4>
            <p>This section is widgetized. To add widgets here, go to the <a href="<?php echo admin_url(); ?>widgets.php">Widgets</a> panel in your WordPress admin, and add the widgets you would like to <strong>Left Sidebar</strong>.</p>
            <p><small>*This message will be overwritten after widgets have been added</small></p>
        </div>
    <?php endif; ?>
			
</div>