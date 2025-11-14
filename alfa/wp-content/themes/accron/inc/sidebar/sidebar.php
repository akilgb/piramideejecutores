<?php	
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package accron
 */


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function accron_widgets_init() {	
	register_sidebar( array(
		'name' => __( 'Sidebar Widget Area', 'accron' ),
		'id' => 'accron-sidebar-primary',
		'description' => __( 'The Primary Widget Area', 'accron' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2 class="widget-title"><span></span>',
		'after_title' => '</h2>',
	) );	
	 
	register_sidebar( array(
		'name' => __( 'Footer', 'accron' ),
		'id' => 'accron-footer-widget',
		'description' => __( 'The Footer Widget Area', 'accron' ),
		'before_widget' => ' <div id="%1$s" class="%2$s col-lg-3 col-md-6"><div class="footer-item">',
		'after_widget' => '</div></div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	
	register_sidebar( array(
		'name' => __( 'WooCommerce Widget Area', 'accron' ),
		'id' => 'accron-woocommerce-sidebar',
		'description' => __( 'This Widget Area For WooCommerce Widget', 'accron' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
}
add_action( 'widgets_init', 'accron_widgets_init' );