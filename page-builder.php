<?php
/**
 * Template Name: Builder
 *
 * The template for displaying full width pages (no sidebar)
 *
 * @package MNML
 */

get_header(); ?>

	<div id="primary" class="col-lg-12 content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'builder' ); ?>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
