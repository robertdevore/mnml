<?php
/**
 * MNML functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package MNML
 */

if ( ! function_exists( 'mnml_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function mnml_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on MNML, use a find and replace
	 * to change 'mnml' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'mnml', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'small-image', 340, 200, true );
	add_image_size( 'large-image', 750, 500, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'mnml' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'mnml_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // mnml_setup
add_action( 'after_setup_theme', 'mnml_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mnml_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'mnml_content_width', 750 );
}
add_action( 'after_setup_theme', 'mnml_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mnml_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'mnml' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'mnml' ),
		'id'            => 'footer',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget col-lg-3 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'mnml_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mnml_scripts() {
	wp_enqueue_style( 'mnml-style', get_stylesheet_uri() );
	wp_enqueue_style( 'mnml-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'mnml-theme', get_template_directory_uri() . '/css/mnml.css' );
	wp_enqueue_style( 'mnml-fontawesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'mnml-googlefonts', 'https://fonts.googleapis.com/css?family=Lora|Lato:400,300,700,900,300italic,400italic,700italic' );

	wp_enqueue_script( 'mnml-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20150831', true );
	wp_enqueue_script( 'mnml-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20150831', true );
	wp_enqueue_script( 'mnml-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '20150831', true );
	wp_enqueue_script( 'mnml-smoothscroll', get_template_directory_uri() . '/js/smoothscroll.js', array(), '20150831', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mnml_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Remove container DIV from navigation menu in header.
 */
function my_wp_nav_menu_args( $args = '' ) {
	$args['container'] = false;
	return $args;
}
add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );

/**
 * Customizing the excerpt
 */

// Customize the excerpt length
function custom_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// Add a Read More link to the end of the excerpt
function custom_excerpt_more( $more ) {
	return ' ... <a class="read-more" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Read More', 'mnml' ) . '</a>';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

// Add a class to the <p> wrap around the excerpt
function add_class_to_excerpt( $excerpt ) {
    return str_replace('<p', '<p class="excerpt"', $excerpt);
}
add_filter( "the_excerpt", "add_class_to_excerpt" );

/**
 * Using logo upload from customizer to change login page logo
 */

if ( get_theme_mod( 'mnml_logo' ) )  {

// Change login page logo image to the logo uploaded in the customizer	
function mnml_login_logo() {
	
	list($width,$height) = getimagesize(get_theme_mod( "mnml_logo" ));

	echo '<style type="text/css">
		#login {
			width: '. $width .'px !important;
		}
		h1 a {
			background-image:url('. get_theme_mod( "mnml_logo" ) .') !important;
			background-size: '. $width .'px !important;
			width: '. $width .'px !important;
			height: '. $height .'px !important;
		}
	</style>';
}

add_action('login_head', 'mnml_login_logo');

// Change login page logo link to the website home page
function mnml_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'mnml_login_logo_url' );

// Change login page logo title to the website name
function mnml_login_logo_url_title() {
    return get_bloginfo( 'name' );
}
add_filter( 'login_headertitle', 'mnml_login_logo_url_title' );

} // if get_theme_mod('mnml_logo')
