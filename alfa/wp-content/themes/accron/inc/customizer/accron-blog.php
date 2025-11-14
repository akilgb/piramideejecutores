<?php
function accron_blog_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Blog  Section
	=========================================*/
	$wp_customize->add_section(
		'blog_setting', array(
			'title' => esc_html__( 'Blog Section', 'accron' ),
			'priority' => 10,
			'panel' => 'accron_frontpage_sections',
		)
	);

	// Setting Head
	$wp_customize->add_setting(
		'blog_setting_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'blog_setting_head',
		array(
			'type' => 'hidden',
			'label' => __('Setting','accron'),
			'section' => 'blog_setting',
		)
	);
	
	// Hide / Show 
	$wp_customize->add_setting(
		'blog_hs'
			,array(
			'default'     	=> '1',	
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'blog_hs',
		array(
			'type' => 'checkbox',
			'label' => __('Hide / Show','accron'),
			'section' => 'blog_setting',
		)
	);
	
	// Blog Header Section // 
	$wp_customize->add_setting(
		'blog_headings'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 3,
		)
	);

	$wp_customize->add_control(
	'blog_headings',
		array(
			'type' => 'hidden',
			'label' => __('Header','accron'),
			'section' => 'blog_setting',
		)
	);
	
	// Blog Title // 
	$wp_customize->add_setting(
    	'blog_title',
    	array(
			'default'			=> __('Our Blog','accron'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 4,
		)
	);	
	
	$wp_customize->add_control( 
		'blog_title',
		array(
		    'label'   => __('Title','accron'),
		    'section' => 'blog_setting',
			'type'           => 'text',
		)  
	);
	
	// Blog Subtitle // 
	$wp_customize->add_setting(
    	'blog_subtitle',
    	array(
			'default'			=> __('Outstanding Blog','accron'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 4,
		)
	);	
	
	$wp_customize->add_control( 
		'blog_subtitle',
		array(
		    'label'   => __('Subtitle','accron'),
		    'section' => 'blog_setting',
			'type'           => 'text',
		)  
	);
	
	// Blog Description // 
	$wp_customize->add_setting(
    	'blog_description',
    	array(
			'default'			=> __('Blog','accron'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_html',
			'transport'         => $selective_refresh,
			'priority' => 6,
		)
	);	
	
	$wp_customize->add_control( 
		'blog_description',
		array(
		    'label'   => __('Description','accron'),
		    'section' => 'blog_setting',
			'type'           => 'textarea',
		)  
	);

	// Blog content Section // 
	
	$wp_customize->add_setting(
		'blog_content_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 7,
		)
	);

	$wp_customize->add_control(
	'blog_content_head',
		array(
			'type' => 'hidden',
			'label' => __('Content','accron'),
			'section' => 'blog_setting',
		)
	);
	
	// blog_display_num
	if ( class_exists( 'Cleverfox_Customizer_Range_Slider_Control' ) ) {
		$wp_customize->add_setting(
			'blog_display_num',
			array(
				'default' => '3',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'accron_sanitize_range_value',
				'priority' => 8,
			)
		);
		$wp_customize->add_control( 
		new Cleverfox_Customizer_Range_Slider_Control( $wp_customize, 'blog_display_num', 
			array(
				'label'      => __( 'No of Posts Display', 'accron' ),
				'section'  => 'blog_setting',
				 'input_attrs' => array(
					'min'    => 1,
					'max'    => 500,
					'step'   => 1,
					//'suffix' => 'px', //optional suffix
				),
			) ) 
		);
	}
}

add_action( 'customize_register', 'accron_blog_setting' );

// blog selective refresh
function home_blog_section_partials( $wp_customize ){	
	// blog title
	$wp_customize->selective_refresh->add_partial( 'blog_title', array(
		'selector'            => '.blog-section .section-title h3',
		'settings'            => 'blog_title',
		'render_callback'  => 'blog_title_render_callback',
	) );
	// blog title
	$wp_customize->selective_refresh->add_partial( 'blog_subtitle', array(
		'selector'            => '.blog-section .section-title h3',
		'settings'            => 'blog_subtitle',
		'render_callback'  => 'blog_subtitle_render_callback',
	) );
	
	// blog description
	$wp_customize->selective_refresh->add_partial( 'blog_description', array(
		'selector'            => '.blog-section .section-title p',
		'settings'            => 'blog_description',
		'render_callback'  => 'blog_desc_render_callback',
	) );
	
	}

add_action( 'customize_register', 'home_blog_section_partials' );

// blog title
function blog_title_render_callback() {
	return get_theme_mod( 'blog_title' );
}

// blog subtitle
function blog_subtitle_render_callback() {
	return get_theme_mod( 'blog_subtitle' );
}

// blog description
function blog_desc_render_callback() {
	return get_theme_mod( 'blog_description' );
}