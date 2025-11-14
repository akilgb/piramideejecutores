<?php
function accron_header_settings( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Header Settings Panel
	=========================================*/
	$wp_customize->add_panel( 
		'header_section', 
		array(
			'priority'      => 2,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Header', 'accron'),
		) 
	);
	
	/*=========================================
	Accron Pro Site Identity
	=========================================*/

	$wp_customize->add_section(
        'title_tagline',
        array(
        	'priority'      => 1,
            'title' 		=> __('Site Identity','accron'),
			'panel'  		=> 'header_section',
		)
    );

	//Project Documentation Link
	class WP_title_tagline_Customize_Control extends WP_Customize_Control {
	public $type = 'new_menu';

	   function render_content()
	   
	   {
	   ?>
			<h3>How to use site identity section :</h3>
			<p>Header > site identity Section <br><br> <a href="#" style="background-color:#0083E3; color:#fff;display: flex;align-items: center;justify-content: center;text-decoration: none;   font-weight: 600;padding: 15px 10px;">Click Here</a></p>
			
		<?php
	   }
	}
	
	// Project Doc Link // 
	$wp_customize->add_setting( 
		'title_tagline_doc_link' , 
			array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);

	$wp_customize->add_control(new WP_title_tagline_Customize_Control($wp_customize,
	'title_tagline_doc_link' , 
		array(
			'label'          => __( 'Site identity Documentation Link', 'accron' ),
			'section'        => 'title_tagline',
			'type'           => 'radio',
			'description'    => __( 'Site identity Documentation Link', 'accron' ), 
		) 
	) );

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if (function_exists('is_plugin_active')) {
	if (is_plugin_active('clever-fox/clever-fox.php')) {

	/*=========================================
	Above Header Section
	=========================================*/
	$wp_customize->add_section(
        'above_header',
        array(
        	'priority'      => 2,
            'title' 		=> __('Above Header','accron'),
			'panel'  		=> 'header_section',
		)
    );
	
	/* Sidebar Option */
	$wp_customize->add_setting(
		'hdr_docker'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 16,
		)
	);

	$wp_customize->add_control(
	'hdr_docker',
		array(
			'type' => 'hidden',
			'label' => __('Header Docker','accron'),
			'section' => 'above_header',
			
		)
	);
	
	// About Text // 
	$wp_customize->add_setting(
    	'tlh_about_text',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 14,
		)
	);	

	$wp_customize->add_control( 
		'tlh_about_text',
		array(
		    'label'   		=> __('About Text','accron'),
		    'section' 		=> 'above_header',
			'type'		 =>	'text'
		)  
	);
	
	// About Description // 
	$wp_customize->add_setting(
    	'tlh_about_desc',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 14,
		)
	);	

	$wp_customize->add_control( 
		'tlh_about_desc',
		array(
		    'label'   		=> __('About Description','accron'),
		    'section' 		=> 'above_header',
			'type'		 	=>	'textarea'
		)  
	);
	
	// Gallery Title // 
	$wp_customize->add_setting(
    	'tlh_gallery_text',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 14,
		)
	);	

	$wp_customize->add_control( 
		'tlh_gallery_text',
		array(
		    'label'   		=> __('Gallery Title','accron'),
		    'section' 		=> 'above_header',
			'type'		 =>	'text'
		)  
	);
	
	/**
	 * Customizer Repeater
	 */
		$wp_customize->add_setting( 'instagram_gallery', 
			array(
			 'sanitize_callback' => 'accron_repeater_sanitize',
			 'priority' => 2,
			 'default' => accron_get_instagram_gallery_default()
		)
		);
	
	//Header instagram Documentation Link
	class WP_instagram_section_Customize_Control extends WP_Customize_Control {
	public $type = 'new_menu';

	   function render_content()
	   
	   {
	   ?>
			<h3>How to Add Instagram gallery section :</h3>
			<p>Customizer > Header > Instagram gallery Section <br><br> <a href="#" style="background-color:#0083E3; color:#fff;display: flex;align-items: center;justify-content: center;text-decoration: none;   font-weight: 600;padding: 15px 10px;">Click Here</a></p>
			
		<?php
	   }
	}
	
	// Header instagram Doc Link // 
	$wp_customize->add_setting( 
		'instagram_doc_link' , 
			array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);

	$wp_customize->add_control(new WP_instagram_section_Customize_Control($wp_customize,
	'instagram_doc_link' , 
		array(
			'label'          => __( 'Instagram Documentation Link', 'accron' ),
			'section'        => 'above_header',
			'type'           => 'radio',
			'description'    => __( 'Instagram Documentation Link', 'accron' ), 
		) 
	) );
		
		$wp_customize->add_control( 
			new Accron_Repeater( $wp_customize, 
				'instagram_gallery', 
					array(
						'label'   => esc_html__('Instagram Gallery','accron'),
						'section' => 'above_header',
						'customizer_repeater_image_control' => true,
					) 
				) 
			);
	
	/*=========================================
	Mobile
	=========================================*/
	$wp_customize->add_setting(
		'hdr_top_mbl'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 16,
		)
	);

	$wp_customize->add_control(
	'hdr_top_mbl',
		array(
			'type' => 'hidden',
			'label' => __('Phone','accron'),
			'section' => 'above_header',
			
		)
	);

	//Header Mobile Details Link Documentation Link
	class WP_mbl_details_section_Customize_Control extends WP_Customize_Control {
	public $type = 'new_menu';

	   function render_content()
	   
	   {
	   ?>
			<h3>How to Add Mobile Details section :</h3>
			<p>Customizer > Above Header > Phone <br><br> <a href="#" style="background-color:#0083E3; color:#fff;display: flex;align-items: center;justify-content: center;text-decoration: none;   font-weight: 600;padding: 15px 10px;">Click Here</a></p>
			
		<?php
	   }
	}
	
	// Header Doc Link // 
	$wp_customize->add_setting( 
		'mbl_details_doc_link' , 
			array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);

	$wp_customize->add_control(new WP_mbl_details_section_Customize_Control($wp_customize,
	'mbl_details_doc_link' , 
		array(
			'label'          => __( 'Mobile Details Documentation Link', 'accron' ),
			'section'        => 'above_header',
			'type'           => 'radio',
			'description'    => __( 'Mobile Details Documentation Link', 'accron' ), 
		) 
	) );


	$wp_customize->add_setting( 
		'hide_show_mbl_details' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'priority' => 17,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_mbl_details', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'accron' ),
			'section'     => 'above_header',
			'type'        => 'checkbox'
		) 
	);	
	// icon // 
	$wp_customize->add_setting(
    	'tlh_mobile_icon',
    	array(
	        // 'default' => 'fa-phone-alt',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control(new Accron_Icon_Picker_Control($wp_customize, 
		'tlh_mobile_icon',
		array(
		    'label'   		=> __('Icon','accron'),
		    'section' 		=> 'above_header',
			'iconset' => 'fa',
			
		))  
	);
	
	// Mobile title // 
	$wp_customize->add_setting(
    	'tlh_mobile_title',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 18,
		)
	);	

	$wp_customize->add_control( 
		'tlh_mobile_title',
		array(
		    'label'   		=> __('Phone Title','accron'),
		    'section' 		=> 'above_header',
			'type'		 =>	'text'
		)  
	);
	
	// Mobile Number // 
	$wp_customize->add_setting(
    	'tlh_mobile_number',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 18,
		)
	);	

	$wp_customize->add_control( 
		'tlh_mobile_number',
		array(
		    'label'   		=> __('Phone Number','accron'),
		    'section' 		=> 'above_header',
			'type'		 =>	'text'
		)  
	);	
	
	
	/*=========================================
	Email
	=========================================*/
	$wp_customize->add_setting(
		'hdr_top_email'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 16,
		)
	);

	$wp_customize->add_control(
	'hdr_top_email',
		array(
			'type' => 'hidden',
			'label' => __('Email','accron'),
			'section' => 'above_header',
			
		)
	);

	//Header Mobile Details Link Documentation Link
	class WP_email_details_section_Customize_Control extends WP_Customize_Control {
	public $type = 'new_menu';

	   function render_content()
	   
	   {
	   ?>
			<h3>How to Add Email Details section :</h3>
			<p>Customizer > Above Header > Email <br><br> <a href="#" style="background-color:#0083E3; color:#fff;display: flex;align-items: center;justify-content: center;text-decoration: none;   font-weight: 600;padding: 15px 10px;">Click Here</a></p>
			
		<?php
	   }
	}
	
	// Header Doc Link // 
	$wp_customize->add_setting( 
		'email_details_doc_link' , 
			array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);

	$wp_customize->add_control(new WP_email_details_section_Customize_Control($wp_customize,
	'email_details_doc_link' , 
		array(
			'label'          => __( 'Email Details Documentation Link', 'accron' ),
			'section'        => 'above_header',
			'type'           => 'radio',
			'description'    => __( 'Email Details Documentation Link', 'accron' ), 
		) 
	) );


	$wp_customize->add_setting( 
		'hide_show_email_details' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'priority' => 17,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_email_details', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'accron' ),
			'section'     => 'above_header',
			'type'        => 'checkbox'
		) 
	);	
	// icon // 
	$wp_customize->add_setting(
    	'tlh_email_icon',
    	array(
	        // 'default' => 'fa-envelope',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control(new Accron_Icon_Picker_Control($wp_customize, 
		'tlh_email_icon',
		array(
		    'label'   		=> __('Icon','accron'),
		    'section' 		=> 'above_header',
			'iconset' => 'fa',
			
		))  
	);
	
	// Email title // 
	$wp_customize->add_setting(
    	'tlh_email_title',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 18,
		)
	);	

	$wp_customize->add_control( 
		'tlh_email_title',
		array(
		    'label'   		=> __('Email Title','accron'),
		    'section' 		=> 'above_header',
			'type'		 =>	'text'
		)  
	);
	
	// Mobile Number // 
	$wp_customize->add_setting(
    	'tlh_email',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 18,
		)
	);	

	$wp_customize->add_control( 
		'tlh_email',
		array(
		    'label'   		=> __('Email Address','accron'),
		    'section' 		=> 'above_header',
			'type'		 =>	'text'
		)  
	);
	
	/*=========================================
	Address
	=========================================*/
	$wp_customize->add_setting(
		'hdr_top_address'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 16,
		)
	);

	$wp_customize->add_control(
	'hdr_top_address',
		array(
			'type' => 'hidden',
			'label' => __('Address','accron'),
			'section' => 'above_header',
			
		)
	);

	//Header Address Details Link Documentation Link
	class WP_address_details_section_Customize_Control extends WP_Customize_Control {
	public $type = 'new_menu';

	   function render_content()
	   
	   {
	   ?>
			<h3>How to Add Address Details section :</h3>
			<p>Customizer > Above Header > Address <br><br> <a href="#" style="background-color:#0083E3; color:#fff;display: flex;align-items: center;justify-content: center;text-decoration: none;   font-weight: 600;padding: 15px 10px;">Click Here</a></p>
			
		<?php
	   }
	}
	
	// Header Doc Link // 
	$wp_customize->add_setting( 
		'address_details_doc_link' , 
			array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);

	$wp_customize->add_control(new WP_address_details_section_Customize_Control($wp_customize,
	'address_details_doc_link' , 
		array(
			'label'          => __( 'Address Details Documentation Link', 'accron' ),
			'section'        => 'above_header',
			'type'           => 'radio',
			'description'    => __( 'Address Details Documentation Link', 'accron' ), 
		) 
	) );


	$wp_customize->add_setting( 
		'hide_show_cntct_details' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'priority' => 17,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_cntct_details', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'accron' ),
			'section'     => 'above_header',
			'type'        => 'checkbox'
		) 
	);	
	// icon // 
	$wp_customize->add_setting(
    	'tlh_contct_icon',
    	array(
	        // 'default' => 'fa-map-marker-alt',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control(new Accron_Icon_Picker_Control($wp_customize, 
		'tlh_contct_icon',
		array(
		    'label'   		=> __('Icon','accron'),
		    'section' 		=> 'above_header',
			'iconset' => 'fa',
			
		))  
	);
	
	// Address title // 
	$wp_customize->add_setting(
    	'tlh_address_title',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 18,
		)
	);	

	$wp_customize->add_control( 
		'tlh_address_title',
		array(
		    'label'   		=> __('Address Title','accron'),
		    'section' 		=> 'above_header',
			'type'		 =>	'text'
		)  
	);
	
	// Address // 
	$wp_customize->add_setting(
    	'tlh_contact_address',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 18,
		)
	);	

	$wp_customize->add_control( 
		'tlh_contact_address',
		array(
		    'label'   		=> __('Contact Address','accron'),
		    'section' 		=> 'above_header',
			'type'		 =>	'text'
		)  
	);
	
	/*=========================================
	Office Hours
	=========================================*/
	$wp_customize->add_setting(
		'hdr_top_office_hours'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 16,
		)
	);

	$wp_customize->add_control(
	'hdr_top_office_hours',
		array(
			'type' => 'hidden',
			'label' => __('Office Hours','accron'),
			'section' => 'above_header',
			
		)
	);

	//Header Address Details Link Documentation Link
	class WP_office_hours_details_section_Customize_Control extends WP_Customize_Control {
	public $type = 'new_menu';

	   function render_content()
	   
	   {
	   ?>
			<h3>How to Add Office Hours Details section :</h3>
			<p>Customizer > Above Header > Office Hours <br><br> <a href="#" style="background-color:#0083E3; color:#fff;display: flex;align-items: center;justify-content: center;text-decoration: none;   font-weight: 600;padding: 15px 10px;">Click Here</a></p>
			
		<?php
	   }
	}
	
	// Header Doc Link // 
	$wp_customize->add_setting( 
		'office_hours_details_doc_link' , 
			array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);

	$wp_customize->add_control(new WP_office_hours_details_section_Customize_Control($wp_customize,
	'office_hours_details_doc_link' , 
		array(
			'label'          => __( 'Address Details Documentation Link', 'accron' ),
			'section'        => 'above_header',
			'type'           => 'radio',
			'description'    => __( 'Address Details Documentation Link', 'accron' ), 
		) 
	) );


	$wp_customize->add_setting( 
		'hide_show_office_hours_details' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'priority' => 17,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_office_hours_details', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'accron' ),
			'section'     => 'above_header',
			'type'        => 'checkbox'
		) 
	);	
	// icon // 
	$wp_customize->add_setting(
    	'tlh_office_hours_icon',
    	array(
	        // 'default' => 'fa-clock',
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control(new Accron_Icon_Picker_Control($wp_customize, 
		'tlh_office_hours_icon',
		array(
		    'label'   		=> __('Icon','accron'),
		    'section' 		=> 'above_header',
			'iconset' => 'fa',
			
		))  
	);
	
	// Address title // 
	$wp_customize->add_setting(
    	'tlh_office_hours_title',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 18,
		)
	);	

	$wp_customize->add_control( 
		'tlh_office_hours_title',
		array(
		    'label'   		=> __('Office Hours Title','accron'),
		    'section' 		=> 'above_header',
			'type'		 =>	'text'
		)  
	);
	
	// Mobile Number // 
	$wp_customize->add_setting(
    	'tlh_office_hours',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' => 'edit_theme_options',
			'priority' => 18,
		)
	);	

	$wp_customize->add_control( 
		'tlh_office_hours',
		array(
		    'label'   		=> __('Office Hours','accron'),
		    'section' 		=> 'above_header',
			'type'		 =>	'text'
		)  
	);	
	
	// Button Label // 
	$wp_customize->add_setting(
    	'tlh_btn_lbl',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 5,
		)
	);	

	$wp_customize->add_control( 
		'tlh_btn_lbl',
		array(
		    'label'   		=> __('Button Label','accron'),
		    'section' 		=> 'above_header',
			'type'		 	=>	'text'
		)  
	);
	
	// Button Link // 
	$wp_customize->add_setting(
    	'tlh_btn_link',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 5,
		)
	);	

	$wp_customize->add_control( 
		'tlh_btn_link',
		array(
		    'label'   		=> __('Button Link','accron'),
		    'section' 		=> 'above_header',
			'type'		 	=>	'text'
		)  
	);
}}	
	
	/*=========================================
	Appointment Section
	=========================================*/
	$wp_customize->add_setting(
		'hdr_top_appointment'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 3,
		)
	);

	$wp_customize->add_control(
	'hdr_top_appointment',
		array(
			'type' => 'hidden',
			'label' => __('Appointment','accron'),
			'section' => 'above_header',
		)
	);

		//Header Office Timing Link Documentation Link
	class WP_appointment_section_Customize_Control extends WP_Customize_Control {
	public $type = 'new_menu';

	   function render_content()
	   
	   {
	   ?>
			<h3>How to Add Appointment section :</h3>
			<p>Customizer > Above Header > Appointment <br><br> <a href="#" style="background-color:#0083E3; color:#fff;display: flex;align-items: center;justify-content: center;text-decoration: none;   font-weight: 600;padding: 15px 10px;">Click Here</a></p>
			
		<?php
	   }
	}
	
	// Header Doc Link // 
	$wp_customize->add_setting( 
		'appointment_doc_link' , 
			array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);

	$wp_customize->add_control(new WP_appointment_section_Customize_Control($wp_customize,
	'appointment_doc_link' , 
		array(
			'label'          => __( 'Office Timing Documentation Link', 'accron' ),
			'section'        => 'above_header',
			'type'           => 'radio',
			'description'    => __( 'Office Timing Documentation Link', 'accron' ), 
		) 
	) );


	$wp_customize->add_setting( 
		'hide_show_appointment_details' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'priority' => 4,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_appointment_details', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'accron' ),
			'section'     => 'above_header',
			'type'        => 'checkbox'
		) 
	);	
	
	// Button Label // 
	$wp_customize->add_setting(
    	'tlh_appointment_btn_lbl',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'transport'         => $selective_refresh,
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 5,
		)
	);	

	$wp_customize->add_control( 
		'tlh_appointment_btn_lbl',
		array(
		    'label'   		=> __('Button Label','accron'),
		    'section' 		=> 'above_header',
			'type'		 	=>	'text'
		)  
	);
	
	// Button Link // 
	$wp_customize->add_setting(
    	'tlh_appointment_link',
    	array(
			'sanitize_callback' => 'accron_sanitize_text',
			'transport'         => $selective_refresh,
			'capability' 		=> 'edit_theme_options',
			'priority' 			=> 5,
		)
	);	

	$wp_customize->add_control( 
		'tlh_appointment_link',
		array(
		    'label'   		=> __('Page Link','accron'),
		    'section' 		=> 'above_header',
			'type'		 	=>	'text'
		)  
	);
	

	/*=========================================
	Header Navigation
	=========================================*/	
	$wp_customize->add_section(
        'header_navigation',
        array(
        	'priority'      => 4,
            'title' 		=> __('Header Navigation','accron'),
			'panel'  		=> 'header_section',
		)
    );

	//Header Navigation Documentation Link
	class WP_header_navigation_section_Customize_Control extends WP_Customize_Control {
	public $type = 'new_menu';

	   function render_content()
	   
	   {
	   ?>
			<h3>How to Use Header Navigation section :</h3>
			<p>Customizer > Header Navigation <br><br> <a href="#" style="background-color:#0083E3; color:#fff;display: flex;align-items: center;justify-content: center;text-decoration: none;   font-weight: 600;padding: 15px 10px;">Click Here</a></p>
			
		<?php
	   }
	}
	
	// Header Navigation Doc Link // 
	$wp_customize->add_setting( 
		'header_navigation_doc_link' , 
			array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);

	$wp_customize->add_control(new WP_header_navigation_section_Customize_Control($wp_customize,
	'header_navigation_doc_link' , 
		array(
			'label'          => __( 'Header Navigation Documentation Link', 'accron' ),
			'section'        => 'header_navigation',
			'type'           => 'radio',
			'description'    => __( 'Header Navigation Documentation Link', 'accron' ), 
		) 
	) );
	
	// Search
	$wp_customize->add_setting(
		'hdr_nav_search'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'hdr_nav_search',
		array(
			'type' => 'hidden',
			'label' => __('Search','accron'),
			'section' => 'header_navigation',
		)
	);
	$wp_customize->add_setting( 
		'hide_show_search' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_search', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'accron' ),
			'section'     => 'header_navigation',
			'type'        => 'checkbox'
		) 
	);	
	
	if (function_exists('is_plugin_active')) {
	if(is_plugin_active('woocommerce/woocommerce.php')){
	// Cart
	$wp_customize->add_setting(
		'hdr_nav_cart'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 3,
		)
	);

	$wp_customize->add_control(
	'hdr_nav_cart',
		array(
			'type' => 'hidden',
			'label' => __('Cart','accron'),
			'section' => 'header_navigation',
		)
	);
	$wp_customize->add_setting( 
		'hide_show_cart' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'priority' => 4,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_cart', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'accron' ),
			'section'     => 'header_navigation',
			'type'        => 'checkbox'
		) 
	);	
}
	
	if(is_plugin_active('clever-fox/clever-fox.php')){
	// Header Toggle
	$wp_customize->add_setting(
		'hdr_nav_toggle'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 11,
		)
	);

	$wp_customize->add_control(
	'hdr_nav_toggle',
		array(
			'type' => 'hidden',
			'label' => __('Toggle','accron'),
			'section' => 'header_navigation',
		)
	);
	$wp_customize->add_setting( 
		'hs_nav_toggle' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'priority' => 12,
		) 
	);
	
	$wp_customize->add_control(
	'hs_nav_toggle', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'accron' ),
			'section'     => 'header_navigation',
			'type'        => 'checkbox'
		) 
	);	
}
}
	
	/*=========================================
	Sticky Header
	=========================================*/	
	$wp_customize->add_section(
        'sticky_header_set',
        array(
        	'priority'      => 4,
            'title' 		=> __('Sticky Header','accron'),
			'panel'  		=> 'header_section',
		)
    );
	
	// Heading
	$wp_customize->add_setting(
		'sticky_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'sticky_head',
		array(
			'type' => 'hidden',
			'label' => __('Sticky Header','accron'),
			'section' => 'sticky_header_set',
		)
	);

	//Header Navigation Documentation Link
	class WP_header_sticky_section_Customize_Control extends WP_Customize_Control {
	public $type = 'new_menu';

	   function render_content()
	   
	   {
	   ?>
			<h3>How to Use header sticky section :</h3>
			<p>Customizer > Header Sticky <br><br> <a href="#" style="background-color:#0083E3; color:#fff;display: flex;align-items: center;justify-content: center;text-decoration: none;   font-weight: 600;padding: 15px 10px;">Click Here</a></p>
			
		<?php
	   }
	}
	
	// Header Navigation Doc Link // 
	$wp_customize->add_setting( 
		'header_sticky_doc_link' , 
			array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) 
	);

	$wp_customize->add_control(new WP_header_sticky_section_Customize_Control($wp_customize,
	'header_sticky_doc_link' , 
		array(
			'label'          => __( 'Header Sticky Documentation Link', 'accron' ),
			'section'        => 'sticky_header_set',
			'type'           => 'radio',
			'description'    => __( 'Header Sticky Documentation Link', 'accron' ), 
		) 
	) );

	$wp_customize->add_setting( 
		'hide_show_sticky' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_checkbox',
			'priority' => 2,
		) 
	);
	
	$wp_customize->add_control(
	'hide_show_sticky', 
		array(
			'label'	      => esc_html__( 'Hide/Show', 'accron' ),
			'section'     => 'sticky_header_set',
			'type'        => 'checkbox'
		) 
	);	
}
add_action( 'customize_register', 'accron_header_settings' );

