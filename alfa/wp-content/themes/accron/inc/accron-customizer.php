<?php
/**
 * Accron Theme Customizer.
 *
 * @package Accron
 */

 if ( ! class_exists( 'Accron_Customizer' ) ) {

	/**
	 * Customizer Loader
	 *
	 * @since 1.0.0
	 */
	class Accron_Customizer {

		/**
		 * Instance
		 *
		 * @access private
		 * @var object
		 */
		private static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {
			/**
			 * Customizer
			 */
			add_action( 'customize_preview_init',                  array( $this, 'accron_customize_preview_js' ) );
			add_action( 'customize_controls_enqueue_scripts', 	   array( $this, 'accron_customizer_script' ) );
			add_action( 'after_setup_theme',                       array( $this, 'accron_customizer_settings' ) );
			add_action( 'customize_register',                      array( $this, 'accron_customizer_register' ) );
		}
		
		/**
		 * Add postMessage support for site title and description for the Theme Customizer.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		function accron_customizer_register( $wp_customize ) {
			
			$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
			$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
			$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
			$wp_customize->get_setting('custom_logo')->transport = 'refresh';

			/**
			 * Helper files
			 */
			require ACCRON_PARENT_INC_DIR . '/custom-controls/font-control.php';
				require ACCRON_PARENT_INC_DIR . '/customizer/accron-range-value-control.php';
			require ACCRON_PARENT_INC_DIR . '/sanitization.php';
		}

		/**
		 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
		 */
		function accron_customize_preview_js() {
			wp_enqueue_script( 'accron-customizer', ACCRON_PARENT_URI . '/assets/js/customizer-preview.js', array( 'customize-preview' ), '20151215', true );
		}
		
		function accron_customizer_script() {
			 wp_enqueue_script( 'accron-customizer-section', ACCRON_PARENT_URI .'/assets/js/customizer-section.js', array("jquery"),'', true  );	
		}

		// Include customizer customizer settings.
			
		function accron_customizer_settings() {
			require ACCRON_PARENT_INC_DIR . '/customizer/accron-header.php';
			require ACCRON_PARENT_INC_DIR . '/customizer/accron-blog.php';
			require ACCRON_PARENT_INC_DIR . '/customizer/accron-footer.php';
			require ACCRON_PARENT_INC_DIR . '/customizer/accron-general.php';
			require ACCRON_PARENT_INC_DIR . '/customizer/customizer_recommended_plugin.php';
			require ACCRON_PARENT_INC_DIR . '/customizer/customizer_import_data.php';
			require ACCRON_PARENT_INC_DIR . '/customizer/accron-customize-base-control.php';
			require ACCRON_PARENT_INC_DIR . '/customizer/accron-radio-image.php';
			require ACCRON_PARENT_INC_DIR . '/customizer/accron-premium.php';
		}

	}
}// End if().

/**
 *  Kicking this off by calling 'get_instance()' method
 */
Accron_Customizer::get_instance();