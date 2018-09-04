<?php
/**
 * @since 1.1.2
 */

/**
 * Check if the Theme Builder / Beaver Themer is 1.2 or higher
 */
if ( defined( 'FL_THEME_BUILDER_VERSION' ) && version_compare( FL_THEME_BUILDER_VERSION, '1.2', '>=' ) ) {

	add_action( 'bb_logic_init'				, 'easy_acf_beaver_bb_logic_init');
	add_action( 'rest_api_init' 			, 'easy_acf_beaver_bb_logic_rest' );
	add_action( 'bb_logic_enqueue_scripts'	, 'easy_acf_beaver_bb_logic_enqueue' );

}

/**
 * Enqueue the script necessary for the easy_acf rules
 * @return void
 */
function easy_acf_beaver_bb_logic_enqueue() {

	wp_enqueue_script(

		'bb-logic-rules-easy-acf',
		EASYACFCONNECT_URL . 'rules/easy_acf/build/index.js',
		array( 'bb-logic-core' ),
		EASYACFCONNECT_VERSION,
		true

	);
}

/**
 * Load the class for the rules
 * @return void
 */
function easy_acf_beaver_bb_logic_init() {

	require_once EASYACFCONNECT_DIR . 'rules/easy_acf/classes/class-bb-logic-rules-easy-acf.php';

}

/**
 * Load the class for the rest routes
 * @return void
 */
function easy_acf_beaver_bb_logic_rest() {

	require_once EASYACFCONNECT_DIR . 'rest/classes/class-bb-logic-rest-easy-acf.php';

}
