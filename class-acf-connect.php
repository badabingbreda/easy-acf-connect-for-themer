<?php
/**
 * Plugin Name: Easy ACF Connect for Themer
 * Plugin URI: http://www.beaverplugins.com
 * Description: Easy ACF Connect for Beaver Themer. Just select the fieldname to connect.
 * Version: 1.0
 * Author: Didou Schol
 * Author URI: http://www.beaverplugins.com
 */

add_action( 'init' , 'easy_acf_connect::init', 99, 1 );

class easy_acf_connect {

	// set the default Beaver Builder field types
	public static $accepted_field_types = array(
			'string',
			'html',
			'photo',
			'multiple-photos',
			'url',
			'custom_field',
			'color',
	);

	public static function init() {

		// return early if acf_pro doesn't exist
		if (! class_exists('acf_pro') && !class_exists('acf') ) return false;

		add_action( 'fl_page_data_add_properties' ,  __CLASS__ . '::add_acf_connector'  );

	}

	/**
	 * Admin area notice that flbuilder is not activated
	 * @return [type] [description]
	 */
	function easy_acf_admin_error_need_pro() {
		$class = 'notice notice-error';
		$message = __( 'Sorry, in order for Easy ACF to work, you will need ACF Pro .', '{{plugin.textdomain}}' );
		printf( '<div class="%s is-dismissible"><p>%s</p></div>', esc_attr($class), esc_html($message) );
	}


	public static function add_acf_connector() {

			/**
			 *  Add a custom group
			 */
			FLPageData::add_group( 'easy_acf', array(
				'label' => __('Easy ACF', '{{plugin.textdomain}}')
			) );


			/**
			 *  Add a new property to our group
			 */
			FLPageData::add_post_property( 'easy_acf_connect', array(
				'label'   => __('Easy ACF', '{{plugin.textdomain}}'),
				'group'   => 'easy_acf',
				'type'    => apply_filters( 'easy_acf_select_field_types' , self::$accepted_field_types ),
				'getter'  => array( __CLASS__ , 'get_easy_acf' ),
			) );

		FLPageData::add_post_property_settings_fields(
			'easy_acf_connect',
			array(
				'selected_acf_field' 	=> array(
				    'type'          => 'select',
				    'label'         => __( 'Select Field', 'textdomain' ),
				    'default'       => '',
				    'options'       => self::get_advanced_custom_fields(),
				    'multi-select'	=> false,
				),
			)
		);

	}

	public static function get_easy_acf( $settings , $property ) {

		// get the value
		$value 		= get_field( $settings->selected_acf_field );
		// get the field object
		$fo 		= get_field_object( $settings->selected_acf_field );

		/**
		 * Add field-types at will
		 */
		switch ( $fo['type'] ) {
			/**
			 * field type image
			 */
			case 'image':
				// the image is returned as an array per acf-settings
				if ( is_array($value) && $value['url'] ) {
					return $value['url'];
				// image is returned as image ID as per acf-settings
				} else if ( is_integer($value) ) {
					return wp_get_attachment_image_url( $value );
				// image is returned as url
				} else {
					return $value;
				}
			break;
			/**
			 * field type gallery
			 */
			case 'gallery':
				$return = array();
				for( $i=0; $i<sizeof($fo['value']);$i++):
					$return[] = ( $fo['value'][$i]['id'] );
				endfor;
				//return ob_get_clean();
				return $return;
			break;
		}
		// return value of retrieved field
		return $value;
	}


	/**
	 * Get an array with the defined field group
	 * @return [type] [description]
	 */
	public static function get_field_groups() {

		if ( class_exists('acf_pro') ) {

			// version 5
			return acf_get_field_groups();

		} else {

			// verion 4
			return apply_filters( 'acf/get_field_groups', $array );

		}
	}

    /**
     * Get an array with all advanced custom fields for either acf v4 or acf v5
     * @since 1.0.0
     * @param  array $fieldtype if provided only get fields of this type
     * @return array
     */
    public static function get_advanced_custom_fields ( $fieldtypes = null ) {

    	$option =array();

    	// get all field groups first
    	$groups = self::get_field_groups();

    	// return if we don't have field groups yet
    	if (!is_array($groups)) return;

    	if ( class_exists( 'acf_pro' ) ) {
			// acf > v5 version
			foreach( $groups as $group ) {
				// get the custom fieds for this group
				$custom_fields = acf_get_fields( $group[ 'ID' ] );

				// break for this early if there are no custom fields
				if ( !is_array( $custom_fields ) ) break;

				foreach ( $custom_fields as $field ) {

					if ( stristr( $field[ 'key' ] , 'field_' ) ) {

						if ( !isset( $field['sub_fields'] ) ) $field['sub_fields'] = array();

						// check if $fieldtypes parameter is set, only get fields of this/these type(s);
						if ( $fieldtypes ) {

							// if it's in the array go ahead and add it
							if ( in_array( $field[ 'type' ], $fieldtypes ) ) $option[ $field[ 'name' ] ] = $field['name'] . ' (' . $field[ 'label' ] . ')';

						} else {

							$option[ $field[ 'name' ] ] = $field['name'] . ' (' . $field[ 'label' ] . ')';

						}

					}

				}

			}
    	} else {
    		// acf v4
    		foreach( $groups as $group ) {
    			// get the custom field-keys for this group
    			$custom_field_keys = get_post_custom_keys($group[ 'id' ] );

				foreach ( $custom_field_keys as $key => $fieldkey ) {

			    if ( stristr( $fieldkey , 'field_' ) ) {

				        $field = get_field_object( $fieldkey, $group[ 'id' ] );

						if ( !isset( $field['sub_fields'] ) ) $field['sub_fields'] = array();

    					// check if $fieldtype parameter is set, only get fields of this/these type(s);
				        if ( $fieldtypes ) {

						// if it's in the array go ahead and add it
						if ( in_array( $field[ 'type' ], $fieldtypes ) ) $option[ $field[ 'name' ] ] = $field['name'] . ' (' . $field[ 'label' ] . ')';

				        } else {

						$option[ $field[ 'name' ] ] = $field['name'] . ' (' . $field[ 'label' ] . ')';

				    	}

				    }

				}

    		}
    	}

		return $option;

	}

}


