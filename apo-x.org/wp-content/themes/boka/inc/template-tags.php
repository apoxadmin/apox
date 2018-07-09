<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package boka
 */

if ( ! function_exists( 'boka_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function boka_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated visible-xs hidden-xs" datetime="%3$s"> %4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( ' %s', 'post date', 'boka' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><i class="fa fa-clock-o"></i> ' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( ' %s', 'post author', 'boka' ),
		'<span class="author author-fix vcard">'. __('By ','boka').'<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="byline"> ' . $byline . '</span><span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
	comments_number( '<span> <i class="fa fa-comments-o"></i> 0</span>', '<span> <i class="fa fa-comment"></i> 1</span>', '<span> <i class="fa fa-comment"></i> %</span>' );

}
endif;

if ( ! function_exists( 'boka_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function boka_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'boka' ) );
		if ( $categories_list && boka_categorized_blog() ) {
			printf( '<span class="cat-links"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> ' . esc_html__( ' %1$s', 'boka' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'boka' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><i class="fa fa-folder-o" aria-hidden="true"></i> ' . esc_html__( ' %1$s', 'boka' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function boka_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'boka_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'boka_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so boka_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so boka_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in boka_categorized_blog.
 */
function boka_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'boka_categories' );
}
add_action( 'edit_category', 'boka_category_transient_flusher' );
add_action( 'save_post',     'boka_category_transient_flusher' );
