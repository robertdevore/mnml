<?php 

/**
 * Registers options with the Theme Customizer
 *
 * @param      object    $wp_customize    The WordPress Theme Customizer
 * @package    MNML
 * @since      1.0.0
 * @version    1.0.1
 */

function mnml_register_theme_customizer( $wp_customize ) {

	/*-----------------------------------------------------------*
	 * Site Title (logo) & Tagline section
	 *-----------------------------------------------------------*/
	// section adjustments
	$wp_customize->get_section( 'title_tagline' )->title = __( 'Site Title (Logo) & Tagline', 'mnml' );
	$wp_customize->get_section( 'title_tagline' )->priority = 10;
	// site title
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_control( 'blogname' )->priority = 10;
	// site tagline
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';	
	$wp_customize->get_control( 'blogdescription' )->priority = 20;
	// logo uploader
	$wp_customize->add_setting( 'mnml_logo', array( 'default' => null ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mnml_logo', array(
		'label'     => __( 'Custom Site Logo', 'mnml' ),
		'section'   => 'title_tagline',
		'settings'  => 'mnml_logo',
		'priority'  => 30
	) ) );
	
	/*-----------------------------------------------------------*
	 * Color options
	 *-----------------------------------------------------------*/
	/* Link Color */
	$wp_customize->add_setting(
		'mnml_main_color',
		array(
			'default'     		 => '#0085a1',
			'sanitize_callback'  	 => 'mnml_sanitize_input',
			'transport'   		 => 'refresh'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_color',
			array(
			    'label'      => 'Main Color',
			    'section'    => 'colors',
			    'settings'   => 'mnml_main_color'
			)
		)
	);
	
	/*-----------------------------------------------------------*
	 * Defining our own 'Display Options' section
	 *-----------------------------------------------------------*/
	$wp_customize->add_section(
		'mnml_display_options',
		array(
			'title'     => 'Copyright',
			'priority'  => 40
		)
	);

	/* Display Copyright */
	$wp_customize->add_setting(
		'mnml_footer_copyright_text',
		array(
			'default'            => '',
			'sanitize_callback'  => 'mnml_sanitize_copyright',
			'transport'          => 'refresh'
		)
	);
	$wp_customize->add_control(
		'mnml_footer_copyright_text',
		array(
			'section'  => 'mnml_display_options',
			'label'    => 'Copyright Message',
			'type'     => 'text'
		)
	);

	
} // end mnml_register_theme_customizer
add_action( 'customize_register', 'mnml_register_theme_customizer' );
/**
 * Sanitizes the incoming input and returns it prior to serialization.
 *
 * @param      string    $input    The string to sanitize
 * @return     string              The sanitized string
 * @package    mnml
 * @since      1.0.0
 * @version    1.0.0
 */
function mnml_sanitize_input( $input ) {
	return strip_tags( stripslashes( $input ) );
} // end mnml_sanitize_input

function mnml_sanitize_copyright( $input ) {
	$allowed = array(
		's'			=> array(),
		'br'			=> array(),
		'em'			=> array(),
		'i'			=> array(),
		'strong'		=> array(),
		'b'			=> array(),
		'a'			=> array(
			'href'			=> array(),
			'title'			=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'form'			=> array(
			'id'			=> array(),
			'class'			=> array(),
			'action'		=> array(),
			'method'		=> array(),
			'autocomplete'		=> array(),
			'style'			=> array(),
		),
		'input'			=> array(
			'type'			=> array(),
			'name'			=> array(),
			'class' 		=> array(),
			'id'			=> array(),
			'value'			=> array(),
			'placeholder'		=> array(),
			'tabindex'		=> array(),
			'style'			=> array(),
		),
		'img'			=> array(
			'src'			=> array(),
			'alt'			=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
			'height'		=> array(),
			'width'			=> array(),
		),
		'span'			=> array(
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'p'			=> array(
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'div'			=> array(
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'blockquote'		=> array(
			'cite'			=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
	);
    return wp_kses( $input, $allowed );
} // end mnml_sanitize_copyright

/**
 * Writes styles out the `<head>` element of the page based on the configuration options
 * saved in the Theme Customizer.
 *
 * @since      1.0.0
 * @version    1.0.0
 */
function mnml_customizer_css() {
?>
	<style type="text/css">
		-moz-selection,
		::selection{
			background: <?php echo get_theme_mod( 'mnml_main_color' ); ?>;
		}
		body{
			webkit-tap-highlight-color: <?php echo get_theme_mod( 'mnml_main_color' ); ?>;
		}
		a,
		.main-navigation ul li a:hover,
		.menu-toggle:hover,
		.main-navigation.toggled ul:hover,
		.entry-title a:hover,
		.widget a:hover,
		h1.site-title a:hover,
		h2.site-title a:hover,
		.copyright a:hover {
			color: <?php echo get_theme_mod( 'mnml_main_color' ); ?>;
		}
		.pager li>a:hover, .pager li>a:focus {
			color: #fff;
			background-color: <?php echo get_theme_mod( 'mnml_main_color' ); ?>;
			border: 1px solid <?php echo get_theme_mod( 'mnml_main_color' ); ?>;
		}

		button:hover,
		input[type="button"]:hover,
		input[type="reset"]:hover,
		input[type="submit"]:hover {
			background: <?php echo get_theme_mod( 'mnml_main_color' ); ?>;
			border-color: <?php echo get_theme_mod( 'mnml_main_color' ); ?>;
		}

		button:focus,
		input[type="button"]:focus,
		input[type="reset"]:focus,
		input[type="submit"]:focus,
		button:active,
		input[type="button"]:active,
		input[type="reset"]:active,
		input[type="submit"]:active {
			background: <?php echo get_theme_mod( 'mnml_main_color' ); ?>;
			border-color: <?php echo get_theme_mod( 'mnml_main_color' ); ?>;
		}

	</style>
<?php
} // end mnml_customizer_css
add_action( 'wp_head', 'mnml_customizer_css' );
/**
 * Registers the Theme Customizer Preview with WordPress.
 *
 * @package    mnml
 * @since      1.0.0
 * @version    1.0.0
 */
function mnml_customizer_live_preview() {
	wp_enqueue_script(
		'mnml-theme-customizer',
		get_template_directory_uri() . '/js/customizer.js',
		array( 'customize-preview' ),
		'1.0.0',
		true
	);
} // end mnml_customizer_live_preview
add_action( 'customize_preview_init', 'mnml_customizer_live_preview' );
