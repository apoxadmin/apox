<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package boka
 */

?>

<div class="no-results not-found">
	<header class="entry-header">
		<h3 class="entry-title text-capitalize"><?php _e( 'Nothing Found', 'boka' ); ?></h3>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'boka' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
		<?php elseif ( is_search() ) : ?>
			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'boka' ); ?></p>
			<form role="search" method="get" class="search-form form-inline margin-top-20" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="search" class="search-field form-control" placeholder="<?php echo esc_attr( 'Search ...', 'boka' ); ?>" value="<?php echo get_search_query() ?>" name="s" />
				<input type="submit" class="search-submit btn btn-default" value="<?php echo esc_attr( 'Search', 'boka' ); ?>" />
			</form>
			<?php
		else : ?>
			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'boka' ); ?></p>
			<form role="search" method="get" class="search-form form-inline margin-top-20" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="search" class="search-field form-control" placeholder="<?php esc_attr( 'Search ...', '', 'boka' ) ?>" value="<?php echo get_search_query() ?>" name="s" />
				<input type="submit" class="search-submit btn btn-default" value="<?php echo esc_attr( 'Search', 'boka' ) ?>" />
			</form>
			<?php
		endif; ?>
		<div class="clearfix"></div>
	</div><!-- .page-content -->
</div><!-- .no-results -->