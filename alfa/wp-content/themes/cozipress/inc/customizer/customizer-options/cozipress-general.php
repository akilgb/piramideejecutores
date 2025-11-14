<?php
function cozipress_general_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	$wp_customize->add_panel(
		'cozipress_general', array(
			'priority' => 31,
			'title' => esc_html__( 'General', 'cozipress' ),
		)
	);
	
	/*=========================================
	Breadcrumb  Section
	=========================================*/
	$wp_customize->add_section(
		'breadcrumb_setting', array(
			'title' => esc_html__( 'Breadcrumb Section', 'cozipress' ),
			'priority' => 1,
			'panel' => 'cozipress_general',
		)
	);
	
	// Settings
	$wp_customize->add_setting(
		'breadcrumb_settings'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'cozipress_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'breadcrumb_settings',
		array(
			'type' => 'hidden',
			'label' => __('Settings','cozipress'),
			'section' => 'breadcrumb_setting',
			'priority' => 1,
		)
	);
	
	// Breadcrumb Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'hs_breadcrumb' , 
			array(
			'default' => '1',
			'sanitize_callback' => 'cozipress_sanitize_checkbox',
			'capability' => 'edit_theme_options',
			'transport'         => $selective_refresh,
		) 
	);
	
	$wp_customize->add_control(
	'hs_breadcrumb', 
		array(
			'label'	      => esc_html__( 'Hide / Show Section', 'cozipress' ),
			'section'     => 'breadcrumb_setting',
			'settings'    => 'hs_breadcrumb',
			'type'        => 'checkbox',
			'priority' => 2,
		) 
	);
		
	// Background // 
	$wp_customize->add_setting(
		'breadcrumb_bg_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'cozipress_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'breadcrumb_bg_head',
		array(
			'type' => 'hidden',
			'label' => __('Background','cozipress'),
			'section' => 'breadcrumb_setting',
			'priority' => 9,
		)
	);
	
	// Background Image // 
    $wp_customize->add_setting( 
    	'breadcrumb_bg_img' , 
    	array(
			'default' 			=> esc_url(get_template_directory_uri() .'/assets/images/bg/breadcrumbg.jpg'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'cozipress_sanitize_url',
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'breadcrumb_bg_img' ,
		array(
			'label'          => esc_html__( 'Background Image', 'cozipress'),
			'section'        => 'breadcrumb_setting',
			'priority' => 10,
		) 
	));
	
	// Background Attachment // 
	$wp_customize->add_setting( 
		'breadcrumb_back_attach' , 
			array(
			'default' => 'scroll',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'cozipress_sanitize_select',
		) 
	);
	
	$wp_customize->add_control(
	'breadcrumb_back_attach' , 
		array(
			'label'          => __( 'Background Attachment', 'cozipress' ),
			'section'        => 'breadcrumb_setting',
			'type'           => 'select',
			'priority' => 10,
			'choices'        => 
			array(
				'inherit' => __( 'Inherit', 'cozipress' ),
				'scroll' => __( 'Scroll', 'cozipress' ),
				'fixed'   => __( 'Fixed', 'cozipress' )
			) 
		) 
	);
}

add_action( 'customize_register', 'cozipress_general_setting' );


// breadcrumb selective refresh
function cozipress_breadcrumb_section_partials( $wp_customize ){

	// hs_breadcrumb
	$wp_customize->selective_refresh->add_partial(
		'hs_breadcrumb', array(
			'selector' => '#breadcrumb-section',
			'container_inclusive' => true,
			'render_callback' => 'breadcrumb_setting',
			'fallback_refresh' => true,
		)
	);		
	}

add_action( 'customize_register', 'cozipress_breadcrumb_section_partials' );
