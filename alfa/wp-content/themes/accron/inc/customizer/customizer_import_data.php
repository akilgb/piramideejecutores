<?php
class accron_import_dummy_data {

	private static $instance;

	public static function init( ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof accron_import_dummy_data ) ) {
			self::$instance = new accron_import_dummy_data;
			self::$instance->accron_setup_actions();
		}

	}

	/**
	 * Setup the class props based on the config array.
	 */
	

	/**
	 * Setup the actions used for this class.
	 */
	public function accron_setup_actions() {

		// Enqueue scripts
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'accron_import_customize_scripts' ), 0 );

	}
	
	

	public function accron_import_customize_scripts() {

	wp_enqueue_script( 'accron-import-customizer-js', get_template_directory_uri() . '/assets/js/accron-import-customizer.js', array( 'customize-controls' ) );
	}
}

$accron_import_customizers = array(

		'import_data' => array(
			'recommended' => true,
			
		),
);
accron_import_dummy_data::init( apply_filters( 'accron_import_customizer', $accron_import_customizers ) );