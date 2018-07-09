<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package boka
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area padding-gap-3">
	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				/* translators: %s: post title */
				printf( _x( 'One Reply to &ldquo;%s&rdquo;', 'comments title', 'boka' ), get_the_title() );
			} else {
				printf(
				/* translators: 1: number of comments, 2: post title */
					_nx(
						'%1$s Reply to &ldquo;%2$s&rdquo;',
						'%1$s Replies to &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'boka'
					),
					number_format_i18n( $comments_number ),
					get_the_title()
				);
			}
			?>
		</h3>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
				<div class="nav-links">

					<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'boka' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'boka' ) ); ?></div>

				</div><!-- .nav-links -->
			</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>
		<ul class="comment-list comments list-unstyled margin-top-20">
			<?php
			$comment_reply = array(
				'style'             => 'li',
				'avatar_size'       => 60,
				'short_ping'        => true,   // @since 3.6
			);
			wp_list_comments($comment_reply);
			?>
		</ul><!-- .comment-list -->
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php __( 'Comment navigation', 'boka' ); ?></h2>
				<div class="nav-links">

					<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'boka' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'boka' ) ); ?></div>

				</div><!-- .nav-links -->
			</nav><!-- #comment-nav-below -->
			<?php
		endif; // Check for comment navigation.
	endif; // Check for have_comments().
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php __( 'Comments are closed.', 'boka' ); ?></p>
		<?php
	endif;
	$comment_form = array(
		'id_form'           => 'commentform',
		'class_form'      => 'comment-form',
		'id_submit'         => 'submit',
		'class_submit'      => 'submit btn margin-top-20',
		$req = get_option( 'require_name_email' ),
		$aria_req = ( $req ? " aria-required='true'" : '' ),
		$fields =  array(
			'author' =>
				'<p class="comment-form-author"><label for="author">' . __( 'Name', 'boka' ) . '</label> ' .
				( $req ? '<span class="required">*</span>' : '' ) .
				'<input id="author" class="form-control margin-bottom-20" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
				'" size="30"' . $aria_req . ' /></p>',

			'email' =>
				'<p class="comment-form-email"><label for="email">' . __( 'Email', 'boka' ) . '</label> ' .
				( $req ? '<span class="required">*</span>' : '' ) .
				'<input id="email" class="form-control margin-bottom-20" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				'" size="30"' . $aria_req . ' /></p>',

			'url' =>
				'<p class="comment-form-url"><label for="url">' . __( 'Website', 'boka' ) . '</label>' .
				'<input id="url" name="url" class="form-control margin-bottom-20" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
				'" size="30" /></p>',
		),
		'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . __( 'Comment', 'boka' ) .
			'</label><textarea class="form-control  margin-bottom-20" id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
			'</textarea></p>',

		'fields' => apply_filters( 'comment_form_default_fields', $fields ),
	);
	comment_form($comment_form);
	?>
</div><!-- #comments -->