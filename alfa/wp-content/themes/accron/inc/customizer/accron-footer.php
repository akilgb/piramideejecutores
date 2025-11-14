<?php
function accron_footer( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	// Footer Panel // 
	$wp_customize->add_panel( 
		'footer_section', 
		array(
			'priority'      => 34,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Footer', 'accron'),
		) 
	);
	// Footer Setting Section // 
	$wp_customize->add_section(
        'footer_copy_Section',
        array(
            'title' 		=> __('Below Footer','accron'),
			'panel'  		=> 'footer_section',
			'priority'      => 4,
		)
    );

	// Image Head // 
	$wp_customize->add_setting(
		'footer_copy_img'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
		)
	);

	$wp_customize->add_control(
	'footer_copy_img',
		array(
			'type' => 'hidden',
			'label' => __('Logo','accron'),
			'section' => 'footer_copy_Section',
			'priority' => 1,
		)
	);

	
	// footer third text // 
	$accron_footer_copyright = esc_html__('Copyright &copy; [current_year] [site_title] | Powered by [theme_author]', 'accron' );
	$wp_customize->add_setting(
    	'footer_first_custom',
    	array(
			'default' => $accron_footer_copyright,
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_html',
		)
	);	

	$wp_customize->add_control( 
		'footer_first_custom',
		array(
		    'label'   		=> __('Copyright','accron'),
		    'section'		=> 'footer_copy_Section',
			'type' 			=> 'textarea',
			'priority'      => 9,
		)  
	);	
	
	///Footer Contact 	
	$wp_customize->add_section(
        'footer_contact_Section',
        array(
            'title' 		=> __('Contact Footer','accron'),
			'panel'  		=> 'footer_section',
			'priority'      => 4,
		)
    );
	
	// Background Image // 
    $wp_customize->add_setting( 
    	'footer_bg_img' , 
    	array(
			// 'default' 			=> esc_url(get_template_directory_uri() .'/assets/images/bg-footer.jpg'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_url',	
			'priority' => 10,
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'footer_bg_img' ,
		array(
			'label'          => esc_html__( 'Background Image', 'accron'),
			'section'        => 'footer_contact_Section',
		) 
	));	
	
	
	// ------
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if (function_exists('is_plugin_active')) {
	if(is_plugin_active('clever-fox/clever-fox.php')) {
	
	/* Footer Phone */		
	$wp_customize->add_setting(
		'footer_phone'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 16,
		)
	);

	$wp_customize->add_control(
	'footer_phone',
		array(
			'type' => 'hidden',
			'label' => __('Phone','accron'),
			'section' => 'footer_contact_Section',
			
		)
	);
		
	$wp_customize->add_setting( 
		'hide_show_footer_mbl_details' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'priority' => 17,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_footer_mbl_details', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'accron' ),
			'section'     => 'footer_contact_Section',
			'type'        => 'checkbox'
		) 
	);	
	// icon // 
	$wp_customize->add_setting(
    	'footer_get_in_touch_icon',
    	array(
	        // 'default' => 'fa-map-marker-alt',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control(new Accron_Icon_Picker_Control($wp_customize, 
		'footer_get_in_touch_icon',
		array(
		    'label'   		=> __('Icon','accron'),
		    'section' 		=> 'footer_contact_Section',
			'iconset' => 'fa',
			
		))  
	);
	
	// Phone title // 
	$wp_customize->add_setting(
    	'footer_get_in_touch_title',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 18,
		)
	);	

	$wp_customize->add_control( 
		'footer_get_in_touch_title',
		array(
		    'label'   		=> __('Phone Title','accron'),
		    'section' 		=> 'footer_contact_Section',
			'type'		 =>	'text'
		)  
	);
	
	// Number // 
	$wp_customize->add_setting(
    	'footer_get_in_touch_number',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 18,
		)
	);	

	$wp_customize->add_control( 
		'footer_get_in_touch_number',
		array(
		    'label'   		=> __('Phone Number','accron'),
		    'section' 		=> 'footer_contact_Section',
			'type'		 =>	'text'
		)  
	);
	
	/*===== Email ====== */
	$wp_customize->add_setting(
		'footer_email_heading'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 17,
		)
	);

	$wp_customize->add_control(
	'footer_email_heading',
		array(
			'type' => 'hidden',
			'label' => __('Email','accron'),
			'section' => 'footer_contact_Section',
			
		)
	);
		
	$wp_customize->add_setting( 
		'hide_show_footer_email_details' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'priority' => 17,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_footer_email_details', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'accron' ),
			'section'     => 'footer_contact_Section',
			'type'        => 'checkbox'
		) 
	);	
	
	// icon // 
	$wp_customize->add_setting(
    	'footer_email_icon',
    	array(
	        // 'default' => 'fa-map-marker-alt',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control(new Accron_Icon_Picker_Control($wp_customize, 
		'footer_email_icon',
		array(
		    'label'   		=> __('Icon','accron'),
		    'section' 		=> 'footer_contact_Section',
			'iconset' => 'fa',
			
		))  
	);
	
	// Email title // 
	$wp_customize->add_setting(
    	'footer_email_title',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 18,
		)
	);	

	$wp_customize->add_control( 
		'footer_email_title',
		array(
		    'label'   		=> __('Email Title','accron'),
		    'section' 		=> 'footer_contact_Section',
			'type'		 =>	'text'
		)  
	);
	
	// Address // 
	$wp_customize->add_setting(
    	'footer_email',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 18,
		)
	);	

	$wp_customize->add_control( 
		'footer_email',
		array(
		    'label'   		=> __('Email Address','accron'),
		    'section' 		=> 'footer_contact_Section',
			'type'		 =>	'text'
		)  
	);
	
	/*===== Contact Address ====== */
	$wp_customize->add_setting(
		'footer_address'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 16,
		)
	);

	$wp_customize->add_control(
	'footer_address',
		array(
			'type' => 'hidden',
			'label' => __('Address','accron'),
			'section' => 'footer_contact_Section',
			
		)
	);
		
	$wp_customize->add_setting( 
		'hide_show_footer_cntct_details' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'priority' => 17,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_footer_cntct_details', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'accron' ),
			'section'     => 'footer_contact_Section',
			'type'        => 'checkbox'
		) 
	);	
	
	// icon // 
	$wp_customize->add_setting(
    	'footer_contct_icon',
    	array(
	        // 'default' => 'fa-map-marker-alt',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control(new Accron_Icon_Picker_Control($wp_customize, 
		'footer_contct_icon',
		array(
		    'label'   		=> __('Icon','accron'),
		    'section' 		=> 'footer_contact_Section',
			'iconset' => 'fa',
			
		))  
	);
	
	// Address title // 
	$wp_customize->add_setting(
    	'footer_address_title',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 18,
		)
	);	

	$wp_customize->add_control( 
		'footer_address_title',
		array(
		    'label'   		=> __('Address Title','accron'),
		    'section' 		=> 'footer_contact_Section',
			'type'		 =>	'text'
		)  
	);
	
	// Address // 
	$wp_customize->add_setting(
    	'footer_contact_address',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 18,
		)
	);	

	$wp_customize->add_control( 
		'footer_contact_address',
		array(
		    'label'   		=> __('Contact Address','accron'),
		    'section' 		=> 'footer_contact_Section',
			'type'		 =>	'text'
		)  
	);
}
}

	// Footer Widget // 
	$wp_customize->add_section(
        'footer_widget',
        array(
            'title' 		=> __('Footer Widget Area','accron'),
			'panel'  		=> 'footer_section',
			'priority'      => 3,
		)
    );
	
}
add_action( 'customize_register', 'accron_footer' );
// Footer selective refresh
function accron_footer_partials( $wp_customize ){		
	// footer_first_custom
	$wp_customize->selective_refresh->add_partial( 'footer_first_custom', array(
		'selector'            => '.footer-copyright .copyright-text',
		'settings'            => 'footer_first_custom',
		'render_callback'  => 'accron_footer_first_custom_render_callback',
	) );
	
	// footer address
	$wp_customize->selective_refresh->add_partial( 'footer_contact_address', array(
		'selector'            => '.footer-section .footer-middle [class*= "col"]:first-child ',
		'settings'            => 'footer_contact_address',
		'render_callback'  => 'accron_footer_address_render_callback',
	) );
	
	//footer_widget_middle_content
	$wp_customize->selective_refresh->add_partial( 'footer_widget_middle_content', array(
		'selector'            => '.footer-main .footer-info-overwrap',
		'settings'            => 'footer_widget_middle_content',
		'render_callback'  => 'accron_footer_widget_middle_content_render_callback',
	) );
	}

add_action( 'customize_register', 'accron_footer_partials' );


// copyright_content
function accron_footer_first_custom_render_callback() {
	return get_theme_mod( 'footer_first_custom' );
}

// footer_widget_middle_content
function accron_footer_widget_middle_content_render_callback() {
	return get_theme_mod( 'footer_widget_middle_content' );
}

// footer address
function accron_footer_address_render_callback() {
	return get_theme_mod( 'footer_contact_address' );
}