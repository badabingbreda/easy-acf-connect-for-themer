<?php
/**
 Plugin Name: Easy ACF Connect for Themer
 Plugin URI: https://www.badabing.nl
 Description: Easy ACF Connect for Beaver Themer. Just select the fieldname to connect.
 Version: 1.1.2
 Author: Didou Schol
 Text Domain: easy-acf-connect
 Domain Path: /languages
 Author URI: https://www.badadbing.nl
 */

define( 'EASYACFCONNECT_VERSION' 	, '1.1.2' );
define( 'EASYACFCONNECT_DIR'			, plugin_dir_path( __FILE__ ) );
define( 'EASYACFCONNECT_FILE'		, __FILE__ );
define( 'EASYACFCONNECT_URL' 		, plugins_url( '/', __FILE__ ) );

add_action( 'plugins_loaded', 'easy_acf_setup_textdomain' );

function easy_acf_setup_textdomain(){
	//textdomain
	load_plugin_textdomain( 'easy-acf-connect', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

add_action( 'init' , 'easy_acf_connect::init', 99, 1 );

/**
 * Load the BB Logic files
 *
 * Don't worry, checks for Themer version
 * happen before enqueueing things
 *
 * @since  1.1.2
 */
include_once( 'easy-bb-logic.php' );

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

	public static $supported_acf_field_types = array(
		'color_picker',
		'date_picker',
		'date_time_picker',
		'email',
		'file',
		'gallery',
		'image',
		'link',
		'message',
		'number',
		'password',
		'radio',
		'range',
		'select',
		'text',
		'textarea',
		'time_picker',
		'true_false',
		'url',
		'wysiwyg',
		'field'
	);

	/**
	 * variable for the fieldnames
	 * @var array
	 * @since  1.1.2
	 */
	public static $supported_acf_field_types_names = array();

	public static $rf = '';

	/**
	 * Plugin init
	 * @return void
	 */
	public static function init() {

		self::$supported_acf_field_types_names = array(
		array( 'name' => 'color_picker'			, 'label' => __( 'Color Picker' , 'acf' ) ),
		array( 'name' => 'date_picker'			, 'label' => __( 'Date Picker' , 'acf' ) ),
		array( 'name' => 'date_time_picker'		, 'label' => __( 'Date Time Picker' , 'acf' ) ),
		array( 'name' => 'email'				, 'label' => __( 'Email' , 'acf' ) ),
		array( 'name' => 'file'					, 'label' => __( 'File Picker' , 'acf' ) ),
		array( 'name' => 'gallery'				, 'label' => __( 'Gallery' , 'acf' ) ),
		array( 'name' => 'image'				, 'label' => __( 'Image' , 'acf' ) ),
		array( 'name' => 'link'					, 'label' => __( 'Link' , 'acf' ) ),
		array( 'name' => 'message'				, 'label' => __( 'Message' , 'acf' ) ),
		array( 'name' => 'number'				, 'label' => __( 'Number' , 'acf' ) ),
		array( 'name' => 'password'				, 'label' => __( 'Password' , 'acf' ) ),
		array( 'name' => 'radio'				, 'label' => __( 'Radio' , 'acf' ) ),
		array( 'name' => 'range'				, 'label' => __( 'Range' , 'acf' ) ),
		array( 'name' => 'select'				, 'label' => __( 'Select' , 'acf' ) ),
		array( 'name' => 'text'					, 'label' => __( 'Text' , 'acf' ) ),
		array( 'name' => 'textarea'				, 'label' => __( 'Textarea' , 'acf' ) ),
		array( 'name' => 'time_picker'			, 'label' => __( 'Time Picker' , 'acf' ) ),
		array( 'name' => 'true_false'			, 'label' => __( 'True / False' , 'acf' ) ),
		array( 'name' => 'url'					, 'label' => __( 'Url' , 'acf' ) ),
		array( 'name' => 'wysiwyg'				, 'label' => __( 'Wysiwyg Editor' , 'acf' ) )
	);

		// check if Theme Builder / Beaver Themer is installed and actived
		if ( !class_exists( 'FLThemeBuilder' ) ) {
			add_action( 'admin_notices' , __CLASS__ . '::easy_acf_admin_error_need_theme_builder' );
			return false;
		}
		// check if ACF is installed and activated
		if ( !class_exists( 'ACF' ) && !class_exists( 'acf' ) ) {
			add_action( 'admin_notices' , __CLASS__ . '::easy_acf_admin_error_need_acf' );
			return false;
		}

		// check for the ACF Version because older version requires other method of pulling the fieldnames
		if ( defined( 'ACF_VERSION' ) && version_compare( ACF_VERSION , '5.0.0' , '>=' ) ) {
			self::$rf = 'return_format';
		} else {
			self::$rf = 'save_format';
		}

		// add the actual field connector to themer
		add_action( 'fl_page_data_add_properties' ,  __CLASS__ . '::add_acf_connector' );

	}

	/**
	 * Admin area notice that acf is not installed and/or activated
	 * @return [type] [description]
	 */
	function easy_acf_admin_error_need_acf() {
		$class = 'notice notice-error';
		$message = __( 'Sorry, in order for Easy ACF to work, you will need Advanced Custom Fields.', 'easy-acf-connect' );
		printf( '<div class="%s is-dismissible"><p>%s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}

	/**
	 * Admin area notice that flbuilder is not installed and/or activated
	 * @return [type] [description]
	 */
	function easy_acf_admin_error_need_theme_builder() {
		$class = 'notice notice-error';
		$message = __( 'Sorry, in orde to use Easy ACF Connect you will need Beaver Theme Builder/Beaver Themer.', 'easy-acf-connect' );
		printf( '<div class="%s is-dismissible"><p>%s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}


	/**
	 * function to add the acf connector to beaver themer
	 */
	public static function add_acf_connector() {

		/**
		 *  Add a custom group
		 */
		FLPageData::add_group( 'easy_acf', array(
			'label' => __( 'Easy ACF', 'easy-acf-connect' )
		) );


		/**
		 *  Add a new property to custom group
		 */
		FLPageData::add_post_property( 'easy_acf_connect', array(
			'label'   => __( 'Easy ACF', 'easy-acf-connect' ),
			'group'   => 'easy_acf',
			'type'    => apply_filters( 'easy_acf_select_field_types' , self::$accepted_field_types ),
			'getter'  => array( __CLASS__ , 'get_easy_acf' ),
		) );

		$settings_field = self::get_advanced_custom_fields( apply_filters( 'easy_acf_accepted_acf_field_types' , self::$supported_acf_field_types ) );

		FLPageData::add_post_property_settings_fields(
			'easy_acf_connect',
			array(
				'selected_acf_field' 	=> array(
				    'type'          => 'select',
				    'label'         => __( 'Select Field', 'easy-acf-connect' ),
				    'default'       => '',
				    // filter the fields to only show supported fieldtypes
				    'options'       => $settings_field[ 'options' ],
				    'toggle'		=> $settings_field[ 'toggle' ],
				    'multi-select'	=> false,
				),
				'image_size' => array(
				    'type'          => 'photo-sizes',
				    'label'         => __( 'Photo Size', 'easy-acf-connect' ),
				    'default'       => 'medium',
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
		switch ( $fo[ 'type' ] ) {
			/**
			 * field type image
			 */
			case 'image':
				/**
				 * acf version 4 uses $fo['save_format'] to specify the stored format
				 * acf version 5 uses $fo['return_format'] to specify the stored format
				 * self::$rf (return_format) is set at ::init()
				 */
				// the image is returned as an array per acf-settings
				if ( 'array' == $fo[ self::$rf ] && $value[ 'url' ] ) {
					return $value[ 'sizes' ][ $settings->image_size ];
				// image is returned as image ID as per acf-settings
				} else if ( 'id' == $fo[ self::$rf ] ) {
					return wp_get_attachment_image_url( $value, $settings->image_size );
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
				for( $i=0; $i<sizeof( $fo[ 'value' ] );$i++ ):
					$return[] = ( $fo[ 'value '][ $i ][ 'id' ] );
				endfor;
				// return array of ids
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

		if ( defined( 'ACF_VERSION' ) && version_compare( ACF_VERSION , '5.0.0' , '>=' ) ) {

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
    	if ( !is_array( $groups ) ) return;

		if ( defined( 'ACF_VERSION' ) && version_compare( ACF_VERSION , '5.0.0' , '>=' ) ) {

			// acf > v5 version
			foreach( $groups as $group ) {
				// get the custom fieds for this group
				$custom_fields = acf_get_fields( $group[ 'ID' ] );

				// break for this early if there are no custom fields
				if ( !is_array( $custom_fields ) ) break;

				foreach ( $custom_fields as $field ) {

					if ( stristr( $field[ 'key' ] , 'field_' ) ) {

						if ( !isset( $field[ 'sub_fields' ] ) ) $field[ 'sub_fields' ] = array();

    					// check if $fieldtype parameter is set, only get fields of this/these type(s);
				        if ( $fieldtypes && !in_array( $field[ 'type' ], $fieldtypes ) ) continue;

						$option[ $field[ 'name' ] ] = $field['name'] . ' (' . $field[ 'label' ] . ')';
						$toggle[ $field[ 'name' ] ] = array( 'fields' => (('image' == $field[ 'type' ] )?array( 'image_size' ): array()) );


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

						if ( !isset( $field[ 'sub_fields' ] ) ) $field[ 'sub_fields' ] = array();

    					// check if $fieldtype parameter is set, only get fields of this/these type(s);
				        if ( $fieldtypes && !in_array( $field[ 'type' ], $fieldtypes ) ) continue;

						$option[ $field[ 'name' ] ] = $field[ 'name' ] . ' (' . $field[ 'label' ] . ')';
						$toggle[ $field[ 'name' ] ] = array( 'fields' => ( ('image' == $field[ 'type' ] )?array( 'image_size' ): array() ) );

				    }

				}

    		}
    	}

		return array( 'options' => $option, 'toggle' => $toggle );

	}

}


