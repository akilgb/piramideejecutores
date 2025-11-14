<?php
function accron_premium_setting( $wp_customize ) {
	/*=========================================
	Premium Theme Details Page
	=========================================*/
	$wp_customize->add_section(
        'upgrade_premium',
        array(
            'title' 		=> __('Upgrade to Pro','accron'),
			'priority'      => 1,
		)
    );
	
	/*=========================================
	Add Buttons
	=========================================*/
	
	class Accron_WP_Button_Customize_Control extends WP_Customize_Control {
	public $type = 'upgrade_premium';

	   function render_content() {
		?>
			<div class="premium_info">
				<ul>
					<li><a class="documentation" href="https://help.nayrathemes.com/category/free-themes/accron-free/" target="_blank"><i class="dashicons dashicons-visibility"></i><?php _e( 'View Documentation','accron' ); ?> </a></li>
					
					<li><a class="support" href="https://nayrathemes.ticksy.com/" target="_blank"><i class="dashicons dashicons-lightbulb"></i><?php _e( 'Get Support','accron' ); ?> </a></li>
					
					<li><a class="free-pro" href="https://www.nayrathemes.com/accron-pro/#pt-freevspro" target="_blank"><i class="dashicons dashicons-visibility"></i><?php _e( 'Free Vs Pro','accron' ); ?> </a></li>
					
					<li><a class="upgrade-to-pro" href="https://www.nayrathemes.com/accron-pro/" target="_blank"><i class="dashicons dashicons-update-alt"></i><?php _e( 'Upgrade to Pro','accron' ); ?> </a></li>
					
					<li><a class="show-love" href="https://wordpress.org/support/theme/accron/reviews/#new-post" target="_blank"><i class="dashicons dashicons-smiley"></i><?php _e( 'Show Some Love','accron' ); ?> </a></li>
				</ul>
			</div>
		<?php
	   }
	}
	
	$wp_customize->add_setting(
		'premium_info_buttons',
		array(
		   'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'accron_sanitize_text',
		)	
	);
	
	$wp_customize->add_control( new Accron_WP_Button_Customize_Control( $wp_customize, 'premium_info_buttons', array(
		'section' => 'upgrade_premium',
    ))
);
}
add_action( 'customize_register', 'accron_premium_setting' );