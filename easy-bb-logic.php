<?php
/**
 * @package  Easy ACF for Themer
 * @since 1.1.2
 */

/**
 * Check if the Theme Builder / Beaver Themer is 1.2 or higher
 */
if ( defined( 'FL_THEME_BUILDER_VERSION' ) && version_compare( FL_THEME_BUILDER_VERSION, '1.2', '>=' ) ) {

	/**
	 * Load the class for the rules
	 * @return void
	 */
	add_action( 'bb_logic_init'				, function() {
		require_once EASYACFCONNECT_DIR . 'rules/easy_acf/classes/class-bb-logic-rules-easy-acf.php';
	});

	/**
	 * Load the class for the rest routes
	 * @return void
	 */
	add_action( 'rest_api_init' 			, function() {
		require_once EASYACFCONNECT_DIR . 'rest/classes/class-bb-logic-rest-easy-acf.php';
	} );

	/**
	 * Enqueue the script necessary for the easy_acf rules
	 * @return void
	 */
	add_action( 'bb_logic_enqueue_scripts'	, function() {

		wp_enqueue_script(
			'bb-logic-rules-easy-acf',
			EASYACFCONNECT_URL . 'rules/easy_acf/build/index.js',
			array( 'bb-logic-core' ),
			EASYACFCONNECT_VERSION,
			true
		);

		/**
		 * Add translation for Beavers Conditional Logic Modal
		 * @return [type] [description]
		 */
		wp_localize_script(
		  'bb-logic-rules-easy-acf',
		  'easy_acf_js_translations',
		  [
		    '__' => [
		    	'easy_acf' => __( 'Easy ACF' , 'easy-acf-connect' ),
		    	'easy_acf_field' => __( 'Easy ACF Field' , 'easy-acf-connect' ),
		    	'easy_acf_option_field' => __( 'Easy ACF Option Field' , 'easy-acf-connect' ),
			    'field_value' => __( 'Value' , 'easy-acf-connect' ),
			    'field_name' => __( 'Field Name' , 'easy-acf-connect' ),
			    'start_value' => __( 'Start Value' , 'easy-acf-connect' ),
			    'end_value' => __( 'End Value' , 'easy-acf-connect' ),
			]
		  ]
		);


	} );

}
