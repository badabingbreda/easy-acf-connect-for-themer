var addRuleTypeCategory = BBLogic.api.addRuleTypeCategory,
    addRuleType = BBLogic.api.addRuleType,
    getFormPreset = BBLogic.api.getFormPreset;

// create var here so we can re-use it in both rules
var easyacf_fieldoperators = {
	color_picker: 	{
				operators: [ 'equals', 'does_not_equal' , 'is_set' , 'is_not_set' ],
				hasvalue: true,
				hasend: false
			},

	date_picker: 	{
				operators: ['equals', 'does_not_equal' , 'is_greater_than', 'is_not_greater_than',
							'is_greater_than_or_equal_to', 'is_less_than_or_equal_to',
							'is_empty', 'is_not_empty', 'is_set', 'is_not_set', 'within', 'not_within' ],
				hasvalue: true,
				hasend: false
			},

	date_time_picker: 	{
				operators: ['equals', 'does_not_equal' , 'is_greater_than', 'is_not_greater_than',
							'is_greater_than_or_equal_to', 'is_less_than_or_equal_to',
							'is_empty', 'is_not_empty', 'is_set', 'is_not_set', 'within', 'not_within' ],
				hasvalue: true,
				hasend: false
			},

	email: 	{
				operators: ['equals', 'does_not_equal' , 'starts_with', 'ends_with',
							'contains', 'does_not_contain' , 'is_empty', 'is_not_empty',
							'is_set', 'is_not_set' ],
				hasvalue: true,
				hasend: false
			},

	file: 	{
				operators: [ 'is_set' , 'is_not_set' ],
				hasvalue: false,
				hasend: false
			},

	flexible_content: 	{
				operators: [ 'is_set' , 'is_not_set' ],
				hasvalue: false,
				hasend: false
			},

	gallery: 	{
				operators: [ 'is_set' , 'is_not_set' ],
				hasvalue: false,
				hasend: false
			},

	group: 	{
				operators: [ 'is_set' , 'is_not_set' ],
				hasvalue: false,
				hasend: false
			},

	image: 	{
				operators: [ 'is_set' , 'is_not_set' ],
				hasvalue: false,
				hasend: false
			},

	link: 	{
				operators: ['equals', 'does_not_equal' , 'starts_with', 'ends_with',
							'contains', 'does_not_contain' , 'is_empty', 'is_not_empty',
							'is_set', 'is_not_set' ],
				hasvalue: true,
				hasend: false

			},

	page_link: 	{
				operators: ['equals', 'does_not_equal' , 'starts_with', 'ends_with',
							'contains', 'does_not_contain' , 'is_empty', 'is_not_empty',
							'is_set', 'is_not_set' ],
				hasvalue: true,
				hasend: false

			},

	number: 	{
				operators: ['equals', 'does_not_equal' , 'is_greater_than', 'is_not_greater_than',
							'is_greater_than_or_equal_to', 'is_less_than_or_equal_to',
							'is_empty', 'is_not_empty', 'is_set', 'is_not_set', 'within', 'not_within' ],
				hasvalue: true,
				hasend: true
			},

	password: 	{
				operators: ['equals', 'does_not_equal', 'starts_with', 'ends_with',
							'contains', 'does_not_contain', 'is_empty', 'is_not_empty',
							'is_set', 'is_not_set' ],
				hasvalue: true,
				hasend: false
			},

	post_object: 	{
				operators: [ 'is_set' , 'is_not_set' ],
				hasvalue: false,
				hasend: false
			},

	checkbox: 	{
				operators: ['contains' , 'does_not_contain', 'is_empty', 'is_not_empty', 'is_set', 'is_not_set' ],
				hasvalue: true,
				hasend: false
			},
	radio: 	{
				operators: [ 'contains', 'does_not_contain' , 'equals', 'does_not_equal' , 'is_greater_than', 'is_not_greater_than',
							'is_greater_than_or_equal_to', 'is_less_than_or_equal_to',
							'is_empty', 'is_not_empty', 'is_set', 'is_not_set' ],
				hasvalue: true,
				hasend: false
			},

	range: 	{
				operators: ['within', 'not_within' ],
				hasvalue: true,
				hasend: true
			},

	relationship: 	{
				operators: [ 'contains', 'does_not_contain', 'is_set' , 'is_not_set' ],
				hasvalue: false,
				hasend: false
			},

	repeater: 	{
				operators: [ 'is_set' , 'is_not_set' ],
				hasvalue: false,
				hasend: false
			},

	taxonomy: 	{
				operators: [ 'equals', 'does_not_equal', 'is_set' , 'is_not_set' ],
				hasvalue: false,
				hasend: false
			},

	select:	{
				operators: ['equals', 'does_not_equal' , 'is_greater_than', 'is_not_greater_than',
							'is_greater_than_or_equal_to', 'is_less_than_or_equal_to',
							'is_empty', 'is_not_empty', 'is_set', 'is_not_set', 'within', 'not_within' ],
				hasvalue: true,
				hasend: false
			},

	text: 	{
				operators: ['equals', 'does_not_equal' , 'is_greater_than', 'is_not_greater_than',
							'is_greater_than_or_equal_to', 'is_less_than_or_equal_to',
							'is_empty', 'is_not_empty', 'is_set', 'is_not_set', 'within', 'not_within' ],
				hasvalue: true,
				hasend: false
			},

	textarea: 	{
				operators: ['equals', 'does_not_equal' , 'starts_with', 'ends_with',
							'contains', 'does_not_contain' , 'is_empty', 'is_not_empty',
							'is_set', 'is_not_set' ],
				hasvalue: true,
				hasend: false
			},

	time_picker: 	{
				operators: ['equals', 'does_not_equal' , 'is_greater_than', 'is_not_greater_than',
							'is_greater_than_or_equal_to', 'is_less_than_or_equal_to',
							'is_empty', 'is_not_empty', 'is_set', 'is_not_set', 'within', 'not_within' ],
				hasvalue: true,
				hasend: false
			},

	true_false: 	{
				operators: [ 'is_set' , 'is_not_set' ],
				hasvalue: true,
				hasend: false
			},

	url: 	{
				operators: ['equals', 'does_not_equal' , 'starts_with', 'ends_with',
							'contains', 'does_not_contain' , 'is_empty', 'is_not_empty',
							'is_set', 'is_not_set' ],
				hasvalue: true,
				hasend: false
			},

	user: 	{
				operators: [ 'equals', 'does_not_equal', 'is_set' , 'is_not_set' ],
				hasvalue: false,
				hasend: false
			},

	wysiwyg: 	{
				operators: ['equals', 'does_not_equal' , 'starts_with', 'ends_with',
							'contains', 'does_not_contain' , 'is_empty', 'is_not_empty',
							'is_set', 'is_not_set' ],
				hasvalue: true,
				hasend: false
			}

};



