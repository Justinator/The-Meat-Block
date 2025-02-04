<?php
/**
 * InsightCustom functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package InsightCustom
 */

if ( ! function_exists( 'insightcustom_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function insightcustom_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on InsightCustom, use a find and replace
		 * to change 'insightcustom' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'insightcustom', get_template_directory() . '/languages' );

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

		// This theme uses wp_nav_menu() in multiple locations.
		register_nav_menus( array(
			'main-menu' => esc_html__( 'main-menu', 'insightCustom' ),
			'SecondaryMenu' => esc_html__( 'SecondaryMenu', 'insightCustom' ),
			'FooterMenu' => esc_html__( 'FooterMenu', 'insightCustom' ),
			'FoodMenu' => esc_html__( 'FoodMenu', 'insightCustom' ),
			'ServicesMenu' => esc_html__( 'ServicesMenu', 'insightCustom' ),
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

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'insightcustom_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'insightcustom_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function insightcustom_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'insightcustom_content_width', 640 );
}
add_action( 'after_setup_theme', 'insightcustom_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function insightcustom_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'insightcustom' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'insightcustom' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'insightcustom_widgets_init' );
/*********************************************************
Add custom admin login screen styles
*********************************************************/
function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/style-login.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );
/*
* Add a custom excerpt length
*/
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function insightcustom_fonts_url() {
 $fonts_url = '';

 /**
	* Translators: If there are characters in your language that are not
	* supported by Roboto, translate this to 'off'. Do not translate
	* into your own language.
	*/
 $Roboto = _x( 'on', 'Roboto font: on or off', 'insightcustom' );
 $font_families = array();
 if ( 'off' !== $Roboto ) {
	 $font_families[] = 'Roboto:400,500,700,900';
 }
 if ( in_array( 'on', array($Roboto) ) ) {
	 $query_args = array(
		 'family' => urlencode( implode( '|', $font_families ) ),
		 'subset' => urlencode( 'latin,latin-ext' ),
	 );
	 $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
 }
 return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function insightcustom_resource_hints( $urls, $relation_type ) {
 if ( wp_style_is( 'insightcustom-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
	 $urls[] = array(
		 'href' => 'https://fonts.gstatic.com',
		 'crossorigin',
	 );
 }

 return $urls;
}
add_filter( 'wp_resource_hints', 'insightcustom_resource_hints', 10, 2 );

// Advanced Custom Fields Customizations
// Add ACF options page for global settings
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}
// Set fields to collapsed for a condensed view for new users
function my_acf_admin_head() {
?>
<script type="text/javascript">
    (function($){
        $(document).ready(function(){
            $('.layout').addClass('-collapsed');
            $('.acf-postbox').addClass('closed');
        });
    })(jQuery);
</script>
<?php
}
add_action('acf/input/admin_head', 'my_acf_admin_head');

add_filter('add_to_cart_custom_fragments', 'woocommerce_header_add_to_cart_custom_fragment');
	function woocommerce_header_add_to_cart_custom_fragment( $cart_fragments ) {
	global $woocommerce;
	ob_start();
	?>
	<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View   cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
	<?php
	$cart_fragments['a.cart-contents'] = ob_get_clean();
	return $cart_fragments;
}

add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

require_once('inc/woocommerce.php');
require_once('inc/woocommerce/insightcustom-woocommerce.php');
require_once('inc/woocommerce/customize-breadcrumb.php');
////////////////////////////////////////////////////////////////
// Add custom quantity selector to our Woocommerce cart options
///////////////////////////////////////////////////////////////
add_action( 'wp_head' , 'custom_quantity_fields_css' );
function custom_quantity_fields_css(){
    ?>
    <style>
    .quantity input::-webkit-outer-spin-button,
    .quantity input::-webkit-inner-spin-button {
        display: none;
        margin: 0;
    }
    .quantity input.qty {
        appearance: textfield;
        -webkit-appearance: none;
        -moz-appearance: textfield;
    }
    </style>
    <?php
}

add_action( 'wp_footer' , 'custom_quantity_fields_script' );
function custom_quantity_fields_script(){
    ?>
    <script type='text/javascript'>
    jQuery( function( $ ) {
        if ( ! String.prototype.getDecimals ) {
            String.prototype.getDecimals = function() {
                var num = this,
                    match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                if ( ! match ) {
                    return 0;
                }
                return Math.max( 0, ( match[1] ? match[1].length : 0 ) - ( match[2] ? +match[2] : 0 ) );
            }
        }
        // Quantity "plus" and "minus" buttons
        $( document.body ).on( 'click', '.plus, .minus', function() {
            var $qty        = $( this ).closest( '.quantity' ).find( '.qty'),
                currentVal  = parseFloat( $qty.val() ),
                max         = parseFloat( $qty.attr( 'max' ) ),
                min         = parseFloat( $qty.attr( 'min' ) ),
                step        = $qty.attr( 'step' );

            // Format values
            if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
            if ( max === '' || max === 'NaN' ) max = '';
            if ( min === '' || min === 'NaN' ) min = 0;
            if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

            // Change the value
            if ( $( this ).is( '.plus' ) ) {
                if ( max && ( currentVal >= max ) ) {
                    $qty.val( max );
                } else {
                    $qty.val( ( currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            } else {
                if ( min && ( currentVal <= min ) ) {
                    $qty.val( min );
                } else if ( currentVal > 0 ) {
                    $qty.val( ( currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            }

            // Trigger change event
            $qty.trigger( 'change' );
        });
    });
    </script>
    <?php
}
///////////////////////////////////////////////////////////////
//// Add custom continue shopping cutton to cart page
//////////////////////////////////////////////////////////////
add_action( 'woocommerce_before_cart_collaterals', 'continue_shopping_button', 31 );

function continue_shopping_button() {
  if ( wp_get_referer() ) echo '<i class="fas fa-chevron-left"></i><a class="button continue" href="' . wp_get_referer() . '">Continue Shopping</a>';
}
// Set search results to display only 'product' post type results
if ( !is_admin() ) {
function searchfilter($query) {
 if ($query->is_search && !is_admin() ) {
 $query->set('post_type',array('product'));
 }
return $query;
}
add_filter('pre_get_posts','searchfilter');
}

/**
 * Enqueue scripts and styles.
 */
function insightcustom_scripts() {
	wp_enqueue_style( 'insightcustom-style', get_stylesheet_uri() );
	wp_enqueue_script( 'insightcustom-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'insightcustom-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_register_style('font-awesome', get_stylesheet_directory_uri() . '/css/css/all.css');
	wp_enqueue_style('font-awesome');
	wp_enqueue_script('customJS', get_stylesheet_directory_uri() . '/js/customJS.js');
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'insightcustom_scripts' );
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
