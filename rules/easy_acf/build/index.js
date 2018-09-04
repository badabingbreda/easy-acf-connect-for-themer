var addRuleTypeCategory = BBLogic.api.addRuleTypeCategory,
    addRuleType = BBLogic.api.addRuleType,
    getFormPreset = BBLogic.api.getFormPreset,
    __ = BBLogic.i18n.__;


addRuleTypeCategory('easyacf', {
    label: __('Easy ACF')
});


addRuleType('easyacf/settings-field', {
    label: __('Easy ACF Field'),
    category: 'easyacf',
	form: function form(_ref) {
		var rule = _ref.rule;
		var taxonomy = rule.taxonomy;

		return {
			key: {
				type: 'select',
				route: 'bb-logic/v1/easyacf/fields'
			},
			operator: {
				type: 'operator',
				operators: ['equals', 'does_not_equal' , 'starts_with', 'ends_with', 'is_less_than' , 'is_less_than_or_equal_to' , 'is_greater_than' , 'is_greater_than_or_equal_to'  ]
			},
            compare: {
                type: 'text',
                placeholder: __('Value')
            }
		};
	}
});