addRuleTypeCategory( 'easyacf', {
    label: easy_acf_js_translations.__.easy_acf
});


addRuleType('easyacf/settings-field', {
    label: easy_acf_js_translations.__.easy_acf_field,
    category: 'easyacf',
	form: function form(_ref) {
		var rule = _ref.rule;
		var taxonomy = rule.taxonomy;
		var fieldtype = rule.fieldtype;
		var operator = rule.operator;

		var fieldoperators = easyacf_fieldoperators;

		return {
			fieldtype: {
				type: 'select',
				route: 'bb-logic/v1/easyacf/fieldtypes',

			},
			key: {
				type: 'select',
				route: fieldtype ? 'bb-logic/v1/easyacf/fields?fieldtype=' + fieldtype : null,
				visible: fieldtype,
			},
			operator: {
				type: 'operator',
				operators: ( fieldtype in fieldoperators ) ? fieldoperators[ fieldtype ].operators : ['equals', 'does_not_equal' , 'starts_with', 'ends_with', 'is_less_than' , 'is_less_than_or_equal_to' , 'is_greater_than' , 'is_greater_than_or_equal_to' , 'is_set', 'is_not_set' ],
				visible: fieldtype,
			},
            compare: {
                type: 'text',
                placeholder: easy_acf_js_translations.__.field_value,
				visible: fieldtype && ( fieldtype in fieldoperators ) && ( ![ 'within' , 'not_within' , 'is_set', 'is_not_set', 'is_empty' , 'is_not_empty' ].includes(operator) ) ? fieldoperators[ fieldtype].hasvalue : false,
            },
            start: {
                type: 'text',
                placeholder: easy_acf_js_translations.__.start_value,
				visible: fieldtype && ( operator == 'within' || operator == 'not_within' ) ? true : false,
            },
            end: {
                type: 'text',
                placeholder: easy_acf_js_translations.__.end_value,
				visible: fieldtype && ( operator == 'within' || operator == 'not_within' ) ? true : false,
            }

		};
	}
});


/* same rules but for option */
addRuleType('easyacf/option-field', {
    label: easy_acf_js_translations.__.easy_acf_option_field,
    category: 'easyacf',
	form: function form(_ref) {
		var rule = _ref.rule;
		var taxonomy = rule.taxonomy;
		var fieldtype = rule.fieldtype;
		var operator = rule.operator;

		var fieldoperators = easyacf_fieldoperators;

		return {
			fieldtype: {
				type: 'select',
				route: 'bb-logic/v1/easyacf/fieldtypes',

			},
			key: {
				type: 'select',
				route: fieldtype ? 'bb-logic/v1/easyacf/fields?fieldtype=' + fieldtype : null,
				visible: fieldtype,
			},
			operator: {
				type: 'operator',
				operators: ( fieldtype in fieldoperators ) ? fieldoperators[ fieldtype ].operators : ['equals', 'does_not_equal' , 'starts_with', 'ends_with', 'is_less_than' , 'is_less_than_or_equal_to' , 'is_greater_than' , 'is_greater_than_or_equal_to' , 'is_set', 'is_not_set' ],
				visible: fieldtype,
			},
            compare: {
                type: 'text',
                placeholder: easy_acf_js_translations.__.field_value,
				visible: fieldtype && ( fieldtype in fieldoperators ) && ( ![ 'within' , 'not_within' , 'is_set', 'is_not_set', 'is_empty' , 'is_not_empty' ].includes(operator) ) ? fieldoperators[ fieldtype].hasvalue : false,
            },
            start: {
                type: 'text',
                placeholder: easy_acf_js_translations.__.start_value,
				visible: fieldtype && ( operator == 'within' || operator == 'not_within' ) ? true : false,
            },
            end: {
                type: 'text',
                placeholder: easy_acf_js_translations.__.end_value,
				visible: fieldtype && ( operator == 'within' || operator == 'not_within' ) ? true : false,
            }

		};
	}
});
