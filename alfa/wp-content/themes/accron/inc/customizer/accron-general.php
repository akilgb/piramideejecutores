<?php
function accron_general_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	$wp_customize->add_panel(
		'accron_general', array(
			'priority' => 31,
			'title' => esc_html__( 'General', 'accron' ),
		)
	);
	
	
	/*=========================================
	Scroller
	=========================================*/
	$wp_customize->add_section(
		'top_scroller', array(
			'title' => esc_html__( 'Scroller', 'accron' ),
			'priority' => 4,
			'panel' => 'accron_general',
		)
	);
	
	$wp_customize->add_setting( 
		'hs_scroller' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 1,
		) 
	);
	
	$wp_customize->add_control(
	'hs_scroller', 
		array(
			'label'	      => esc_html__( 'Hide / Show Scroller', 'accron' ),
			'section'     => 'top_scroller',
			'type'        => 'checkbox'
		) 
	);
	
	/*=========================================
	Breadcrumb  Section
	=========================================*/
	$wp_customize->add_section(
		'breadcrumb_setting', array(
			'title' => esc_html__( 'Breadcrumb', 'accron' ),
			'priority' => 12,
			'panel' => 'accron_general',
		)
	);
	
	// Settings
	$wp_customize->add_setting(
		'breadcrumb_settings'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'breadcrumb_settings',
		array(
			'type' => 'hidden',
			'label' => __('Settings','accron'),
			'section' => 'breadcrumb_setting',
		)
	);
	
	// Breadcrumb Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'hs_breadcrumb' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'hs_breadcrumb', 
		array(
			'label'	      => esc_html__( 'Hide / Show Section', 'accron' ),
			'section'     => 'breadcrumb_setting',
			'type'        => 'checkbox'
		) 
	);
	
	// enable Effect
	$wp_customize->add_setting(
		'breadcrumb_effect_enable'
			,array(
			'default' => '1',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'priority' => 4,
		)
	);

	$wp_customize->add_control(
	'breadcrumb_effect_enable',
		array(
			'type' => 'checkbox',
			'label' => __('Enable Blur Effect on Breadcrumb?','accron'),
			'section' => 'breadcrumb_setting',
		)
	);
	
	
		
	// Background // 
	$wp_customize->add_setting(
		'breadcrumb_bg_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 9,
		)
	);

	$wp_customize->add_control(
	'breadcrumb_bg_head',
		array(
			'type' => 'hidden',
			'label' => __('Background','accron'),
			'section' => 'breadcrumb_setting',
		)
	);
	
	// Background Image // 
    $wp_customize->add_setting( 
    	'breadcrumb_bg_img' , 
    	array(
			'default' 			=> esc_url(get_template_directory_uri() .'/assets/images/breadcrumb.jpg'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_url',	
			'priority' => 10,
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'breadcrumb_bg_img' ,
		array(
			'label'          => esc_html__( 'Background Image', 'accron'),
			'section'        => 'breadcrumb_setting',
		) 
	));
	
	// Background Attachment // 
	// $wp_customize->add_setting( 
		// 'breadcrumb_back_attach' , 
			// array(
			// 'default' => 'scroll',
			// 'capability'     => 'edit_theme_options',
			// 'sanitize_callback' => 'accron_sanitize_select',
			// 'priority'  => 10,
		// ) 
	// );
	
	// $wp_customize->add_control(
	// 'breadcrumb_back_attach' , 
		// array(
			// 'label'          => __( 'Background Attachment', 'accron' ),
			// 'section'        => 'breadcrumb_setting',
			// 'type'           => 'select',
			// 'choices'        => 
			// array(
				// 'inherit' => __( 'Inherit', 'accron' ),
				// 'scroll' => __( 'Scroll', 'accron' ),
				// 'fixed'   => __( 'Fixed', 'accron' )
			// ) 
		// ) 
	// );
	
	
	$wp_customize->add_setting(
	'breadcrumb_overlay_color', 
	array(
		'default' => '#000000',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'priority'  => 12,
    ));
	
	$wp_customize->add_control( 
		new WP_Customize_Color_Control
		($wp_customize, 
			'breadcrumb_overlay_color', 
			array(
				'label'      => __( 'Overlay Color', 'accron'),
				'section'    => 'breadcrumb_setting',
			) 
		) 
	);
	
	// Image Opacity // 
	if ( class_exists( 'Accron_Customizer_Range_Control' ) ) {
	$wp_customize->add_setting(
    	'breadcrumb_bg_img_opacity',
    	array(
	        'default'			=> '0.75',
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_pro_sanitize_range_value',
			'priority'  => 11,
		)
	);
	$wp_customize->add_control( 
	new Accron_Customizer_Range_Control( $wp_customize, 'breadcrumb_bg_img_opacity', 
		array(
			'label'      => __( 'Opacity', 'accron'),
			'section'  => 'breadcrumb_setting',
			'settings' => 'breadcrumb_bg_img_opacity',
			 'media_query'   => false,
                'input_attr'    => array(
                    'desktop' => array(
                        'min'           => 0,
                        'max'           => 1,
                        'step'          => 0.1,
                        'default_value' => 0.6,
                    ),
                ),
		) ) 
	);
	}
	
	
	/*=========================================
	Accron Container
	=========================================*/
	$wp_customize->add_section(
        'accron_container',
        array(
        	'priority'      => 2,
            'title' 		=> __('Container','accron'),
			'panel'  		=> 'accron_general',
		)
    );
	
	if ( class_exists( 'Cleverfox_Customizer_Range_Slider_Control' ) ) {
		//container width
		$wp_customize->add_setting(
			'accron_site_cntnr_width',
			array(
				'default'			=> '1320',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'accron_sanitize_range_value',
				'transport'         => 'postMessage',
				'priority'      => 1,
			)
		);
		$wp_customize->add_control( 
		new Cleverfox_Customizer_Range_Slider_Control( $wp_customize, 'accron_site_cntnr_width', 
			array(
				'label'      => __( 'Container Width', 'accron' ),
				'section'  => 'accron_container',
				'input_attrs' => array(
					 'min'           => 768,
					'max'           => 2000,
					'step'          => 1,
					//'suffix' => 'px', //optional suffix
				),
			) ) 
		);
		
	}
}

add_action( 'customize_register', 'accron_general_setting' );
