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

		register_rest_route(
			self::$namespace, '/fieldtypes', array(
				array(
					'methods'  => WP_REST_Server::READABLE,
					'callback' => __CLASS__ . '::fieldtypes',
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
	static public function fieldtypes( $request ) {

		$response = array();

		foreach ( easy_acf_connect::$supported_acf_field_types_names as $type ) {
			$response[] = array(
				'label' => $type['label'],	// pretty name
				'value' => $type['name'],	// field_type
			);
		}

		//$response = array( array( 'label'=> 'field 1', 'value'=>'field1' ), array( 'label'=> 'field 2', 'value'=>'field2' ) );

		return rest_ensure_response( $response );
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
		$fieldtype = $request->get_param( 'fieldtype' );



		// get the fieldnames form the easy_acf_connect class
		// returned values will be two arrays: 'options' (we will use those) and 'toggle' (which we won't)
		$easy_fields = easy_acf_connect::get_advanced_custom_fields( array($fieldtype) );

		if ( sizeof( $easy_fields ) == 0 ) return $response[] = array( 'label' => '' , 'value' => '' );

		foreach ( $easy_fields['options'] as $key => $field ) {
			$response[] = array(
				'label' => $field,
				'value' => $key,
			);
		}

		//$response = array( array( 'label'=> 'field 1', 'value'=>'field1' ), array( 'label'=> 'field 2', 'value'=>'field2' ) );

		return rest_ensure_response( $response );
	}
}

BB_Logic_REST_Easy_ACF::register_routes();