// Header selective refresh
function accron_header_partials( $wp_customize ){
	
	// hide_show_nav_btn
	$wp_customize->selective_refresh->add_partial(
		'hide_show_nav_btn', array(
			'selector' => '.navigator .av-button-area',
			'container_inclusive' => true,
			'render_callback' => 'header_navigation',
			'fallback_refresh' => true,
		)
	);
	
	// tlh_about_text
	$wp_customize->selective_refresh->add_partial( 'tlh_about_text', array(
		'selector'            => '.author-popup .author-content .heading-title h6',
		'settings'            => 'tlh_about_text',
		'render_callback'  => 'accron_tlh_about_text_render_callback',
	) );
	
	// tlh_about_desc
	$wp_customize->selective_refresh->add_partial( 'tlh_about_desc', array(
		'selector'            => '.author-popup .author-content .heading-title p',
		'settings'            => 'tlh_about_desc',
		'render_callback'  => 'accron_tlh_about_desc_render_callback',
	) );
	
	// topbar_text
	$wp_customize->selective_refresh->add_partial( 'topbar_text', array(
		'selector'            => '.top-above-header .left-widget .wp-block-categories-dropdown p',
		'settings'            => 'topbar_text',
		'render_callback'  => 'accron_topbar_text_render_callback',
	) );
	
	// tlh_gallery_text
	$wp_customize->selective_refresh->add_partial( 'tlh_gallery_text', array(
		'selector'            => '.author-popup .author-content .widget_media_gallery h5.widget-title',
		'settings'            => 'tlh_gallery_text',
		'render_callback'  => 'accron_tlh_gallery_text_render_callback',
	) );
	
	// instagram_gallery
	$wp_customize->selective_refresh->add_partial( 'instagram_gallery', array(
		'selector'            => '.author-popup .author-content .gallery-item',
	) );
	
	// tlh_mobile_icon
	$wp_customize->selective_refresh->add_partial( 'tlh_mobile_icon', array(
		'selector'            => '.header-widget',
		'settings'            => 'tlh_mobile_icon',
		'render_callback'  => 'accron_tlh_mobile_icon_render_callback',
	) );

	// tlh_mobile_title
	$wp_customize->selective_refresh->add_partial( 'tlh_mobile_number', array(
		'selector'            => '.widget-contact .content-area .contact-info a span',
		'settings'            => 'tlh_mobile_number',
		'render_callback'  => 'accron_tlh_mobile_number_render_callback',
	) );
	
	// tlh_email_icon
	$wp_customize->selective_refresh->add_partial( 'tlh_email_icon', array(
		'selector'            => '.widget-contact .content-area .contact-icon i',
		'settings'            => 'tlh_email_icon',
		'render_callback'  => 'accron_tlh_email_icon_render_callback',
	) );
	
	// tlh_email
	$wp_customize->selective_refresh->add_partial( 'tlh_email', array(
		'selector'            => '.widget-contact .content-area .contact-info a span',
		'settings'            => 'tlh_email',
		'render_callback'  => 'accron_tlh_email_render_callback',
	) );
	
	// tlh_appointment_icon
	$wp_customize->selective_refresh->add_partial( 'tlh_appointment_icon', array(
		'selector'            => '.widget-contact .content-area .contact-icon i',
		'settings'            => 'tlh_appointment_icon',
		'render_callback'  => 'accron_tlh_appointment_icon_render_callback',
	) );
	
	// tlh_appointment_contact_number
	$wp_customize->selective_refresh->add_partial( 'tlh_appointment_contact_number', array(
		'selector'            => '.widget-contact .content-area .contact-icon i',
		'settings'            => 'tlh_appointment_contact_number',
		'render_callback'  => 'accron_tlh_appointment_contact_number_render_callback',
	) );
	
	// tlh_appointment_contact_desc
	$wp_customize->selective_refresh->add_partial( 'tlh_appointment_contact_desc', array(
		'selector'            => '.widget-contact .content-area .contact-icon i',
		'settings'            => 'tlh_appointment_contact_desc',
		'render_callback'  => 'accron_tlh_appointment_contact_desc_render_callback',
	) );
	
	// tlh_appointment_btn_lbl
	$wp_customize->selective_refresh->add_partial( 'tlh_appointment_btn_lbl', array(
		'selector'            => '.nav-area .nav-info-text a > span',
		'settings'            => 'tlh_appointment_btn_lbl',
		'render_callback'  => 'accron_tlh_appointment_btn_lbl_render_callback',
	) );
	
	// tlh_contct_icon
	$wp_customize->selective_refresh->add_partial( 'tlh_contct_icon', array(
		'selector'            => '.widget-contact .content-area .contact-icon i',
		'settings'            => 'tlh_contct_icon',
		'render_callback'  => 'accron_tlh_contct_icon_render_callback',
	) );
	
	// tlh_contact_address
	$wp_customize->selective_refresh->add_partial( 'tlh_contact_address', array(
		'selector'            => '.widget-contact .content-area .contact-info a span',
		'settings'            => 'tlh_contact_address',
		'render_callback'  => 'accron_tlh_contact_address_render_callback',
	) );
	
	// tlh_button_icon
	$wp_customize->selective_refresh->add_partial( 'tlh_button_icon', array(
		'selector'            => '.header-button .main-button i, .header-button-2 .main-button-3 p i',
		'settings'            => 'tlh_button_icon',
		'render_callback'  => 'accron_tlh_button_icon_render_callback',
	) );
	
	// nav_btn_lbl
	$wp_customize->selective_refresh->add_partial( 'nav_btn_lbl', array(
		'selector'            => '.header-button .main-button span, .header-button-2 .main-button-3 p',
		'settings'            => 'nav_btn_lbl',
		'render_callback'  => 'accron_nav_btn_lbl_render_callback',
	) );
	// nav_btn_link
	$wp_customize->selective_refresh->add_partial( 'nav_btn_link', array(
		'selector'            => '.header-button .main-button, .header-button-2 .main-button-3',
		'settings'            => 'nav_btn_link',
		'render_callback'  => 'accron_nav_btn_link_render_callback',
	) );
	
	// hdr_nav_text_content
	$wp_customize->selective_refresh->add_partial( 'hdr_nav_text_content', array(
		'selector'            => '.nav-area .menu-right .widget_text',
		'settings'            => 'hdr_nav_text_content',
		'render_callback'  => 'accron_hdr_nav_text_content_render_callback',
	) );
	
	// hdr_nav_contact_content
	$wp_customize->selective_refresh->add_partial( 'hdr_nav_contact_content', array(
		'selector'            => '.nav-area .menu-right .widget-contact .ct-area1',
		'settings'            => 'hdr_nav_contact_content',
		'render_callback'  => 'accron_hdr_nav_contact_content_render_callback',
	) );
	
	// hdr_nav_contact_content2
	$wp_customize->selective_refresh->add_partial( 'hdr_nav_contact_content2', array(
		'selector'            => '.nav-area .menu-right .widget-contact .ct-area2',
		'settings'            => 'hdr_nav_contact_content2',
		'render_callback'  => 'accron_hdr_nav_contact2_content_render_callback',
	) );
	
	// hdr_nav_contact_content3
	$wp_customize->selective_refresh->add_partial( 'hdr_nav_contact_content3', array(
		'selector'            => '.nav-area .menu-right .widget-contact .ct-area3',
		'settings'            => 'hdr_nav_contact_content3',
		'render_callback'  => 'accron_hdr_nav_contact3_content_render_callback',
	) );
	
	// tlh_btn_lbl
	$wp_customize->selective_refresh->add_partial( 'tlh_btn_lbl', array(
		'selector'            => '.header-top-right a.main-btn',
		'settings'            => 'tlh_btn_lbl',
		'render_callback'  => 'accron_hdr_tlh_btn_lbl_content_render_callback',
	) );
	}

