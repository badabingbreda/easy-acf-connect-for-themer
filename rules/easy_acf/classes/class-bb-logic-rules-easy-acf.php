<?php
/**
 * Server side processing for ACF rules.
 *
 * @since 0.1
 */
final class BB_Logic_Rules_Easy_ACF {
	/**
	 * Sets up callbacks for conditional logic rules.
	 *
	 * @since  0.1
	 * @return void
	 */
	static public function init() {
		if ( ! class_exists( 'acf' ) ) {
			return;
		}
		BB_Logic_Rules::register( array(
			'easyacf/settings-field' 		=> __CLASS__ . '::field_compare',
		) );
	}
	/**
	 * Process an Esay ACF rule based on the object ID of the
	 * field location.
	 *
	 * @since  0.1
	 * @param string $object_id
	 * @param object $rule
	 * @return bool
	 */
	static public function evaluate_rule( $object_id = false, $rule ) {
		$value = get_field( $rule->key, $object_id );

		if ( is_array( $value ) ) {
			$value = empty( $value ) ? 0 : 1;
		} elseif ( is_object( $value ) ) {
			$value = 1;
		}

		return BB_Logic_Rules::evaluate_rule( array(
			'value' 	=> $value,
			'operator' 	=> $rule->operator,
			'compare' 	=> $rule->compare,
			'isset' 	=> $value,
		) );
	}

	/**
	 * Field Compare rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function field_compare( $rule ) {
		global $post;
		$id = is_object( $post ) ? $post->ID : 0;

		return self::evaluate_rule( $id, $rule );
	}

}
BB_Logic_Rules_Easy_ACF::init();
