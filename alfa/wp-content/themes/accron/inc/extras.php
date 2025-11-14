<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Accron
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function accron_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	
	return $classes;
}
add_filter( 'body_class', 'accron_body_classes' );



if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Backward compatibility for wp_body_open hook.
	 *
	 * @since 1.0.0
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

if (!function_exists('accron_str_replace_assoc')) {

    /**
     * accron_str_replace_assoc
     * @param  array $replace
     * @param  array $subject
     * @return array
     */
    function accron_str_replace_assoc(array $replace, $subject) {
        return str_replace(array_keys($replace), array_values($replace), $subject);
    }
}

// Accron Navigation
if ( ! function_exists( 'accron_primary_navigation' ) ) :
function accron_primary_navigation() {
	wp_nav_menu( 
		array(  
			'theme_location' => 'primary_menu',
			'container'  => '',
			'menu_class' => 'navbar-nav me-auto mb-2 mb-lg-0',
			'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
			'walker' => new WP_Bootstrap_Navwalker()
			 ) 
		);
	} 
endif;
add_action( 'accron_primary_navigation', 'accron_primary_navigation' );

if ( ! function_exists( 'accron_footer_navigation' ) ) :
function accron_footer_navigation() {
	wp_nav_menu( 
		array(  
			'theme_location' => 'footer_menu',
			'container'  => '',
			'menu_class' => 'footer-menu',
			'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
			'walker' => new WP_Bootstrap_Navwalker()
			 ) 
		);
	} 
endif;
add_action( 'accron_footer_navigation', 'accron_footer_navigation' );



// Accron Pro Navigation Cart
if ( ! function_exists( 'accron_navigation_cart' ) ) :
function accron_navigation_cart() {
	$hide_show_cart 	= get_theme_mod( 'hide_show_cart','1'); 
		if($hide_show_cart=='1' && class_exists( 'Woocommerce' )):	
	?>
		<li class="cart_dropdown dropdown">
			<a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				<i class="fas fa-shopping-cart"></i>
				<?php 
					if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
						$count = WC()->cart->cart_contents_count;
						$cart_url = wc_get_cart_url();
						
						if ( $count > 0 ) {
						?>
							<span class="cart-badge count"><?php echo esc_html( $count ); ?></span>
						<?php 
						}
						else {
							?>
							<span class="cart-badge count"><?php echo esc_html_e('0','accron'); ?></span>
							<?php 
						}
					}
				?>
			</a>
			<div class="dropdown-menu dropdown-menu-end">
				<!-- Shopping Cart Start -->
				<div class="shopping-cart">
					<?php get_template_part('woocommerce/cart/mini','cart'); ?>
				</div>
			</div>
			<!-- Shopping Cart End -->
		</li>
	<?php endif; 
	} 
endif;
add_action( 'accron_navigation_cart', 'accron_navigation_cart' );



// Accron Logo
if ( ! function_exists( 'accron_logo_content' ) ) :
function accron_logo_content() {
		if(has_custom_logo())
			{	
				the_custom_logo();
			} 
			
			$accron_site_title = get_bloginfo( 'name');
			if ($accron_site_title) :
		?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<h4 class="site-title">
					<?php echo esc_html($accron_site_title);  ?>
				</h4>	
			</a>
		<?php endif; ?>
		<?php
			$accron_site_desc = get_bloginfo( 'description');
			if ($accron_site_desc) : ?>
				<p class="site-description"><?php echo esc_html($accron_site_desc); ?></p>
		<?php endif;
	} 
endif;
add_action( 'accron_logo_content', 'accron_logo_content' );



 /**
 * Add WooCommerce Cart Icon With Cart Count (https://isabelcastillo.com/woocommerce-cart-icon-count-theme-header)
 */
