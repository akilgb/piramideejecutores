<?php
/* Notifications in customizer */


require get_template_directory() . '/inc/customizer-notify/accron-customizer-notify.php';
$accron_config_customizer = array(
	'recommended_plugins'       => array(
		'classic-widgets' => array(
			'recommended' => true,
			'description' => sprintf(__('Install and activate <strong>Classic Widget</strong> plugin for taking full advantage of all the features this theme has to offer.', 'accron')),
		),
		'clever-fox' => array(
			'recommended' => true,
			'description' => sprintf(__('Install and activate <strong>Cleverfox</strong> plugin for taking full advantage of all the features this theme has to offer.', 'accron')),
		),
	),
	'recommended_actions'       => array(),
	'recommended_actions_title' => esc_html__( 'Recommended Actions', 'accron' ),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'accron' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'accron' ),
	'activate_button_label'     => esc_html__( 'Activate', 'accron' ),
	'accron_deactivate_button_label'   => esc_html__( 'Deactivate', 'accron' ),
);
Accron_Customizer_Notify::init( apply_filters( 'accron_customizer_notify_array', $accron_config_customizer ) );
?>