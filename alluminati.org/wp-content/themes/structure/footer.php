<!-- begin footer -->

<div style="clear:both;"></div>

<div id="footertopbg">

    <div id="footertop">
        
            <div class="footertopleft">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Left') ) : ?>
                <?php endif; ?>
            </div>
            
            <div class="footertopmidleft">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Mid Left') ) : ?>
                <?php endif; ?>
            </div>
            
            <div class="footertopmidright">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Mid Right') ) : ?>
                <?php endif; ?>
            </div>
            
            <div class="footertopright">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Right') ) : ?>
                <?php endif; ?>
            </div>
            
    </div>

</div>

<div id="footerbg">

	<div id="footer">
    
    	<div class="footerleft">
            <div class="footertop">
                <p><?php _e("Copyright", 'organicthemes'); ?> <?php echo date('Y'); ?> <?php bloginfo('name'); ?> &middot; <a href="<?php bloginfo('rss_url'); ?>" target="_blank">RSS Feed</a> &middot; <?php wp_loginout(); ?></p>
            </div>
            
            <div class="footerbottom">
                <p><a href="http://www.organicthemes.com/themes/" target="_blank"><?php _e("The Structure Theme", 'organicthemes'); ?></a> <?php _e("by", 'organicthemes'); ?> <a href="http://www.organicthemes.com" target="_blank">Organic Themes</a> &middot; <a href="http://kahunahost.com" target="_blank" title="WordPress Hosting"><?php _e("WordPress Hosting", 'organicthemes'); ?></a></p>
            </div>
        </div>
        
        <div class="footerright">
    		<a href="http://www.organicthemes.com" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/footer_logo.png" alt="<?php _e("Organic Themes",'organicthemes'); ?>" /></a>
    	</div>
		
	</div>
	
</div>

</div>

<?php do_action('wp_footer'); ?>

<?php echo stripslashes(ot_option('tracking')); // tracking code ?>
</body>
</html>