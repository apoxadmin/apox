<?php
$id        = get_theme_mod( 'onepress_news_id', esc_html__('news', 'onepress') );
$disable   = get_theme_mod( 'onepress_news_disable' ) == 1 ? true : false;
$title     = get_theme_mod( 'onepress_news_title', esc_html__('Latest News', 'onepress' ));
$subtitle  = get_theme_mod( 'onepress_news_subtitle', esc_html__('Section subtitle', 'onepress' ));
$number    = get_theme_mod( 'onepress_news_number', '3' );
$more_link = get_theme_mod( 'onepress_news_more_link', '#' );
$more_text = get_theme_mod( 'onepress_news_more_text', esc_html__('Read Our Blog', 'onepress' ));
if ( onepress_is_selective_refresh() ) {
    $disable = false;
}
?>
<?php if ( ! $disable  ) :

$desc = get_theme_mod( 'onepress_news_desc' );
?>
<?php if ( ! onepress_is_selective_refresh() ){ ?>
<section id="<?php if ( $id != '' ) echo $id; ?>" <?php do_action( 'onepress_section_atts', 'news' ); ?> class="<?php echo esc_attr( apply_filters( 'onepress_section_class', 'section-news section-padding onepage-section', 'news' ) ); ?>">
<?php } ?>
    <?php do_action( 'onepress_section_before_inner', 'news' ); ?>
	<div class="<?php echo esc_attr( apply_filters( 'onepress_section_container_class', 'container', 'news' ) ); ?>">
		<?php if ( $title ||  $subtitle ||  $desc ) { ?>
		<div class="section-title-area">
			<?php if ( $subtitle != '' ) echo '<h5 class="section-subtitle">' . esc_html( $subtitle ) . '</h5>'; ?>
			<?php if ( $title != '' ) echo '<h2 class="section-title">' . esc_html( $title ) . '</h2>'; ?>
            <?php if ( $desc ) {
                echo '<div class="section-desc">' . apply_filters( 'onepress_the_content', wp_kses_post( $desc ) ) . '</div>';
            } ?>
        </div>
		<?php } ?>
		<div class="section-content">
			<div class="row">
				<div class="col-sm-12">
					<div class="blog-entry wow slideInUp">
						<?php
						$query = new WP_Query(
							array(
								'posts_per_page' => $number,
								'suppress_filters' => 0,
							)
						);
						?>
						<?php if ( $query->have_posts() ) : ?>

							<?php /* Start the Loop */ ?>
							<?php while ( $query->have_posts() ) : $query->the_post(); ?>
								<?php
									/*
									 * Include the Post-Format-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
									 */
									get_template_part( 'template-parts/content', 'list' );
								?>

							<?php endwhile; ?>
						<?php else : ?>
							<?php get_template_part( 'template-parts/content', 'none' ); ?>
						<?php endif; ?>

						<?php if ( $more_link != '' ) { ?>
						<div class="all-news">
							<a class="btn btn-theme-primary-outline" href="<?php echo esc_url($more_link) ?>"><?php if ( $more_text != '' ) echo esc_html( $more_text ); ?></a>
						</div>
						<?php } ?>

					</div>
				</div>
			</div>

		</div>
	</div>
	<?php do_action( 'onepress_section_after_inner', 'news' ); ?>
<?php if ( ! onepress_is_selective_refresh() ){ ?>
</section>
<?php } ?>
<?php endif;
wp_reset_query();

