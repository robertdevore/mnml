<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MNML
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php mnml_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php if ( has_post_thumbnail() ) { ?>
			<?php if ( get_theme_mod( 'mnml_featuredimage_clickable' ) !== 'no' ) { ?>
			<a href="<?php the_permalink(); ?>">
			<?php } ?>
			<?php echo the_post_thumbnail('small-image'); ?>
			<?php if ( get_theme_mod( 'mnml_featuredimage_clickable' ) !== 'no' ) { ?>
			</a>
			<?php } ?>
		<?php } ?>
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
</article><!-- #post-## -->

