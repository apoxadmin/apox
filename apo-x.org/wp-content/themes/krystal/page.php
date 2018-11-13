<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package krystal
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php krystal_get_page_title(false,false,false,false); ?>
		<?php
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/content', 'page' );				
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					?>
						<div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php                                        
                                        comments_template();                                        
                                    ?>
                                </div>
                            </div>
                        </div>
					<?php					
				endif;
			endwhile; // End of the loop.
		?>		
	</main>
</div>

<?php

get_footer();