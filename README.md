

Easy ACF Connect For Themer
========================
Contributors: badabingbreda
Donate link:
Tags: connector, acf, acf, beaver builder, beaver themer, conditional
Requires at least: 4.7
Tested up to: 5.4
Requires PHP: 5.6
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

**Description**

Easily connect ACF fields in Beaver Themer. No need to remember the fieldnames, easily select from the dropdown. It returns all fieldnames, across all fieldgroups.

Easy ACF Connect for Themer also supports ACF Fields on the current post, another post, user_id, tax_termid or even from your ACF Options pages.

Select the Easy ACF Connector... Then simply select the fieldname.

**Using the Conditional Logic filter**

Easy ACF Connect for Themer also supports adding conditional rules using ACF Fields on the current post or from your ACF Options pages. For that select either "Easy ACF Field" or "Easy ACF Option Field".

**Supported fieldtypes:**

 - color-picker
 - date-picker
 - date-time-picker
 - email
 - file
 - flexible content
 - gallery
 - group
 - image (array, url or image ID)
 - link
 - message
 - number
 - page link
 - password
 - post object
 - checkbox
 - radio
 - range
 - relationship
 - repeater
 - taxonomy
 - select
 - text
 - textarea
 - time_picker
 - true_false
 - url
 - user
 - wysiwyg

*Please note that field support means that it will return the ACF-value as a variable (object, array, string or number). It's up to the module to handle the returned variable.*

**Adding support for more fieldtypes in list**

If you use any third party or custom fieldtypes for ACF ( which can be found on [https://awesomeacf.com](https://awesomeacf.com) ) you can add those using a filter in your function.php:

    add_filter( 'easy_acf_accepted_acf_field_types' , 'my_custom_add_acf_field_types' );

    /**
     * Callback that adds one or more fieldtypes to the the easy_acf_accepted_field_types filter
     * @param  {array} $fieldtypes array with name->value, label->value pairs
     * @return {array}
     * @since 1.0.0
     */
    function my_custom_add_acf_fieldtypes( $fieldtypes ) {
        $new_fieldtypes =  array(
                array( 'name' => 'custom_fieldtype'         , 'label' => 'Custom Field Type' ),
            );

        $fieldtypes = array_merge( $fieldtypes , $new_fieldtypes );
        return $fieldtypes;
    }

**Conditional Rules for 3rd party fieldtypes**

There is currently no support or way to extend for 3rd party fieldtypes using the conditional rules. This means that you won't be able to pick fieldtypes based on the type. Use the conditional rules provided by Beaver Themer instead, but you will need to enter the fieldname manually.

**version history:**

**v1.1.4**

added checkbox fieldtype to Beaver Builder conditional rules, it was missing.

**v1.1.3**

added all remaining fieldtypes (flexible content, group, repeater, page link, post object, relationship, taxonomy, user)

**v1.1.2**

added Conditional Logic settings

**v1.1.1**

added image-size on image fields, tweaked the code, changed way to test for acf 4/5, fixed save_format/return_format for acf 4/5, added textdomain and .pot file

**v1.0.0**

image and gallery field support