function accron_add_to_cart_fragment( $fragments ) {
	
    ob_start();
    $count = WC()->cart->cart_contents_count; 
    ?> 
	<a href="javascript:void(0);" class="cart-icon-wrap" id="cart" title="<?php esc_attr_e('View your shopping cart','accron'); ?>">
	<i class="fa fa-shopping-bag"></i>	
	<?php
    if ( $count > 0 ) { 
	?>
        <span><?php echo esc_html( $count ); ?></span>
	<?php            
    } else {
	?>	
	<span><?php echo esc_html_e('0','accron'); ?></span>
	<?php
	}
    ?></a><?php
 
    $fragments['a.cart-icon-wrap'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'accron_add_to_cart_fragment' );





/*******************************************************************************
 *  Get Started Notice
 *******************************************************************************/

add_action( 'wp_ajax_accron_dismissed_notice_handler', 'accron_ajax_notice_handler' );

/**
 * AJAX handler to store the state of dismissible notices.
 */
function accron_ajax_notice_handler() {
	// Verify the nonce
    check_ajax_referer( 'accron-ajax-nonce', 'nonce' );
	
    if ( isset( $_POST['type'] ) ) {
        // Pick up the notice "type" - passed via jQuery (the "data-notice" attribute on the notice)
        $type = sanitize_text_field( wp_unslash( $_POST['type'] ) );
        // Store it in the options table
        update_option( 'dismissed-' . $type, TRUE );
    }
	
	// Send a response (you can use wp_send_json_success() or wp_send_json_error())
    wp_send_json_success( 'Notice dismissed!' );
}

function accron_deprecated_hook_admin_notice() {
        // Check if it's been dismissed...
        if ( ! get_option('dismissed-get_started', FALSE ) ) {
            // Added the class "notice-get-started-class" so jQuery pick it up and pass via AJAX,
            // and added "data-notice" attribute in order to track multiple / different notices
            // multiple dismissible notice states ?>
            <div class="updated notice notice-get-started-class is-dismissible" data-notice="get_started">
                <div class="accron-getting-started-notice clearfix">
                    <div class="accron-theme-screenshot">
                        <img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/screenshot.jpg" class="screenshot" alt="<?php esc_attr_e( 'Theme Screenshot', 'accron' ); ?>" />
                    </div><!-- /.accron-theme-screenshot -->
                    <div class="accron-theme-notice-content">
                        <h2 class="accron-notice-h2">
                            <?php
                        printf(
                        /* translators: 1: welcome page link starting html tag, 2: welcome page link ending html tag. */
                            esc_html__( 'Welcome! Thank you for choosing %1$s!', 'accron' ), '<strong>'. wp_get_theme()->get('Name'). '</strong>' );
                        ?>
                        </h2>

                        <p class="plugin-install-notice"><?php printf(__('Install and activate %1$sClever Fox%2$s plugin for taking full advantage of all the features this theme has to offer.', 'accron'), '<strong>', '</strong>'); ?></p>

                        <?php
						$theme = wp_get_theme();
						$theme_name = esc_html($theme->get('Name'));
						$get_started_text = esc_html__('Get started with %s', 'accron');
						?>
						<a class="accron-btn-get-started button button-primary button-hero accron-button-padding" href="#" data-name="" data-slug="">
							<?php printf('%s', sprintf($get_started_text, $theme_name)); ?>
						</a><span class="accron-push-down">
						
                        <?php
                            /* translators: %1$s: Anchor link start %2$s: Anchor link end */
                            printf(
                                __('or %1$sCustomize theme%2$s</a></span>','accron'),
                                '<a target="_blank" href="' . esc_url( admin_url( 'customize.php' ) ) . '">',
                                '</a>'
                            );
                        ?>
                    </div><!-- /.accron-theme-notice-content -->
                </div>
            </div>
        <?php }
}

add_action( 'admin_notices', 'accron_deprecated_hook_admin_notice' );

/*******************************************************************************
 *  Plugin Installer
 *******************************************************************************/

add_action( 'wp_ajax_install_act_plugin', 'accron_admin_install_plugin' );

function accron_admin_install_plugin() {
	 // Verify the nonce
    check_ajax_referer( 'accron-ajax-nonce', 'nonce' );
	
    /**
     * Install Plugin.
     */
    include_once ABSPATH . '/wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

    if ( ! file_exists( WP_PLUGIN_DIR . '/clever-fox' ) ) {
        $api = plugins_api( 'plugin_information', array(
            'slug'   => sanitize_key( wp_unslash( 'clever-fox' ) ),
            'fields' => array(
                'sections' => false,
            ),
        ) );

        $skin     = new WP_Ajax_Upgrader_Skin();
        $upgrader = new Plugin_Upgrader( $skin );
        $result   = $upgrader->install( $api->download_link );
    }

    // Activate plugin.
    if ( current_user_can( 'activate_plugin' ) ) {
        $result = activate_plugin( 'clever-fox/clever-fox.php' );
    }
	
	 // Return a response if needed
    wp_send_json_success( 'Plugin installed successfully!' );
}


/**
 * This Function Check whether Sidebar active or Not
 */
if(!function_exists( 'accron_blog_column_layout' )) :
function accron_blog_column_layout(){
	if(is_active_sidebar('accron-sidebar-primary'))
		{ echo 'col-lg-8'; } 
	else 
		{ echo 'col-lg-12'; }  
} endif;
 
 

/*
 *
 * Contact Instagram Gallery Default
 */
function accron_get_instagram_gallery_default() {
	return apply_filters(
		'accron_get_instagram_gallery_default', json_encode(
			array(
				array(	
					'image_url' => esc_url(get_template_directory_uri() . '/assets/images/gallery/item1.jpg'),
					'id'        => 'customizer_repeater_instagram_gallery_001',
				),
				array(	
					'image_url' => esc_url(get_template_directory_uri() . '/assets/images/gallery/item2.jpg'),
					'id'        => 'customizer_repeater_instagram_gallery_002',
				),
				array(	
					'image_url' => esc_url(get_template_directory_uri() . '/assets/images/gallery/item3.jpg'),
					'id'        => 'customizer_repeater_instagram_gallery_003',
				),
				array(	
					'image_url' => esc_url(get_template_directory_uri() . '/assets/images/gallery/item4.jpg'),
					'id'        => 'customizer_repeater_instagram_gallery_004',
				),
				array(	
					'image_url' => esc_url(get_template_directory_uri() . '/assets/images/gallery/item5.jpg'),
					'id'        => 'customizer_repeater_instagram_gallery_005',
				),
				array(	
					'image_url' => esc_url(get_template_directory_uri() . '/assets/images/gallery/item6.jpg'),
					'id'        => 'customizer_repeater_instagram_gallery_006',
				),
				
			)
		)
	);
}