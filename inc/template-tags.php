<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package MNML
 */

if ( ! function_exists( 'mnml_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function mnml_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( ' %s', 'post date', 'mnml' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'mnml' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on"><i class="fa fa-clock-o fa-lg"></i>' . $posted_on . '</span><span class="byline"><i class="fa fa-user fa-lg"></i> ' . $byline . '</span>'; // WPCS: XSS OK.
	
	// Hide category text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'mnml' ) );
		if ( $categories_list && mnml_categorized_blog() ) {
			printf( '<span class="cat-links"><i class="fa fa-folder fa-lg"></i> ' . esc_html__( '%1$s', 'mnml' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link"><i class="fa fa-comments-o fa-lg"></i> ';
		comments_popup_link( esc_html__( 'Leave a comment', 'mnml' ), esc_html__( '1 Comment', 'mnml' ), esc_html__( '% Comments', 'mnml' ) );
		echo '</span>';
	}

	edit_post_link( esc_html__( 'Edit', 'mnml' ), '<span class="edit-link"><i class="fa fa-pencil fa-lg"></i> ', '</span>' );

}
endif;

if ( ! function_exists( 'mnml_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function mnml_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'mnml' ) );
		if ( $categories_list && mnml_categorized_blog() ) {
			printf( '<div class="cat-links"><i class="fa fa-folder fa-lg"></i> ' . esc_html__( '%1$s', 'mnml' ) . '</div>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'mnml' ) );
		if ( $tags_list ) {
			printf( '<div class="tags-links"><i class="fa fa-tags fa-lg"></i> ' . esc_html__( '%1$s', 'mnml' ) . '</div>', $tags_list ); // WPCS: XSS OK.
		}
	}

}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function mnml_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'mnml_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'mnml_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so mnml_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so mnml_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in mnml_categorized_blog.
 */
function mnml_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'mnml_categories' );
}
add_action( 'edit_category', 'mnml_category_transient_flusher' );
add_action( 'save_post',     'mnml_category_transient_flusher' );
