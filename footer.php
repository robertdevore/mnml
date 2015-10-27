<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MNML
 */

?>
			</div><!-- /.row -->
		</div><!-- /.container -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<?php if ( is_active_sidebar( 'footer' ) ) { ?>
			<div class="row widgets">
				<?php dynamic_sidebar( 'footer' ); ?>
			</div><!-- /.row.widgets -->
			<?php } ?>
			<div class="row">
				<div class=" col-lg-12 site-info">
					<div class="copyright">
					<?php if (get_theme_mod( 'mnml_footer_copyright_text' ) !='') { ?>
						<?php echo get_theme_mod( 'mnml_footer_copyright_text' ); ?>
					<?php } else { ?>
						<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'mnml' ) ); ?>"><?php printf( esc_html__( 'Powered by %s', 'mnml' ), 'WordPress' ); ?></a>
						<span class="sep"> | </span>
						<?php printf( esc_html__( 'Theme: %1$s by %2$s', 'mnml' ), '<a href="http://www.robertdevore.com/mnml-free-minimalist-wordpress-theme" target="_blank">MNML</a>', '<a href="http://www.deviodigital.com" rel="designer" target="_blank">Devio Digital</a>' ); ?>
					<?php } ?>
					</div><!-- /.copyright -->
				</div><!-- .site-info -->
			</div><!-- /.row -->
		</div><!-- /.container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<!-- Scroll to top -->
<div class="scroll-up">
	<a href="#page"><i class="fa fa-angle-up"></i></a>
</div><!-- /.scroll-up -->

</body>
</html>
