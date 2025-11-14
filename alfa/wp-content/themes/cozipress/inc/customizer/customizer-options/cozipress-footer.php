<?php
function cozipress_footer( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	// Footer Panel // 
	$wp_customize->add_panel( 
		'footer_section', 
		array(
			'priority'      => 34,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Footer', 'cozipress'),
		) 
	);
	
	// Footer Background // 
	$wp_customize->add_section(
        'footer_background',
        array(
            'title' 		=> __('Footer Background','cozipress'),
			'panel'  		=> 'footer_section',
			'priority'      => 3,
		)
    );
	
	// Background // 
	$wp_customize->add_setting(
		'footer_bg_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'cozipress_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'footer_bg_head',
		array(
			'type' => 'hidden',
			'label' => __('Background','cozipress'),
			'section' => 'footer_background',
		)
	);
	
	// Background Image // 
    $wp_customize->add_setting( 
    	'footer_bg_img' , 
    	array(
			'default' 			=> esc_url(get_template_directory_uri() .'/assets/images/bg/footer_bg.jpg'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'cozipress_sanitize_url',	
			'priority' => 10,
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'footer_bg_img' ,
		array(
			'label'          => esc_html__( 'Background Image', 'cozipress'),
			'section'        => 'footer_background',
		) 
	));
	
	// Background Attachment // 
	$wp_customize->add_setting( 
		'footer_back_attach' , 
			array(
			'default' => 'scroll',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'cozipress_sanitize_select',
			'priority'  => 10,
		) 
	);
	
	$wp_customize->add_control(
	'footer_back_attach' , 
		array(
			'label'          => __( 'Background Attachment', 'cozipress' ),
			'section'        => 'footer_background',
			'type'           => 'select',
			'choices'        => 
			array(
				'inherit' => __( 'Inherit', 'cozipress' ),
				'scroll' => __( 'Scroll', 'cozipress' ),
				'fixed'   => __( 'Fixed', 'cozipress' )
			) 
		) 
	);	
	
	// Footer Bottom // 
	$wp_customize->add_section(
        'footer_bottom',
        array(
            'title' 		=> __('Footer Bottom','cozipress'),
			'panel'  		=> 'footer_section',
			'priority'      => 3,
		)
    );
	
	// Footer Support 
	$wp_customize->add_setting(
		'footer_btm_support_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'cozipress_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'footer_btm_support_head',
		array(
			'type' => 'hidden',
			'label' => __('Support','cozipress'),
			'section' => 'footer_bottom',
			'priority'  => 1,
		)
	);	
	
	$wp_customize->add_setting( 
		'hide_show_footer_btm_support' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'cozipress_sanitize_checkbox',
			'transport'         => $selective_refresh,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_footer_btm_support', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'cozipress' ),
			'section'     => 'footer_bottom',
			'type'        => 'checkbox',
			'priority'  => 2,
		) 
	);	
	
	// icon // 
	$wp_customize->add_setting(
    	'footer_btm_support_icon',
    	array(
	        'default' => 'fa-phone',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control(new Cozipress_Icon_Picker_Control($wp_customize, 
		'footer_btm_support_icon',
		array(
		    'label'   		=> __('Icon','cozipress'),
		    'section' 		=> 'footer_bottom',
			'iconset' => 'fa',
			'priority'  => 3,
			
		))  
	);	

	// Support Title // 
	$wp_customize->add_setting(
    	'footer_btm_support_ttl',
    	array(
			'sanitize_callback' => 'cozipress_sanitize_text',
			'transport'         => $selective_refresh,
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control( 
		'footer_btm_support_ttl',
		array(
		    'label'   		=> __('Title','cozipress'),
		    'section' 		=> 'footer_bottom',
			'type'		 =>	'text',
			'priority' => 4,
		)  
	);	
	// Support Text // 
	$wp_customize->add_setting(
    	'footer_btm_support_text',
    	array(
			'sanitize_callback' => 'cozipress_sanitize_text',
			'transport'         => $selective_refresh,
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control( 
		'footer_btm_support_text',
		array(
		    'label'   		=> __('Text','cozipress'),
		    'section' 		=> 'footer_bottom',
			'type'		 =>	'textarea',
			'priority' => 5,
		)  
	);
	
	// Footer Copyright Head
	$wp_customize->add_setting(
		'footer_btm_copy_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'cozipress_sanitize_text',
			'priority'  => 3,
		)
	);

	$wp_customize->add_control(
	'footer_btm_copy_head',
		array(
			'type' => 'hidden',
			'label' => __('Copyright','cozipress'),
			'section' => 'footer_bottom',
		)
	);
	
	// Footer Copyright 
	$cozipress_foo_copy = esc_html__('Copyright &copy; [current_year] [site_title] | Powered by [theme_author]', 'cozipress' );
	$wp_customize->add_setting(
    	'footer_copyright',
    	array(
			'default' => $cozipress_foo_copy,
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'wp_kses_post',
			'priority'      => 4,
		)
	);	

	$wp_customize->add_control( 
		'footer_copyright',
		array(
		    'label'   		=> __('Copyright','cozipress'),
		    'section'		=> 'footer_bottom',
			'type' 			=> 'textarea',
			'transport'         => $selective_refresh,
		)  
	);	
	
	
	// Footer Paralax // 
	$wp_customize->add_section(
        'footer_parallax',
        array(
            'title' 		=> __('Footer Parallax','cozipress'),
			'panel'  		=> 'footer_section',
			'priority'      => 8,
		)
    );
	
	// Head // 
	$wp_customize->add_setting(
		'footer_parallax_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'cozipress_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'footer_parallax_head',
		array(
			'type' => 'hidden',
			'label' => __('Settings','cozipress'),
			'section' => 'footer_parallax',
		)
	);
	
	$wp_customize->add_setting( 
		'enable_footer_parallax' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'cozipress_sanitize_checkbox',
			'priority'  => 2,
		) 
	);
	
	$wp_customize->add_control(
	'enable_footer_parallax', 
		array(
			'label'	      => esc_html__( 'Enable / Disable parallax ?', 'cozipress' ),
			'section'     => 'footer_parallax',
			'type'        => 'checkbox',
		) 
	);	
	
	if ( class_exists( 'Burger_Customizer_Range_Control' ) ) {
	// Content Head // 
	$wp_customize->add_setting(
		'footer_parallax_content_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'cozipress_sanitize_text',
			'priority' => 3,
		)
	);

	$wp_customize->add_control(
	'footer_parallax_content_head',
		array(
			'type' => 'hidden',
			'label' => __('Content','cozipress'),
			'section' => 'footer_parallax',
		)
	);
	
	// footer_parallax_margin_bottom
		$wp_customize->add_setting(
			'footer_parallax_margin_bottom',
			array(
				'default' => '586',
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'cozipress_sanitize_range_value',
				'transport'         => $selective_refresh,
				'priority' => 4,
			)
		);
		$wp_customize->add_control( 
		new Burger_Customizer_Range_Control( $wp_customize, 'footer_parallax_margin_bottom', 
			array(
				'label'      => __( 'Margin Bottom', 'cozipress' ),
				'section'  => 'footer_parallax',
				 'input_attrs' => array(
					'min'    => 0,
					'max'    => 1000,
					'step'   => 1,
					//'suffix' => 'px', //optional suffix
				),
			) ) 
		);
	}
}
add_action( 'customize_register', 'cozipress_footer' );
// Footer selective refresh
function cozipress_footer_partials( $wp_customize ){
	
	// hide_show_footer_btm_support
	$wp_customize->selective_refresh->add_partial(
		'hide_show_footer_btm_support', array(
			'selector' => '.footer-copyright .widget-contact',
			'container_inclusive' => true,
			'render_callback' => 'footer_bottom',
			'fallback_refresh' => true,
		)
	);
	
	// footer_btm_support_ttl
	$wp_customize->selective_refresh->add_partial( 'footer_btm_support_ttl', array(
		'selector'            => '.footer-copyright .widget-contact h6',
		'settings'            => 'footer_btm_support_ttl',
		'render_callback'  => 'cozipress_footer_btm_support_ttl_render_callback',
	) );
	
	// footer_btm_support_text
	$wp_customize->selective_refresh->add_partial( 'footer_btm_support_text', array(
		'selector'            => '.footer-copyright .widget-contact p',
		'settings'            => 'footer_btm_support_text',
		'render_callback'  => 'cozipress_footer_btm_support_text_render_callback',
	) );
	
	// footer_copyright
	$wp_customize->selective_refresh->add_partial( 'footer_copyright', array(
		'selector'            => '#footer-section .footer-copyright .copyright-text',
		'settings'            => 'footer_copyright',
		'render_callback'  => 'cozipress_footer_copyright_render_callback',
	) );
	
	}

add_action( 'customize_register', 'cozipress_footer_partials' );

// footer_btm_support_ttl
function cozipress_footer_btm_support_ttl_render_callback() {
	return get_theme_mod( 'footer_btm_support_ttl' );
}
// footer_btm_support_text
function cozipress_footer_btm_support_text_render_callback() {
	return get_theme_mod( 'footer_btm_support_text' );
}

// copyright_content
function cozipress_footer_copyright_render_callback() {
	return get_theme_mod( 'footer_copyright' );
}