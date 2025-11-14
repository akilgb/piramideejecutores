<?php
class cozipress_import_dummy_data {

	private static $instance;

	public static function init( ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof cozipress_import_dummy_data ) ) {
			self::$instance = new cozipress_import_dummy_data;
			self::$instance->cozipress_setup_actions();
		}

	}

	/**
	 * Setup the class props based on the config array.
	 */
	

	/**
	 * Setup the actions used for this class.
	 */
	public function cozipress_setup_actions() {

		// Enqueue scripts
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'cozipress_import_customize_scripts' ), 0 );

	}
	
	

	public function cozipress_import_customize_scripts() {

	wp_enqueue_script( 'cozipress-import-customizer-js', COZIPRESS_PARENT_INC_URI . '/customizer/customizer-notify/js/cozipress-import-customizer-options.js', array( 'customize-controls' ) );
	}
}

$cozipress_import_customizers = array(

		'import_data' => array(
			'recommended' => true,
			
		),
);
cozipress_import_dummy_data::init( apply_filters( 'cozipress_import_customizer', $cozipress_import_customizers ) );