<?php
/* Notifications in customizer */


require COZIPRESS_PARENT_INC_DIR . '/customizer/customizer-notify/cozipress-notify.php';
$cozipress_config_customizer = array(
	'recommended_plugins'       => array(
		'burger-companion' => array(
			'recommended' => true,
			'description' => sprintf(__('Install and activate <strong>Burger Companion</strong> plugin for taking full advantage of all the features this theme has to offer CoziPress.', 'cozipress')),
		),
	),
	'recommended_actions'       => array(),
	'recommended_actions_title' => esc_html__( 'Recommended Actions', 'cozipress' ),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'cozipress' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'cozipress' ),
	'activate_button_label'     => esc_html__( 'Activate', 'cozipress' ),
	'cozipress_deactivate_button_label'   => esc_html__( 'Deactivate', 'cozipress' ),
);
Cozipress_Customizer_Notify::init( apply_filters( 'cozipress_customizer_notify_array', $cozipress_config_customizer ) );