add_action( 'customize_register', 'accron_header_partials' );

// tlh_mobile_icon
function accron_tlh_mobile_icon_render_callback() {
	return get_theme_mod( 'tlh_mobile_icon' );
}

// tlh_mobile_title
function accron_tlh_mobile_title_render_callback() {
	return get_theme_mod( 'tlh_mobile_title' );
}

// tlh_mobile_number
function accron_tlh_mobile_number_render_callback() {
	return get_theme_mod( 'tlh_mobile_number' );
}

// tlh_email_icon
function accron_tlh_email_icon_render_callback() {
	return get_theme_mod( 'tlh_email_icon' );
}

// tlh_email
function accron_tlh_email_render_callback() {
	return get_theme_mod( 'tlh_email' );
}

// tlh_contct_icon
function accron_tlh_tlh_contct_icon_render_callback() {
	return get_theme_mod( 'tlh_contct_icon' );
}

// tlh_contact_address
function accron_tlh_contact_address_render_callback() {
	return get_theme_mod( 'tlh_contact_address' );
}

// nav_btn_lbl
function accron_nav_btn_lbl_render_callback() {
	return get_theme_mod( 'nav_btn_lbl' );
}
// nav_btn_link
function accron_nav_btn_link_render_callback() {
	return get_theme_mod( 'nav_btn_link' );
}

// hdr_nav_text_content
function accron_hdr_nav_text_content_render_callback() {
	return get_theme_mod( 'hdr_nav_text_content' );
}

// hdr_nav_contact_content
function accron_hdr_nav_contact_content_render_callback() {
	return get_theme_mod( 'hdr_nav_contact_content' );
}

// hdr_nav_contact_content2
function accron_hdr_nav_contact_content2_render_callback() {
	return get_theme_mod( 'hdr_nav_contact_content2' );
}

// hdr_nav_contact_content3
function accron_hdr_nav_contact_content3_render_callback() {
	return get_theme_mod( 'hdr_nav_contact_content3' );
}

