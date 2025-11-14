<?php
/**
 * Customize Base control class. 
 *
 * @package Accron
 *
 * @see     WP_Customize_Control
 * @access  public 
 */

/**
 * Class Accron_Customize_Base_Control
 */
 
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}

class Accron_Customize_Base_Control extends WP_Customize_Control {

	/**
	 * Enqueue scripts all controls.
	 */
	public function enqueue() {

		wp_enqueue_script( 'select-script', ACCRON_PARENT_INC_URI . '/custom-controls/js/select.js', array( 'jquery' ), ACCRON_THEME_VERSION, true );
		wp_enqueue_style( 'select-style', ACCRON_PARENT_INC_URI . '/custom-controls/css/select.css', null, ACCRON_THEME_VERSION );

		// Main scripts.
		wp_enqueue_script(
			'accron-controls-js',
			ACCRON_PARENT_INC_URI . '/custom-controls/js/controls.js',
			array(
				'jquery',
				'customize-base',
				'jquery-ui-button',
				'jquery-ui-sortable',
			),
			false,
			true
		);
	
		wp_enqueue_style( 'accron-controls-css', ACCRON_PARENT_INC_URI . '/custom-controls/css/controls.css' );
		wp_enqueue_style( 'font-awesome', ACCRON_PARENT_URI . '/assets/css/fonts/font-awesome/css/font-awesome.min.css' );
	}


	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see    WP_Customize_Control::to_json()
	 * @access public
	 * @return void
	 */
	public function to_json() {

		parent::to_json();

		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}

		$this->json['id']         = $this->id;
		$this->json['link']       = $this->get_link();
		$this->json['value']      = maybe_unserialize( $this->value() );
		$this->json['choices']    = $this->choices;
		$this->json['inputAttrs'] = '';

		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}
		$this->json['inputAttrs'] = maybe_serialize( $this->input_attrs() );

	}

	/**
	 * Render content is still called, so be sure to override it with an empty function in your subclass as well.
	 */
	protected function render_content() {
	}

	/**
	 * Renders the Underscore template for this control.
	 *
	 * @see    WP_Customize_Control::print_template()
	 * @access protected
	 * @return void
	 */
	protected function content_template() {
	}

	/**
	 * Returns an array of translation strings.
	 *
	 * @access protected
	 * @return array
	 */
	protected function l10n() {
		return array();
	}

}
