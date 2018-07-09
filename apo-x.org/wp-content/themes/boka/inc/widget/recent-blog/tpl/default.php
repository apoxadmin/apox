<div class="boka-recent-blog <?php echo $instance['heading_alignment']; ?>">
	<?php if ( ! empty( $instance['title'] ) ) : ?>
		<div class="<?php echo $instance['heading_alignment']; ?>-heading margin-bottom-30">
			<?php if ( ! empty( $instance['title'] ) ) : ?>
				<h1 class="page-header"><?php echo esc_html( $instance['title'] ); ?></h1>
			<?php endif; ?>
		</div>
	<?php endif;

	$recent_post_limit = $instance['post_limit'];
	$query_latest_blog = new WP_Query( array(
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page'	  => $recent_post_limit
	) );

	?>
	<div class="recent-blog-post-widget text-left">
		<?php
		if ($query_latest_blog->have_posts()) :
			while ( $query_latest_blog->have_posts() ) : $query_latest_blog->the_post(); ?>
				<div class="col-md-6 col-sm-6 col-xs-12 margin-top-30">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="entry-thumb">
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-responsive margin-bottom-20" alt="" />
							</a>
						</div>
					<?php endif; ?>
					<?php the_title( sprintf( '<h2 class="entry-title text-capitalize margin-null link-fix"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' );
					if ( 'post' === get_post_type() ) : ?>
						<div class="entry-meta margin-bottom-20 link-fix">
							<?php
							boka_posted_on();
							boka_entry_footer();
							?>
						</div><!-- .entry-meta -->
					<?php endif; ?>
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div>
					<div class="margin-top-20">
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more">
							<?php _e( 'read more', 'boka' )?> &rarr;
						</a>
					</div>
				</div>
			<?php endwhile;
			wp_reset_postdata();
		endif;
		?>
	</div>
</div>