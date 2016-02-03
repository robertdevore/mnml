<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MNML
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( has_post_thumbnail() ) { ?>
			<?php if ( get_theme_mod( 'mnml_featuredimage_clickable' ) !== 'no' ) { ?>
			<a href="<?php the_permalink(); ?>">
			<?php } ?>
			<?php echo the_post_thumbnail('large-image'); ?>
			<?php if ( get_theme_mod( 'mnml_featuredimage_clickable' ) !== 'no' ) { ?>
			</a>
			<?php } ?>
		<?php } ?>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mnml' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->

