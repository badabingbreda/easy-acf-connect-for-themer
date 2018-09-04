<?php

/**
 * REST API methods to retreive data for WordPress rules.
 *
 * @since 0.1
 */
final class BB_Logic_REST_Easy_ACF {

	/**
	 * REST API namespace
	 *
	 * @since 0.1
	 * @var string $namespace
	 */
	static protected $namespace = 'bb-logic/v1/easyacf';

	/**
	 * Register routes.
	 *
	 * @since  0.1
	 * @return void
	 */
	static public function register_routes() {
		register_rest_route(
			self::$namespace, '/fields', array(
				array(
					'methods'  => WP_REST_Server::READABLE,
					'callback' => __CLASS__ . '::fields',
				),
			)
		);
	}


	/**
	 * Returns an array of posts with each item
	 * containing a label and value.
	 *
	 * @since  0.1
	 * @param object $request
	 * @return array
	 */
	static public function fields( $request ) {

		$response = array();
		$post_type = $request->get_param( 'post_type' );


		// get the fieldnames form the easy_acf_connect class
		// returned values will be two arrays: 'options' (we will use those) and 'toggle' (which we won't)
		$easy_fields = easy_acf_connect::get_advanced_custom_fields();


		foreach ( $easy_fields['options'] as $key => $field ) {
			$response[] = array(
				'label' => $field,
				'value' => $key,
			);
		}

		//$response = array( array( 'label'=> 'veld 1', 'value'=>'veld1' ), array( 'label'=> 'veld 2', 'value'=>'veld2' ) );

		return rest_ensure_response( $response );
	}
}

BB_Logic_REST_Easy_ACF::register_routes();
