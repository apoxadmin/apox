<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package krystal
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

 function krystal_comment_callback( $comment, $args, $depth ) {
	 $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
	<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
	    	        <?php
	    				comment_reply_link( array_merge( $args, array(
	    					'add_below' => 'comment',
	    					'depth'     => $depth,
	    					'max_depth' => $args['max_depth'],
	    					'before'    => '<div class="reply">',
	    					'after'     => '</div>'
	    				) ) );
	    			?>
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					<?php printf( __( '%s <span class="says">says:</span>','krystal' ), sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) ) ); ?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php
								/* translators: 1: comment date, 2: comment time */
								printf( __( '%1$s at %2$s','krystal'), get_comment_date( '', $comment ), get_comment_time() );
							?>
						</time>
					</a>
					<?php edit_comment_link( __( 'Edit','krystal' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.','krystal' ); ?></p>
				<?php endif; ?>

			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

		</article><!-- .comment-body -->
	<?php
 }


if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h4 class="comments-title">
			<?php
				printf( // WPCS: XSS OK.
					esc_html( _nx( '%1$s people reacted on this', '%1$s People reacted on this', get_comments_number(), 'comments title', 'krystal' ) ),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>'
				);
			?>
		</h4>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'krystal' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'krystal' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'krystal' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style' => 'ol',
					'short_ping' => true,
					'avatar_size' => 50,
					'callback' => 'krystal_comment_callback'
				) );

			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'krystal' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'krystal' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'krystal' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
		<?php
		endif; // Check for comment navigation.

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php _e( 'Comments are closed.', 'krystal' ); ?></p>
	<?php
	endif;

	$comment_args = array( 'title_reply'=>__('Leave a Reply:','krystal'),
					'fields' => apply_filters( 'comment_form_default_fields', array(
						'author' => '<p class="comment-form-author">'.
        			'<input id="author" placeholder="'. __('Name *','krystal') . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" /></p>',
    				'email'  => '<p class="comment-form-email">' .
              '<input id="email" placeholder="'. __('Email *','krystal') . '" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" />'.'</p>',
						'url'  => '<p class="comment-form-url">' .
			        '<input id="url" placeholder="'. __('Website','krystal') . '" name="url" type="text" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" size="30" />'.'</p>',
					)),
					'comment_field' => '<p>' .'<textarea id="comment"  placeholder="'. __('Comment','krystal') . '" name="comment" cols="45" rows="8" aria-required="true"></textarea>' .	'</p>',
	);

	comment_form($comment_args);

	?>

</div><!-- #comments -->
